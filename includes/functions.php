<?php

function strip_zeros_from_date( $marked_string="" ) {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to( $location = NULL ) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
        //echo "<meta http-equiv='refresh' content='0;url={$location}'>";
    }
}

function output_message($message="") {
    if (!empty($message)) {
        return "<p class=\"message\">{$message}</p>";
    } else {
        return "";
    }
}


//function __autoload($class_name) {
//    $class_name = strtolower($class_name);
//    $path = LIB_PATH.DS."{$class_name}.php";
//    if(file_exists($path)) {
//        require_once($path);
//    } else {
//        die("The file {$class_name}.php could not be found.");
//    }
//}


function include_layout_template($template="") {
    include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.$template);
}

function session_include_layout_header($session) {

    if($session->role == 1) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'admin_header.php');
    } else if($session->role == 2) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'manager_header.php');
    } else if($session->role == 3) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'operator_header.php');
    } else if($session->role == 4) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'dispatcher_header.php');
    } else if($session->role == 5) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'admin_header.php');
    } else {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'header.php');
    }
}

function session_include_layout_footer($session) {

    if($session->role == 1) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'admin_footer.php');
    } else if($session->role == 2) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'manager_footer.php');
    } else if($session->role == 3) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'operator_footer.php');
    } else if($session->role == 4) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'dispatcher_footer.php');
    } else if($session->role == 5) {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'admin_footer.php');
    } else {
        include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.'footer.php');
    }
}

function session_include_layout_body($session,$template="") {

    if($session->role == 1) {
        include(SITE_ROOT.DS.'levels'.DS.'admin'.DS.$template);
    } else if($session->role == 2) {
        include(SITE_ROOT.DS.'levels'.DS.'manager'.DS.$template);
    } else if($session->role == 3) {
        include(SITE_ROOT.DS.'levels'.DS.'operator'.DS.$template);
    } else if($session->role == 4) {
        include(SITE_ROOT.DS.'levels'.DS.'dispatcher'.DS.$template);
    } else if($session->role == 5) {
        include(SITE_ROOT.DS.'levels'.DS.'admin'.DS.$template);
    }
}


function log_action($action, $message="") {

    $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
    $new = file_exists($logfile) ? false : true;

    if($handle = fopen($logfile, 'a')) { // append
        $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
        $content = "{$timestamp} | {$action}: {$message}\n";
        fwrite($handle, $content);
        fclose($handle);

        if($new) {
            chmod($logfile, 0755);
        }
    } else {
        echo "Could not open log file for writing.";
    }
}

function datetime_to_text($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function getRealIpAddr() {

    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


/**
 * Generate a random key of length $len
 *
 * @param <int> $len How long the random key should be.
 * @param <bool> $readable Should it be human readable.
 * @param <bool> $hash
 * @return <type> Returns a random key.
 */
function random_key($len, $readable = false, $hash = false) {
    $key = '';

    if ($hash)
        $key = substr(sha1(uniqid(rand(), true)), 0, $len);
    else if ($readable) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        for ($i = 0; $i < $len; ++$i)
            $key .= substr($chars, (mt_rand() % strlen($chars)), 1);
    }
    else
        for ($i = 0; $i < $len; ++$i)
            $key .= chr(mt_rand(33, 126));


    return $key;
}

/**
 * Generates a salted, SHA-1 hash of $str
 *
 * @param <string> $str The string to be hashed.
 * @param <string> $salt The salt.
 * @return <string> Salted hashed password of 40 characters.
 */
function session_hash($str, $salt) {
    return sha1($salt.sha1($str));
}


/**
  * Recursively delete a directory.
  *
  * @param string $dir Directory name.
  * @param boolean $deleteRootToo Delete specified top-level directory as well.
  */
function unlinkRecursive($dir, $deleteRootToo) {
    if(!$dh = @opendir($dir)) {
        return;
    }
    while (false !== ($obj = readdir($dh))) {
        if($obj == '.' || $obj == '..') {
            continue;
        }

        if (!@unlink($dir . '/' . $obj)) {
            unlinkRecursive($dir.'/'.$obj, true);
        }
    }

    closedir($dh);

    if ($deleteRootToo) {
        @rmdir($dir);
    }

    return;
}


function photoCreateCropThumb ($p_thumb_file, $p_photo_file, $p_max_size, $p_quality = 75) {

    $pic = @imagecreatefromjpeg($p_photo_file);

    if ($pic) {
        $thumb = @imagecreatetruecolor ($p_max_size, $p_max_size) or die ("Can't create Image!");
        $width = imagesx($pic);
        $height = imagesy($pic);
        if ($width < $height) {
            $twidth = $p_max_size;
            $theight = $twidth * $height / $width;
            imagecopyresized($thumb, $pic, 0, 0, 0, ($height/2)-($width/2), $twidth, $theight, $width, $height);
        } else {
            $theight = $p_max_size;
            $twidth = $theight * $width / $height;
            imagecopyresized($thumb, $pic, 0, 0, ($width/2)-($height/2), 0, $twidth, $theight, $width, $height);
        }

        ImageJPEG ($thumb, $p_thumb_file, $p_quality);
    }

}

?>