<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template('header.php'); ?>

<?php

/* Open the file. */
$handle = fopen("filemaker3.csv","r");

/* Go through every line in the file. */
while(($data = fgetcsv($handle)) !== FALSE) {

    $contact = new Contact();
    $item = new Item();

    /* Clean the data first */
    for($i=0;$i<=27;$i++) {

        if($i==14)
            continue;

        if($i==19 || $i==20)
            $data[$i] = ereg_replace("[^0-9$]", "", $data[$i]);
        else
            $data[$i] = ereg_replace("[^A-Za-z0-9@.,$ ]", "", $data[$i]);
    }


    $pos = strpos($data[14],"-");
    $idNumber = substr($data[14],$pos+1);

    $contact->itemNumberIndex = 1;
    /* Name */
    $contact->name1 = $data[3];
    /* Email */
    $contact->email = $data[11];

    /* Telephone main */
    $contact->phone1 = substr($data[19],0,3);
    $contact->phone2 = substr($data[19],3,3);
    $contact->phone3 = substr($data[19],6,4);
    /* Telephone alternative */

    $contact->phone4 = substr($data[20],0,3);
    $contact->phone5 = substr($data[20],3,3);
    $contact->phone6 = substr($data[20],6,4);

    $contactFound = $contact->search_for_dupe();
    
    if($contactFound) {
        /* Found one that was in the database. */
        $item->contactID = $contactFound->id;
        $item->itemNumber = strval($contactFound->id*100) . "-" . $idNumber;

        
        if((int)$contactFound->itemNumberIndex > (int)$idNumber) {
           
        }else
            $contactFound->itemNumberIndex = (int)$idNumber + 1;

        $contactFound->update();

    } else {

        $contact->create();
        $contact->itemNumberIndex = $contact->itemNumberIndex + 1;
        $contact->update();

        $item->contactID = $contact->id;
        $item->itemNumber = strval($contact->id*100) . "-" . $idNumber;

        /*** Address ***/
        $address = new Address();
        $address->contactID = $contact->id;
        $address->type = "billing";
        $address->role = 1;
        $address->address1 = $data[0];
        $address->address2 = "";
        $address->city = $data[2];
        $address->state = $data[22];
        $address->postcode = $data[27];
        $address->create();
    }

    
    $item->artist = $data[1];
    $item->title = $data[23];
    $item->medium = $data[16];
    $item->insuredBy = $data[12];
    $item->value = (int)$data[26];
    $item->location = $data[15];
    $item->transportation = $data[25];
    $item->create();

    mkdir(SITE_ROOT .DS. 'images' .DS . $item->itemNumber );

    $filename = "/home/pedro/public_html/ty/public_html/ty/" . $data[14] . ".jpg";

    /* Photograph */
    if(file_exists($filename)) {


        $photograph = new Photograph();

        $photograph->itemID = $item->id;
        $photograph->filename = $data[14] . ".jpg";
        $photograph->type = "image/jpeg";
        $photograph->size = filesize($filename);


        // Determine the target_path
        $target_path = SITE_ROOT .DS. "images".DS . $item->itemNumber . DS . basename($filename);
        $target_path_thumbnailSmall = SITE_ROOT .DS. "images".DS . $item->itemNumber . DS . "thumbnailSmall-" .basename($filename);
        $target_path_thumbnailBig = SITE_ROOT .DS. "images".DS . $item->itemNumber . DS . "thumbnailBig-" .basename($filename);

        copy($filename,$target_path);
        photoCreateCropThumb($target_path_thumbnailSmall, $target_path, 100);
        photoCreateCropThumb($target_path_thumbnailBig, $target_path, 400);

        $photograph->create();

    }



    /**************** Condition Report ********************/


    if($data[4] != "") {
        $conditionReport = new ConditionReport();
        $conditionReport->itemID = $item->id;
        $conditionReport->report = "";
        $conditionReport->time = time();
        $conditionReport->author = $data[4];
        $conditionReport->filename = "";
        $conditionReport->type = "";
        $conditionReport->create();
    }

    /******************* Make notes ******************/

    /* Note Date History */
    if($data[8] != "") {
        $itemNoteDateHistory = new ItemNote();
        $itemNoteDateHistory->itemID = $item->id;
        $itemNoteDateHistory->time = time();
        $itemNoteDateHistory->author= "System Admin";
        $itemNoteDateHistory->note = $data[8];
        $itemNoteDateHistory->create();
    }

    /* Note Item Dimensions */
    if($data[13] != "") {
        $itemNoteItemDimensions = new ItemNote();
        $itemNoteItemDimensions->itemID = $item->id;
        $itemNoteItemDimensions->time = time();
        $itemNoteItemDimensions->author= "System Admin";
        $itemNoteItemDimensions->note = "[Item dimensions] " . $data[13];
        $itemNoteItemDimensions->create();
    }

    /* Note Packed Dimensions */
    if($data[18] != "") {
        $itemNotePackedDimensions = new ItemNote();
        $itemNotePackedDimensions->itemID = $item->id;
        $itemNotePackedDimensions->time = time();
        $itemNotePackedDimensions->author= "System Admin";
        $itemNotePackedDimensions->note = "[Packed dimensions] " . $data[18];
        $itemNotePackedDimensions->create();
    }

    /* Note Contact */
    if($data[5] != "") {
        $itemNoteContact = new ItemNote();
        $itemNoteContact->itemID = $item->id;
        $itemNoteContact->time = time();
        $itemNoteContact->author= "System Admin";
        $itemNoteContact->note = "[Contact] " . $data[5];
        $itemNoteContact->create();
    }

    /* Note Sub-Client */
    if($data[21] != "") {
        $itemNoteContact = new ItemNote();
        $itemNoteContact->itemID = $item->id;
        $itemNoteContact->time = time();
        $itemNoteContact->author= "System Admin";
        $itemNoteContact->note = "[Sub-Client] " . $data[21];
        $itemNoteContact->create();
    }

    /* Note Value */
    if($data[26] != "") {
        $itemNoteContact = new ItemNote();
        $itemNoteContact->itemID = $item->id;
        $itemNoteContact->time = time();
        $itemNoteContact->author= "System Admin";
        $itemNoteContact->note = "[Value] " . $data[26];
        $itemNoteContact->create();
    }


} /* while loop */

