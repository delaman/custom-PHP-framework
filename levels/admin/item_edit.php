<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>
<?php

/* Check if post request has been made */
if (isset($_POST['submit'])) {

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    $item = Item::find_by_id($_GET['itemID']);
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

/**
 * Get client information from the id php tag.
 */
$item = Item::find_by_id($_GET['itemID']);

?>


<?php echo $session->message(); ?>

<form action="item_edit.php?itemID=<?php echo $_GET['itemID']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Client</legend>
        <ol>
            <li>
                <label for="itemNumber">Item Number:</label>
                <input id="itemNumber" name="itemNumber" class="text" type="text" value="<?php echo $item->itemNumber; ?>" />
            </li>
            <li>
                <label for="title">Title:</label>
                <input id="title" name="title" class="text" type="text" value="<?php echo $item->title; ?>" />
            </li>
            <li>
                <label for="artist">Artist:</label>
                <input id="artist" name="artist" class="text" type="text" value="<?php echo $item->artist; ?>" />
            </li>
            <li>
                <label for="medium">Medium:</label>
                <input id="medium" name="medium" class="text" type="text" value="<?php echo $item->medium; ?>" />
            </li>
            <li>
                <label for="dimensions">Dimensions:</label>
                <input id="dimensions" name="length" class="text" type="text" value="<?php echo $item->length; ?>" size="5" /> x <input id="dimensions" name="width" class="text" type="text" value="<?php echo $item->width; ?>" size="5"  /> x <input id="dimensions" name="height" class="text" type="text" value="<?php echo $item->height; ?>" size="5"  /> inches
            </li>
            <li>
                <label for="insuredBy">Insured By:</label>
                <input id="insuredBy" name="insuredBy" class="text" type="text" value="<?php echo $item->insuredBy; ?>" />
            </li>
            <li>
                <label for="value">Value:</label>
                <input id="value" name="value" class="text textSmall" type="text" value="<?php echo $item->value; ?>" />
            </li>
            <li>
                <label for="location">Location:</label>
                <input id="location" name="location" class="text" type="text" value="<?php echo $item->location; ?>" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Save Changes" />
    </fieldset>
</form>