<?php
/* Get employee information */
$employee1 = Employees::find_by_id($session->employeeID);
?>
<?php

/* Check if post request has been made */
if (isset($_POST['submit'])) {

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    $employee = new Employees();
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $employee->$key = ${$key};
    }

    /* Create record in database */
    if($employee->create()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 1;
        $log->time = time();
        $log->log = "Employee added: {$employee1->full_name()} added employee {$employee->full_name()}.";
        $log->create();

        $session->message("Employee added successfully!");
        unset($_POST['submit']);
        redirect_to('employee_list.php');
    } else {
        /* Failure */
        $session->message("Employee NOT added!");
    }
}
?>

<h2>Add Employee</h2>
<form action="employee_add.php" enctype="multipart/form-data" method="POST">
    <fieldset class="fieldsetAdd">
        <legend></legend>
        <ol>
            <li>
                <label for="name1">First Name:</label>
                <input id="name1" name="name1" class="text" type="text"  />
            </li>
            <li>
                <label for="name2">Last Name:</label>
                <input id="name2" name="name2" class="text" type="text" />
            </li>
            <li>
                <label for="address1">Address 1:</label>
                <input id="address1" name="address1" class="text" type="text"  />
            </li>
            <li>
                <label for="address2">Address 2:</label>
                <input id="address2" name="address2" class="text" type="text" />
            </li>
            <li>
                <label for="city">City:</label>
                <input id="city" name="city" class="text" type="text" />
            </li>
            <li>
                <label for="state">State:</label>
                <input id="state" name="state" class="text" type="text" size="2"  />
            </li>
            <li>
                <label for="postcode">Postcode:</label>
                <input id="postcode" name="postcode" class="text textSmall" type="text" size="5" />
            </li>
            <li>
                <label for="phone">Telephone:</label>
                <input id="phone" name="phone1" class="text" type="text" size="3" />
                <input id="phone" name="phone2" class="text" type="text" size="3"  />
                <input id="phone" name="phone3" class="text" type="text" size="4"  />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Edit Client" />
    </fieldset>
</form>