/* Close the file. */
fclose($handle);

//
//$pattern ="/^(\()?(713|281)(\)|-)?([0-9]{3})(-)?([0-9]{4}|[0-9]{4})$/";
//preg_match($pattern,"7134536475",$matches);
//
//print_r($matches);
?>

<?php
/******************* Functions here *******************/


function parseName($fullName) {

    $name = array();

    /* find First name */
    $firstnamePosition = strpos($fullName," ");
    /* find Last name */
    $lastnamePosition = strrpos($fullName," ");

    $name[] = substr($fullName, 0, $firstnamePosition);
    $name[] = substr($fullName, $firstnamePosition+1, strlen($fullName) - $lastnamePosition);
    $name[] = substr($fullName, $lastnamePosition);

    return $name;
}

function parseTelephone($fullTelephone) {

    $phone = array();

    $i = 0;

    /* Find the first number */
    for($i=0;$i<=strlen($fullTelephone);$i++)
        if(is_finite($fullTelephone[$i]))
            break;

    /* Starting position */
    $startPosition = $i;

    for($j=$i;$j<=strlen($fullTelephone);$j++)
        if($fullTelephone[$j]=="-" || $fullTelephone[$j]=="." )
            break;

    $phone[] = substr($fullTelephone,$startPosition,3);


    $startPosition = $j+1;

    for($k=$j;$k<=strlen($fullTelephone);$k++)
        if($fullTelephone[$k]=="-" || $fullTelephone[$k]=="." )
            break;

    $phone[] = substr($fullTelephone,$startPosition,3);

    $phone[] =  substr($fullTelephone,$startPosition+1+3,4);

    return $phone;
}


?>



<?php include_layout_template('footer.php'); ?>