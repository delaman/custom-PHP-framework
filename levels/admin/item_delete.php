<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>

<?php
// must have an ID
if(empty($_GET['id'])) {
    $session->message("No item ID was provided.");
    redirect_to('index.php');
}

$item = Item::find_by_id($_GET['id']);



if($item->destroy()) {

    print_r($item);
    $session->message("The item number {$item->itemNumber} was deleted.");

    /* log entry */
    $log = new Log();
    $log->priority = 1;
    $log->time = time();
    $log->log = "Item deleted: {$employee->full_name()}, item number {$item->itemNumber}.";
    $log->create();

    /* Send person to the contact page */
    redirect_to("contact.php?id=$item->contactID");
} else {
    $session->message("The item could not be deleted.");
    redirect_to("item.php?id=$item->id");
}

?>

