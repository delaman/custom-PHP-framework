<?php require_once("../includes/initialize.php"); ?>
<?php

/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);

$session->logout();

/* log entry */
$log = new Log();
$log->priority = 0;
$log->time = time();
$log->log = "Logged out: {$employee->full_name()}, from IP address <a href=\"http://en.utrace.de/?query=" . getRealIpAddr() . "\"> " . getRealIpAddr() . "</a>";
$log->create();

redirect_to("index.php");
?>
