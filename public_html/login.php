<?php
require_once('../includes/initialize.php');

if($session->is_logged_in()) {
    redirect_to("index.php");
}

if (isset($_POST['submit'])) { // Form has been submitted.

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    /*
     * Check database to see if username/password exist. The arguments
     * are not encrypted.
    */
    $found_user = User::authenticate($username, $password);

    if ($found_user) {
        $session->login($found_user);

        /* Get employee information */
        $employee = Employees::find_by_id($session->employeeID);

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Logged in: {$employee->full_name()}, from IP address <a href=\"http://en.utrace.de/?query=" . getRealIpAddr() . "\"> " . getRealIpAddr() . "</a>";
        $log->create();

        /* Take to main page */
        redirect_to("index.php");
    } else {
        // username/password combo was not found in the database
        $message = "Username/password combination incorrect.";
    }

} else { // Form has not been submitted.
    $username = "";
    $password = "";
}

?>
<html>
    <head>
        <title>ATS</title>
        <link href="./stylesheets/BlueSquareShadow/style.css" media="all" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="main" style="margin-top: 10%; width: 420px;">
            <h2>Login</h2>
            <?php echo output_message($message); ?>

            <div class="box">
                <form action="login.php" method="post">
                    <table>
                        <tr>
                            <td>Username:</td>
                            <td>
                                <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td>
                                <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Login" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
