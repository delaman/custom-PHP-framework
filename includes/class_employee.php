<?php

require_once(LIB_PATH.DS.'database.php');

class Employees extends DatabaseObject {

    protected static $table_name = "employees";
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

    public function full_name() {

        if(isset($this->name1) && isset($this->name2))
            return $this->name1 . " " . $this->name2 ;
        else
            return "";

    }
}
?>