<?php
// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class ConditionReport extends DatabaseObject {

    protected static $table_name="conditionReports";
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

    private $temp_path;
    protected $upload_dir="conditionReports";
    public $errors=array();

    protected $upload_errors = array(
            // http://www.php.net/manual/en/features.file-upload.errors.php
            UPLOAD_ERR_OK 				=> "No errors.",
            UPLOAD_ERR_INI_SIZE            => "Larger than upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE        => "Larger than form MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL           => "Partial upload.",
            UPLOAD_ERR_NO_FILE 		  => "No file.",
            UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
            UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
            UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
    );

    // Pass in $_FILE(['uploaded_file']) as an argument
    public function attach_file($file) {

        // Perform error checking on the form parameters
        if(!$file || empty($file) || !is_array($file)) {
            // error: nothing uploaded or wrong argument usage
            $this->errors[] = "No file was uploaded.";
            return false;
        } elseif($file['error'] != 0) {
            // error: report what PHP says went wrong
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        } else {
            // Set object attributes to the form parameters.
            $this->temp_path  = $file['tmp_name'];
            $this->filename   = basename($file['name']);
            $this->type       = $file['type'];
            $this->size       = $file['size'];
            // Don't worry about saving anything to the database yet.
            return true;

        }
    }

    public function save() {
        // A new record won't have an id yet.
        if(false) {
            // Really just to update the caption
            $this->update();
        } else {
            // Make sure there are no errors
            // Can't save if there are pre-existing errors
            if(!empty($this->errors)) {
                print_r($this->errors);
                return false;
            }


            // Can't save without filename and temp location
            if(empty($this->filename) || empty($this->temp_path)) {
                $this->errors[] = "The file location was not available.";
                return false;
            }

            $item = Item::find_by_id($this->itemID);

            // Determine the target_path
            $target_path = SITE_ROOT .DS. $this->upload_dir .DS . $item->itemNumber . DS . $this->filename;

            // Make sure a file doesn't already exist in the target location
            if(file_exists($target_path)) {
                $this->errors[] = "The file {$this->filename} already exists.";
                return false;
            }

            // Attempt to move the file
            if(move_uploaded_file($this->temp_path, $target_path)) {
                // Success
                // Save a corresponding entry to the database
                if($this->create()) {
                    // We are done with temp_path, the file isn't there anymore
                    unset($this->temp_path);
                    return true;
                }
            } else {
                // File was not moved.
                $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
                return false;
            }
        }
    }

    public function destroy() {

        $item = Item::find_by_id($this->itemID);

        // First remove the database entry
        if($this->delete()) {
            // then remove the file
            // Note that even though the database entry is gone, this object
            // is still around (which lets us use $this->image_path()).
            $target_path = SITE_ROOT .DS. $this->upload_dir .DS . $item->itemNumber . DS . $this->filename;
            return unlink($target_path) ? true : false;
        } else {
            // database delete failed
            return false;
        }
    }

    public function att_path() {

        $item = Item::find_by_id($this->itemID);

        if(isset($this->itemID) && isset($this->filename))
            return  "../" . $this->upload_dir . DS . $item->itemNumber . DS .$this->filename;
        else
            return "#";
    }

    public function size_as_text() {
        if($this->size < 1024) {
            return "{$this->size} bytes";
        } elseif($this->size < 1048576) {
            $size_kb = round($this->size/1024);
            return "{$size_kb} KB";
        } else {
            $size_mb = round($this->size/1048576, 1);
            return "{$size_mb} MB";
        }
    }

    public function comments() {
        return Comment::find_comments_on($this->id);
    }

    public static function find_all_by_itemID($itemID) {
        return static::find_by_sql("SELECT * FROM ".static::$table_name . " WHERE itemID=$itemID;");
    }

    public static function find_by_itemID($itemID) {
        $result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE itemID={$itemID} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function make_directory($itemID) {
        mkdir(SITE_ROOT .DS. $this->upload_dir .DS . $itemID);
    }

    public function get_time() {
        return date("F j, Y, g:i a", $this->time);
    }

}

?>