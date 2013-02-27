<?php

require_once(LIB_PATH.DS.'database.php');

class Contact extends DatabaseObject {

    protected static $table_name = "contacts";
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

    /**
     *
     * Search for clients in the database.
     *
     * @return <Client> returns an array of objects clients
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

                    $sql .= $db_field . " LIKE " . "'%" . $this->$db_field . "%'" . " ";
                } else {
                    $sql .= " AND " . $db_field . " LIKE " . "'%" . $this->$db_field . "%'" . " ";
                }

                $counter = $counter + 1;
            }
        }

        return self::find_by_sql($sql);
    }

    public function full_telephone_number() {

        if($this->phone1 != 0 && $this->phone2 != 0 && $this->phone3 != 0)
            return "(" . $this->phone1 . ") " . $this->phone2 . "-" . $this->phone3 ;
        else {
            return "";
        }

    }

    /**
     * Alternative phonenumber
     *
     * @return <string> Formated alternative telephone number or if the number is not set
     * the return nothing.
     */
    public function full_telephone_number2() {

        if($this->phone4 != 0 && $this->phone5 != 0 && $this->phone6 != 0)
            return "(" . $this->phone4 . ") " . $this->phone5 . "-" . $this->phone6 ;
        else {
            return "";
        }

    }

    public function full_name() {

        if(isset($this->name1))
            return $this->name1;
        else
            return "";
    }

    /**
     * Sorts by the firstname.
     *
     * @return <Contact> array of objects
     */
    public static function find_all() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " ORDER BY name1;");
    }


    public function increment_itemNumberIndex() {

        global $database;

        $sql = "UPDATE contacts SET itemNumberIndex=itemNumberIndex+1 WHERE id={$this->id}";

        $database->query($sql);
    }


    public function search_for_dupe() {

        global $database;
        $sql = "SELECT * FROM " . static::$table_name . " WHERE name1='{$this->name1}' LIMIT 1;";
        $result_set = $database->query($sql);
        $object_array = array();

        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }

        return !empty($object_array) ? array_shift($object_array) : false;
    }

}
?>
