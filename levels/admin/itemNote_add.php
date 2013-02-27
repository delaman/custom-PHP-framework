<?php

/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
$itemID = $_GET['itemID'];

/* Check if post request has been made */
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

<form action="itemNote_add.php?itemID=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="note">Note:</label>
                <textarea cols="70" rows="10" id="note" name="note" ></textarea>
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submitItemNote" value="Add Note" />
    </fieldset>
</form>