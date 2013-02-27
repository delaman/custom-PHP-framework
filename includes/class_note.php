<?php

require_once(LIB_PATH.DS.'database.php');

class ItemNote extends DatabaseObject {

    protected static $table_name = "items_notes";
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

    public static function find_all_by_itemID($itemID) {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " WHERE itemID=$itemID ORDER BY time DESC;");
    }

    /**
     * Returns the time that is stored in the database.
     * This is to say it converts the database UNIX timestamp
     * to plain-o human format.
     *
     * @return <string> Format date and time.
     */
    public function get_time() {
        return date("F j, Y, g:i a", $this->time);
    }

}
?>