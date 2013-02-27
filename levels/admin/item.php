<?php
/* Get the itemID from the url */
$itemID = $_GET['id'];
/* Get item object */
$item = Item::find_by_id($itemID);
/* Get contactID */
$contactID = $item->contactID;
/* Get contact information */
$contact = Contact::find_by_id($contactID);
/* Get photographs information */
$photograph = Photograph::find_by_itemID($itemID);
/* Get all item notes */
$itemNotes = ItemNote::find_all_by_itemID($itemID);
/* Get all condition reports */
$conditionReports = ConditionReport::find_all_by_itemID($itemID);
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);

?>

<?php
if (isset($_POST['submitItemNote'])) {

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    $itemNote = new ItemNote();
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $itemNote->$key = ${$key};
    }
    $itemNote->time = time();
    $itemNote->author = $employee->full_name();
    $itemNote->itemID = $itemID;

    /* Save new record into database */
    if($itemNote->create()) {

        /* log entry */
        $log = new Log();
        $log->time = time();
        $log->log = "Note made: {$employee->full_name()}, on item <a href=\"item.php?id={$itemID}\">{$itemID}</a>.";
        $log->create();


        /* Success */
        $session->message("Contact added successfully!");
        /* Delete the submit variable */
        unset($_POST['submit']);
        /* Refresh the page */
        redirect_to("item.php?id=$itemID");
    } else {
        /* Failure */
        $session->message("Contact NOT added!");
    }
}
?>



<?php

/* Check if post request has been made */
if (isset($_POST['submitDetails'])) {

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    $item = Item::find_by_id($itemID);
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $item->$key = ${$key};
    }

    /* Update database */
    if($item->update()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Item edited: {$employee->full_name()} edited item number  <a href=\"item.php?id={$item->id}\">{$item->itemNumber}</a>.";
        $log->create();

        $session->message("Item edited successfully!");
        unset($_POST['submit']);
        redirect_to("item.php?id=". $item->id );
    } else {
        /* Failure */
        $session->message("Item NOT edited!");
    }
}
?>

<?php

if (isset($_POST['submitConditionReport'])) {

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    $conditionReport = new ConditionReport();

    if(!isset($_FILES['filename']) || $_FILES['filename']['error'] !== UPLOAD_ERR_OK ) {

        $conditionReport->attach_file($_FILES['filename']);
        $conditionReport->report = $_POST['report'];
        $conditionReport->time = time();
        $conditionReport->author = $employee->full_name();
        $conditionReport->itemID = $itemID;

        unset($conditionReport->filename);
        unset($conditionReport->type);

        /* Save new record into database */
        if($conditionReport->create()) {

            /* log entry */
            $log = new Log();
            $log->time = time();
            $log->log = "Condition Report made: {$employee->full_name()}, on item <a href=\"item.php?id={$itemID}\">{$itemID}</a>.";
            $log->create();


            /* Success */
            $session->message("Condition Report made successfully!");
            /* Refresh the page */
            redirect_to("item.php?id=$itemID");
        } else {
            /* Failure */
            $session->message("Condition Report NOT made!");
        }

    } else {

        $conditionReport->attach_file($_FILES['filename']);
        $conditionReport->report = $_POST['report'];
        $conditionReport->time = time();
        $conditionReport->author = $employee->full_name();
        $conditionReport->itemID = $itemID;

        /* Save new record into database */
        if($conditionReport->save()) {

            /* log entry */
            $log = new Log();
            $log->time = time();
            $log->log = "Condition Report made: {$employee->full_name()}, on item <a href=\"item.php?id={$itemID}\">{$itemID}</a>.";
            $log->create();


            /* Success */
            $session->message("Condition Report made successfully!");
            /* Refresh the page */
            redirect_to("item.php?id=$itemID");
        } else {
            /* Failure */
            $session->message("Condition Report NOT made!");
        }
    }
}

?>

<?php

