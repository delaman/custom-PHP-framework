<?php

require_once(LIB_PATH.DS.'database.php');

class Address extends DatabaseObject {

    protected static $table_name = "addresses";
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

    public static function find_by_contactID($id=0) {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " WHERE ContactID = " . $id . " ORDER BY role DESC ;");
    }

    /**
     * This will make a given record a 'default' type.
     *
     * @param <int> $id The record number
     */
    private static function make_default_address_by_id($id) {

        $address = self::find_by_id($id);
        /* Set default value. */
        $address->role = 0;
        $address->update();

    }

    /**
     * This will lookup all the contact address and make them ALL
     * of 'default' type.
     *
     * @param <int> $contactID The contact id record number.
     */
    public static function make_all_default_addresses_by_contactID($contactID) {

        $addresses = self::find_by_contactID($contactID);

        /* Make ALL the contact addresses 'default' type. */
        foreach($addresses as $address)
            self::make_default_address_by_id($address->id);

    }

    /**
     * Makes the object the only billing address type.  It does this by checking
     * if there are any other addresses for a given contact and makes them
     * all of 'default' type.  After that and only after that will it makes $this object
     * address the billing type.
     */
    public function make_billing() {

        /* First make all the address of type 'defult'. */
        self::make_all_default_addresses_by_contactID($this->contactID);

        /* Second update to make $this record object the billing account. */
        $this->role = 1;

        return $this->update();
    }

}
?>