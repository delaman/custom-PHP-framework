<?php
/* Get employee information */
$employee1 = Employees::find_by_id($session->employeeID);
?>

<?php
// must have an ID
if(empty($_GET['employeeID'])) {
    $session->message("No employee ID was provided.");
    redirect_to('employee_list.php');
}

$employee = Employees::find_by_id($_GET['employeeID']);

if($employee->delete()) {

    $session->message("The employee {$employee->full_name()} was deleted.");

    /* log entry */
    $log = new Log();
    $log->priority = 1;
    $log->time = time();
    $log->log = "Employee deleted: {$employee1->full_name()}, deleted employee {$employee->full_name()}.";
    $log->create();

    redirect_to("employee_list.php");
} else {
    $session->message("The user could not be deleted.");
    redirect_to("employee_list.php");
}

?>