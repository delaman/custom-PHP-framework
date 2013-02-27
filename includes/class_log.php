<?php

require_once(LIB_PATH.DS.'database.php');

class Log extends DatabaseObject {

    protected static $table_name = "mylog";
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
     * Will set the timestamp into a pretty formatted output.
     *
     * @return <string> formated time
     */
    public function get_time() {
        return date("F j, Y, g:i a", $this->time);
    }

    /**
     * This is the background color for the main log.
     *
     * @return <string> background color
     */
    public function color_bg() {

        if($this->priority == 0)
            return "#CFCFCF"; // greyish
        if($this->priority == 1)
            return "#FF7E00"; // orange
        if($this->priority == 2)
            return "#FF0028"; // red

    }

    /**
     * This will choose what color font to use for the logs.
     *
     * @return <string> font color
     */
    public function color() {

        if($this->priority == 0)
            return "#125D03"; // green
        if($this->priority == 1)
            return "#FFFFFF"; // white
        if($this->priority == 2)
            return "#FFFFFF"; // white

    }

    public function style_class() {

        if($this->priority == 0)
            return "priority00";
        if($this->priority == 1)
            return "priority01";
        if($this->priority == 2)
            return "priority02";
    }

    /**
     * Gets the information for a given page.
     *
     * @param <int> $page
     * @param <Pagination> $pagination Object that holds the pagination information.
     * @return <Log> Logs for a given page.
     */
    public static function find_all_by_page($page,$pagination) {

        /* Return only results for the respected page. */
        $sql  = "SELECT * FROM " . self::$table_name ;
        $sql .= " ORDER BY time DESC ";
        $sql .= "LIMIT {$pagination->per_page} ";
        $sql .= "OFFSET {$pagination->offset()}; ";

        return self::find_by_sql($sql);
    }
}
?>