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
    $user = new User();
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $user->$key = ${$key};
    }
    $user->salt = random_key(12);
    $user->password = session_hash($user->password,$user->salt);


    /* Create record in database */
    if($user->create()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 1;
        $log->time = time();
        $log->log = "User contact added: {$employee->full_name()} added user {$user->username}.";
        $log->create();

        $session->message("User contact added successfully!");
        unset($_POST['submit']);
        redirect_to('user_list.php');
    } else {
        /* Failure */
        $session->message("User contact NOT added!");
    }
}
?>

<h2>Add Contact User</h2>
<form action="user_add_contact.php" enctype="multipart/form-data" method="POST">
    <fieldset class="fieldsetAdd">
        <legend></legend>
        <ol>
            <li>
                <label for="username">Username:</label>
                <input id="username" name="username" class="text" type="text"  />
            </li>
            <li>
                <label for="password">Password:</label>
                <input id="password" name="password" class="text" type="password" />
            </li>
            <li>
                <label for="clientID">Contact ID:</label>
                <input id="clientID" name="clientID" class="text" type="text" size="5" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Add User" />
    </fieldset>
</form>