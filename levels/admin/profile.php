<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>

<?php

/* Check if post request has been made */
if (isset($_POST['submitPassword'])) {

    $user_id = $_SESSION['user_id'];

    $user = User::find_by_id($user_id);
    $salt = $user->salt;
    $password = $_POST['password'];

    $user->password = session_hash($password, $salt);

    if($user->update()) {
        /* Success */

        /* Update the cookie or else it will log you off. */
        setcookie('password',  $user->password, 0x7fffffff);

        /* No log entry needed */

        $session->message("Password changed successfully!");
        /* Refresh the page */
        redirect_to("profile.php");
    } else {
        /* Failure */
        $session->message("Password NOT changed!");
    }
}

?>

<?php echo $session->message(); ?>

<form action="profile.php" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Change Password</legend>
        <ol>
            <li>
                <label for="password">New Password:</label>
                <input id="password" name="password" class="text" type="text" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submitPassword" value="Change Password" />
    </fieldset>
</form>