<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>

<?php
// must have an ID
if(empty($_GET['contactID'])) {
    $session->message("No client ID was provided.");
    redirect_to('contact_list.php');
}

$contact = Contact::find_by_id($_GET['contactID']);
$addresses = Address::find_by_contactID($contact->id);

if($contact->delete()) {

    /* Delete all the respected addresses associated with the contact. */
    foreach($addresses as $address)
        $address->delete();

    $session->message("The client {$contact->full_name()} was deleted.");

    /* log entry */
    $log = new Log();
    $log->priority = 1;
    $log->time = time();
    $log->log = "Client deleted: {$employee->full_name()}, deleted client {$contact->full_name()}.";
    $log->create();

    redirect_to("contact_list.php");
} else {
    $session->message("The user could not be deleted.");
    redirect_to("contact_list.php");
}

?>