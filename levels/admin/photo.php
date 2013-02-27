<?php

$photographID = $_GET['photographID'];
$thumbnail = $_GET['thumbnail'];

$photograph= Photograph::find_by_id($photographID);
$item = Item::find_by_id($photograph->itemID);



if($thumbnail == 0)
    $file_on_harddisk = SITE_ROOT .DS."images".DS . $item->itemNumber . DS . $photograph->filename  ;
else if($thumbnail == 1)
    $file_on_harddisk = SITE_ROOT .DS."images" .DS . $item->itemNumber . DS . "thumbnailSmall-" .$photograph->filename  ;
else if($thumbnail == 2)
    $file_on_harddisk = SITE_ROOT .DS."images".DS . $item->itemNumber . DS . "thumbnailBig-" .$photograph->filename  ;


header( "X-LIGHTTPD-send-file: " . $file_on_harddisk);
header("Content-type: " . $photograph->type);
?>