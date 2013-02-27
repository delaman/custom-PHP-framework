<?php

require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject {

    protected static $table_name = "users";
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
     * This will validate the user information.  It first finds the usernames
     * salt and then encryptes the $password into hash.  Once the hash
     * is made it then submits another query and verifies the user.
     *
     * @global <type> $database The global $database.
     * @param <type> $username unencrypted username.
     * @param <type> $password unencrypted password.
     * @return <User> The user information if the password and
     * username check out ok.
     */
    public static function authenticate($username="", $password="") {

        global $database;

        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        /* Go get the salt from the database. */
        $sql_salt  = "SELECT salt FROM users ";
        $sql_salt .=  "WHERE username = '{$username}' ";
        $sql_salt .= "LIMIT 1";
        $result_array_salt = self::find_by_sql($sql_salt);

        /* Shift the array. */
        $result_array_salt = !empty($result_array_salt) ? array_shift($result_array_salt) : false;

        /* Check to see if a salt was found. */
        if($result_array_salt) {

            /* Get the salt variable only. */
            $salt = $result_array_salt->salt;
            /* Produce the salted password */
            $password = session_hash($password, $salt);

            /* Query to verify the user. */
            $sql  = "SELECT * FROM users ";
            $sql .= "WHERE username = '{$username}' ";
            $sql .= "AND password = '{$password}' ";
            $sql .= "LIMIT 1";

            /* Verify the password is a good one. */
            $result_array = self::find_by_sql($sql);

            /* Shifts the array if the user is good to go otherwise return false. */
            return !empty($result_array) ? array_shift($result_array) : false;
        }
        else
            return false;


    }

    /**
     *
     * @global <object> $database
     * @return <bool> This will return true if the cookie information is correct,
     * false otherwise.
     */
    public static function authenticate_by_cookie() {

        global $database;

        /* Check if a cookie exists */
        if( isset($_COOKIE['username']) && isset($_COOKIE['password']) ) {

            $username = $database->escape_value($_COOKIE['username']);
            $password = $database->escape_value($_COOKIE['password']);

            $sql  = "SELECT * FROM users ";
            $sql .= "WHERE username = '{$username}' ";
            $sql .= "AND password = '{$password}' ";
            $sql .= "LIMIT 1";

            $result_array = self::find_by_sql($sql);

            return !empty($result_array) ? true : false;

        } else {

            return false;
        }

    }

    public static function find_all_by_employees() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " WHERE employeeID > 0;");
    }

    public static function find_all_by_contacts() {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " WHERE clientID > 0;");
    }

}
?>
