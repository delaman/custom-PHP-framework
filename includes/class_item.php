<?php

require_once(LIB_PATH.DS.'database.php');

class Item extends DatabaseObject {

    protected static $table_name = "items";
    protected static $db_fields = array();

    /* Abstracted to get the database fields and declare them */
    function __construct() {

        global $database;

        /* Setup the query to get the field names */
        $sql = "SELECT * FROM " . static::$table_name . " LIMIT 1";
        /* Run the query */
        $result_set = $database->query($sql);
        /* Get amount of fields */
        $fields_num = $database->num_fields($result_set);

        /* Setup the array field names */
        for($i=0; $i<$fields_num; $i++) {
            $result = $database->fetch_fields($result_set,$i);
            static::$db_fields[$i] = $result->name;
        }

        /* Setup variables */
        foreach(static::$db_fields as $field)
            $this->$field = $field;

    }

    public $valueSign = "";
    public $lengthSign = "";
    public $widthSign = "";
    public $heightSign = "";

    public static function find_by_contactID($id=0) {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " WHERE contactID = " . $id . " ORDER BY itemNumber;");
    }

    /**
     *
     * Search for items in the database.
     *
     * @return <Item> returns an array of objects clients
     */
    public function search() {

        $counter = 1;

        /* SQL statement, will be appeneded to later in this function */
        $sql = "SELECT * FROM " . self::$table_name;

        /*
         * Go through each database fields and select only the good non empty
         * elements.
        */
        foreach(self::$db_fields as $db_field) {

            /* Skip the 'id' field, also get only the good fields */
            if($this->$db_field == NULL || $this->$db_field == "id")
                continue;
            else {

                /* Fix for the first AND statement */
                if($counter == 1) {

                    $sql .= " WHERE ";

                    /* Choose the FIRST correct expression */
                    if($db_field =="value" )
                        $sql .= $db_field . " " . $this->valueSign . " {$this->$db_field} " ;
                    else if($db_field =="length")
                        $sql .= $db_field . " " . $this->lengthSign . " {$this->$db_field} " ;
                    else if($db_field =="width")
                        $sql .= $db_field . " " . $this->widthSign . " {$this->$db_field} " ;
                    else if($db_field =="height")
                        $sql .= $db_field . " " . $this->heightSign . " {$this->$db_field} " ;
                    else
                        $sql .= $db_field . " LIKE " . "'%" . $this->$db_field . "%'" . " ";

                } else {

                    /* Choose the correct expression */
                    if($db_field =="value")
                        $sql .= " AND " . $db_field . " " . $this->valueSign . " {$this->$db_field} " ;
                    else if($db_field =="length")
                        $sql .= " AND " . $db_field . " " . $this->lengthSign . " {$this->$db_field} " ;
                    else if($db_field =="width")
                        $sql .= " AND " . $db_field . " " . $this->widthSign . " {$this->$db_field} " ;
                    else if($db_field =="height")
                        $sql .= " AND " . $db_field . " " . $this->heightSign . " {$this->$db_field} " ;
                    else
                        $sql .= " AND " . $db_field . " LIKE " . "'%" . $this->$db_field . "%'" . " ";

                }

                $counter = $counter + 1;
            }
        }

        $sql .=  " ORDER BY itemNumber;";

        return self::find_by_sql($sql);
    }


    /**
     * Output the artist.  If the artist is to long then it will make it shorter.
     *
     * @param <string> $length How long the artist name should be.
     * @return <string> output of $this->artist
     */
    public function get_artist_abr($length) {

        if(strlen($this->artist) > $length)
            return substr($this->artist, 0, $length) . "...";
        else
            return $this->artist;

    }

    /**
     * Output the title.  If the title is to long then it will make it shorter.
     *
     * @param <string> $length How long the title name should be.
     * @return <string> output of $this->title
     */
    public function get_title_abr($length) {

        if(strlen($this->title) > $length)
            return substr($this->title, 0, $length) . "...";
        else
            return $this->title;

    }

    /**
     * Output the medium.  If the medium is to long then it will make it shorter.
     *
     * @param <string> $length How long the medium name should be.
     * @return <string> output of $this->medium
     */
    public function get_medium_abr($length) {

        if(strlen($this->medium) > $length)
            return substr($this->medium, 0, $length) . "...";
        else
            return $this->medium;

    }

    /**
     * Make an itemNumber from the first and lastname of a person.
     *
     * ie.  Pedro de la Cruz
     *      Will make DELAP-33
     */
    public function make_itemNumber() {

//        /* Get contact information */
//        $contact = Contact::find_by_id($this->contactID);
//
//        /* Search for empty spaces in the lastname and replace it with "". */
//        $name2 = str_replace(" ", "", $contact->name2);
//
//        /* First four letters of $name2 */
//        $name2 = substr($name2,0,4);
//
//        $itemNumberIndex = sprintf("%03d", $contact->itemNumberIndex);
//
//        /* Make the itemNumber */
//        $this->itemNumber = $name2 . $contact->name1[0] . "-" . $itemNumberIndex ;
//
//        /* Increment the itemNumberIndex for next time use. */
//        $contact->increment_itemNumberIndex();
//
//        /* Make uppercase */
//        $this->itemNumber = strtoupper($this->itemNumber);

        /* Get contact information. */
        $contact = Contact::find_by_id($this->contactID);

        /* Format the index correctly. */
        $itemNumberIndex = sprintf("%03d", $contact->itemNumberIndex);

        $this->itemNumber = strval($contact->id * 100) . "-" . $itemNumberIndex;

        /* Increment the itemNumberIndex for next time use. */
        $contact->increment_itemNumberIndex();

    }

    /**
     * Set that the inventory is inside the warehouse.
     *
     * @return <bool> True if the query executed correctly false otherwise.
     */
    public function set_inventory_in() {
        $this->inInventory = 1;
        return $this->update();
    }

    /**
     * Set that the inventory is outside the warehouse.
     *
     * @return <bool> True if the query executed correctly false otherwise.
     */
    public function set_inventory_out() {
        $this->inInventory = 0;
        return $this->update();
    }

    public function destroy() {

        $item = Item::find_by_id($this->itemID);

        // First remove the database entry
        if($this->delete()) {
            // then remove the file
            // Note that even though the database entry is gone, this object
            // is still around (which lets us use $this->image_path()).
            //$target_path = SITE_ROOT .DS. $this->upload_dir .DS . $item->itemNumber . DS . $this->filename;
            //return unlink($target_path) ? true : false;
        } else {
            // database delete failed
            return false;
        }
    }
}
?>
