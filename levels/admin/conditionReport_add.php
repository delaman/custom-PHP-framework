<?php

/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
$itemID = $_GET['itemID'];

/* Check if post request has been made */
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
<?php echo $session->message(); ?>
<form action="conditionReport_add.php?itemID=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="report">Report:</label>
                <textarea cols="70" rows="10" id="report" name="report" ></textarea>
            </li>
            <li>
                <label for="filename">Attachment:</label>
                <input id="filename"  name="filename" type="file" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submitConditionReport" value="Add Report" />
    </fieldset>
</form>