if (isset ($_POST['submit'])) {

    $photograph = new Photograph();
    $photograph->itemID = $itemID;
    $photograph->attach_file($_FILES['file_upload']);
    $photograph->caption = $_POST['caption'];

    if ($photograph->save()) {
        // Success

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Photo added: {$employee->full_name()} added photo id <a href=\"image.php?photographID={$photograph->id}\">{$photograph->id}</a>.";
        $log->create();

        $session->message("Photograph uploaded successfully.");
        redirect_to("item.php?id=$itemID");
    } else {
        // Failure
        $message = join("<br />", $photograph->errors);
        echo $message;
    }
}
?>

<a href="contact.php?id=<?php echo $contactID; ?>">&laquo; back</a>
<?php echo $session->message(); ?>

<div>

    <div style="float: left; width: 50%;">
        <div id="client">
            <div class="box">
                <ul>
                    <li><?php echo $contact->full_name(); ?></li>
                </ul>
            </div> <!--box-->
        </div> <!--client-->
    </div> <!--float left-->

    <div style="float: right; width: 50%">

    </div> <!--float right-->

    <div style="clear: both;"></div>

    <div style="float: left; width: 50%;">
        <div>
            <h2>Details</h2>
            <div class="box">
                <form action="item.php?id=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
                    <fieldset>
                        <legend></legend>
                        <ol>
                            <li>
                                <label for="itemNumber">Item Number:</label>
                                <input disabled id="itemNumber" name="itemNumber" class="text" type="text" value="<?php echo $item->itemNumber; ?>" >
                            </li>
                            <li>
                                <label for="title">Title:</label>
                                <input id="title" name="title" class="text" type="text" value="<?php echo $item->title; ?>" >
                            </li>
                            <li>
                                <label for="artist">Artist:</label>
                                <input id="artist" name="artist" class="text" type="text" value="<?php echo $item->artist; ?>" >
                            </li>
                            <li>
                                <label for="medium">Medium:</label>
                                <input id="medium" name="medium" class="text" type="text" value="<?php echo $item->medium; ?>" >
                            </li>
                            <li>
                                <label for="dimensions">Dimensions:</label>
                                <input id="dimensions" name="length" class="text" type="text" value="<?php echo $item->length; ?>" size="5" > x <input name="width" class="text" type="text" value="<?php echo $item->width; ?>" size="5"  > x <input name="height" class="text" type="text" value="<?php echo $item->height; ?>" size="5"  > inches
                            </li>
                            <li>
                                <label for="insuredBy">Insured By:</label>
                                <input id="insuredBy" name="insuredBy" class="text" type="text" value="<?php echo $item->insuredBy; ?>" >
                            </li>
                            <li>
                                <label for="value">Value:</label>
                                <input id="value" name="value" class="text textSmall" type="text" value="<?php echo $item->value; ?>" >
                            </li>
                            <li>
                                <label for="location">Building/Aisle/Section/#:</label>
                                <!--building aisle section number-->
                                <input id="location" name="building" class="text" type="text" value="<?php echo $item->building; ?>" size="3" >
                                <input id="location" name="aisle" class="text" type="text" value="<?php echo $item->aisle; ?>" size="3" >
                                <input id="location" name="section" class="text" type="text" value="<?php echo $item->section; ?>" size="3" >
                                <input id="location" name="number" class="text" type="text" value="<?php echo $item->number; ?>" size="3" >
                            </li>
                        </ol>
                    </fieldset>

                    <fieldset class="submit">
                        <legend></legend>
                        <input class="submit" type="submit" name="submitDetails" value="Save Changes" >
                    </fieldset>
                </form>
            </div> <!--box-->
        </div> <!--details-->
    </div> <!--float left-->

    <div style="float: right; width: 50%">
        <h2>Photos</h2>
        <?php if(!empty($photograph)) : ?>
        <div class="box">
            <div >
                <center><a href="images.php?itemID=<?php echo $itemID; ?>" >  <img alt="image" src="<?php echo $photograph->image_thumbnail_path(2); ?>" width="400"/></a></center>
                <center><?php echo $photograph->caption; ?></center>
            </div>
        </div> <!--box-->
        <?php endif; ?>
        <?php if(empty($photograph)) : ?>
        <form action="images.php?itemID=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
            <fieldset>
                <legend>Add Photo</legend>
                <ol>
                    <li>
                        <label for="file_upload">Photo:</label>
                        <input id="file_upload"  name="file_upload" type="file" >
                    </li>
                    <li>
                        <label for="caption">Caption:</label>
                        <input id="caption"  name="caption" class="text" type="text" >
                    </li>
                </ol>
            </fieldset>

            <fieldset class="submit">
                <legend></legend>
                <input class="submit" type="submit" name="submit" value="Add photo" >
            </fieldset>
        </form>
        <?php endif; ?>
    </div> <!--float right-->
    <div style="clear: both;"></div>
    <div style="float: left; width: 50%;">
        <div>
            <h2>Item Notes</h2>
            <div class="box">
                <center>
                    <form action="itemNote_add.php?itemID=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
                        <fieldset>
                            <legend></legend>
                            <ol>
                                <li>
                                    <label for="note"></label>
                                    <textarea cols="40" rows="10" id="note" name="note" ></textarea>
                                </li>
                            </ol>
                        </fieldset>

                        <fieldset class="submit">
                            <legend></legend>
                            <input class="submit" type="submit" name="submitItemNote" value="Add Note" >
                        </fieldset>
                    </form>
                </center>
                <table id="itemNotes" border="0" width="100%" cellpadding="10">
                    <tr>
                        <th width="20%">Author</th>
                        <th width="20%">Time</th>
                        <th width="60%">Note</th>
                    </tr>
                    <?php foreach($itemNotes as $itemNote) : ?>
                    <tr>
                        <td align="center"><?php echo $itemNote->author; ?></td>
                        <td align="center"><?php echo $itemNote->get_time(); ?></td>
                        <td class="actualNote"><?php echo $itemNote->note; ?></td>
                    </tr>
                    <?php endforeach;?>
                </table>
            </div> <!--box-->
        </div><!--item notes-->
    </div> <!--float left-->

    <div style="float: right; width: 50%">
        <div>
            <h2>Condition Reports</h2>

            <div class="box">
                <center>
                    <form action="conditionReport_add.php?itemID=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
                        <fieldset>
                            <legend></legend>
                            <ol>
                                <li>
                                    <label for="report"></label>
                                    <textarea cols="40" rows="10" id="report" name="report" ></textarea>
                                </li>
                                <li>
                                    <label for="filename">Attachment:</label>
                                    <input id="filename"  name="filename" type="file" >
                                </li>
                            </ol>
                        </fieldset>

                        <fieldset class="submit">
                            <legend></legend>
                            <input class="submit" type="submit" name="submitConditionReport" value="Add Report" >
                        </fieldset>
                    </form>
                </center>

                <table id="conditionReport" border="0" width="100%" cellpadding="10">
                    <tr>
                        <th width="20%">Author</th>
                        <th width="20%">Time</th>
                        <th width="10%">att</th>
                        <th width="50%">Note</th>
                    </tr>
                    <?php foreach($conditionReports as $conditionReport) : ?>
                    <tr>
                        <td align="center"><?php echo $conditionReport->author; ?></td>
                        <td align="center"><?php echo $conditionReport->get_time(); ?></td>
                        <td align="center"><?php echo empty($conditionReport->filename) ? "" :  "<a href=\"attachment.php?conditionReportID={$conditionReport->id}\">" . "file" . "<a >"   ?></td>
                        <td class="actualNote"><?php echo $conditionReport->report; ?></td>
                    </tr>
                    <?php endforeach;?>
                </table>

            </div> <!--box-->

        </div> <!--conidition reports-->
    </div> <!--float right-->

</div> <!--client,details,photo-->

<div style="clear: both;"></div>
<input type="button" onclick="confirmationDeleteItem(<?php echo $item->id;?>,<?php echo $item->itemNumber;?>)" value="Delete Item">

