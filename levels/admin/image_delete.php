<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>

<?php
// must have an ID
if(empty($_GET['id'])) {
    $session->message("No photograph ID was provided.");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);

if($photo && $photo->destroy()) {
    $session->message("The photo {$photo->filename} was deleted.");

    /* log entry */
    $log = new Log();
    $log->priority = 1;
    $log->time = time();
    $log->log = "Photo deleted: {$employee->full_name()}, deleted photo id {$photo->id}.";
    $log->create();

    redirect_to("images.php?itemID=$photo->itemID");
} else {
    $session->message("The photo could not be deleted.");
    redirect_to("item.php?id=$photo->itemID");
}

?>

