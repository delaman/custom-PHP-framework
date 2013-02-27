<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>

<?php
// must have an ID
if(empty($_GET['userID'])) {
    $session->message("No user ID was provided.");
    redirect_to('user_list.php');
}

$user = User::find_by_id($_GET['userID']);

if($user->delete()) {
    
    $session->message("The user {$user->username} was deleted.");

    /* log entry */
    $log = new Log();
    $log->priority = 1;
    $log->time = time();
    $log->log = "User deleted: {$employee->full_name()}, deleted user {$user->username}.";
    $log->create();

    redirect_to("user_list.php");
} else {
    $session->message("The user could not be deleted.");
    redirect_to("user_list.php");
}

?>