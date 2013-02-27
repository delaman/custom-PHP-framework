<?php

class Session {

    private $logged_in=false;
    public $user_id;
    public $username;
    public $message;
    public $employeeID;
    public $role;

    function __construct() {

        session_start();
        $this->check_message();
        $this->check_login();

        if($this->logged_in) {
            // actions to take right away if user is logged in
        } else {
            // actions to take right away if user is not logged in
        }
    }

    public function is_logged_in() {
        return $this->logged_in;
    }

    /*
     * $user is an object.
     *
     * This method is AFTER the $user is authenticated.
     * It will also set the cookie only after the $user is autehnticated;
    */
    public function login($user) {
        // database should find user based on username/password
        if($user) {

            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->employeeID = $_SESSION['employeeID'] = $user->employeeID;
            $this->clientID = $_SESSION['clientID'] = $user->clientID;  // added
            $this->role = $_SESSION['role'] = $user->role; // added
            $this->username = $_SESSION['username'] = $user->username; // added

            /* Set cookie */
            //setcookie('user_id',  $user->id, 0x7fffffff);
            setcookie('username',  $user->username, 0x7fffffff);
            setcookie('password',  $user->password, 0x7fffffff);
            setcookie('employeeID',  $user->employeeID, 0x7fffffff);
            setcookie('clientID',  $user->clientID, 0x7fffffff);
            setcookie('role',  $this->role, 0x7fffffff);

            $this->logged_in = true;
        }
    }

    /**
     * Clear out the session and cookies.
     */
    public function logout() {

        unset($_SESSION['user_id']);
        setcookie('user_id', NULL, time() - 3600);
        unset($_COOKIE['user_id']);
        unset($this->user_id);

        unset($_SESSION['username']);
        setcookie('username', NULL, time() - 3600);
        unset($_COOKIE['username']);
        unset($this->username);

        unset($_SESSION['password']);
        setcookie('password', NULL, time() - 3600);
        unset($_COOKIE['password']);
        unset($this->password);

        unset($_SESSION['employeeID']);
        setcookie('employeeID', NULL, time() - 3600);
        unset($_COOKIE['employeeID']);
        unset($this->employeeID);

        unset($_SESSION['clientID']);
        setcookie('clientID', NULL, time() - 3600);
        unset($_COOKIE['clientID']);
        unset($this->clientID);

        unset($_SESSION['role']);
        setcookie('role', NULL, time() - 3600);
        unset($_COOKIE['role']);
        unset($this->role);

        /* Delete ALL the objects that are in the cookie */
        $this->delete_all_objects_from_cookie();

        $this->logged_in = false;
    }

    /**
     *
     * @param <string> $msg
     * @return <string>
     *
     * Set or returns the message that is used
     * for sessions.  Things like "You eneterd the incorrect page",
     * "restricted access". etc.
     */
    public function message($msg="") {
        if(!empty($msg)) {
            // then this is "set message"
            $_SESSION['message'] = $msg;
        } else {
            // then this is "get message"
            return $this->message;
        }
    }

    /**
     *
     * @param <type> $object
     * @return <type>
     *
     * Serializes the object and sets it to the session variable
     */
    public function store_object_in_cookie($object,$name) {

        if(!empty($object) && !empty($name))
            setcookie( "objects[$name]" , serialize($object), 0x7fffffff );

    }


    /**
     * This method is called every time a page is executed.
     * It first checks to see if the cookie information is good.  If the cookie
     * information is good the $session object variables are set.
     */
    private function check_login() {

        if( User::authenticate_by_cookie() ) {
            /*
             * Check if the cookie information is correct via the database,
             * otherwise anyone can enter someones user_Id, role and employeeID
             * into a given cookie and access their session.
            */

//            $this->user_id = $_COOKIE['user_id'];
            $this->employeeID = $_COOKIE['employeeID'];
            $this->role = $_COOKIE['role']; // changed
            $this->username = $_COOKIE['username'];
            $this->logged_in = true;


        } else {

//            unset($this->user_id);
            unset($this->employeeID);
            unset($this->role);
            //unset($this->object);
            $this->logged_in = false;

        }
    }

    /*
     * TODO: need to rewrite
    */
    private function check_message() {
        // Is there a message stored in the session?
        if(isset($_SESSION['message'])) {
            // Add it as an attribute and erase the stored version
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    /**
     *
     * @return <object> Returns the object
     *
     */
    public function get_object_from_cookie($name) {

        if(isset($_COOKIE['objects'][$name]))
            return unserialize(stripslashes($_COOKIE["objects"][$name]));
        else
            return NULL;

    }


    public function delete_object_from_cookie($name) {

        if(isset($_COOKIE[$name][$name])) {
            setcookie("objects[$name]", NULL, time() - 3600);
            unset($_COOKIE['objects'][$name]);
        }
    }
    
    /**
     * Deletes all the objects from a cookie.
     *
     * @param <void> void
     * @return void
     */
    public function delete_all_objects_from_cookie() {

        if(isset($_COOKIE['objects'])) {
            foreach($_COOKIE['objects'] as $name => $value) {
                setcookie("objects[$name]", NULL, time() - 3600);
                unset($_COOKIE['objects'][$name]);
            }
        }
    }

}



?>