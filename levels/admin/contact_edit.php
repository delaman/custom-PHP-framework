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
    $contact = new Contact();
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $contact->$key = ${$key};
    }
    $contact->id = $_GET['id'];

    /* Update database */
    if($contact->update()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 1;
        $log->time = time();
        $log->log = "Contact edited: {$employee->full_name()} edited {$contact->full_name()} profile.";
        $log->create();

        $session->message("Client edited successfully!");
        unset($_POST['submit']);
        redirect_to("client.php?id=". $contact->id );
    } else {
        /* Failure */
        $session->message("Client NOT edited!");
    }
}
?>

<?php

/**
 * Get client information from the id php tag.
 */
$contact = Contact::find_by_id($_GET['id']);

?>


<?php //echo output_message($message); ?>

<form action="client_edit.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Client</legend>
        <ol>
            <li>
                <label for="name1">First Name:</label>
                <input id="name1" name="name1" class="text" type="text" value="<?php echo $contact->name1; ?>" />
            </li>
            <li>
                <label for="name2">Last Name:</label>
                <input id="name2" name="name2" class="text" type="text" value="<?php echo $contact->name2; ?>" />
            </li>
            <li>
                <label for="address1">Address 1:</label>
                <input id="address1" name="address1" class="text" type="text" value="<?php echo $contact->address1; ?>" />
            </li>
            <li>
                <label for="address2">Address 2:</label>
                <input id="address2" name="address2" class="text" type="text" value="<?php echo $contact->address2; ?>" />
            </li>
            <li>
                <label for="city">City:</label>
                <input id="city" name="city" class="text" type="text" value="<?php echo $contact->city; ?>" />
            </li>
            <li>
                <label for="postcode">Postcode:</label>
                <input id="postcode" name="postcode" class="text textSmall" type="text" value="<?php echo $contact->postcode; ?>" />
            </li>
            <li>
                <label for="email">Email Address:</label>
                <input id="email" name="email" class="text" type="text" value="<?php echo $contact->email; ?>" />
            </li>
            <li>
                <label for="phone">Telephone:</label>
                <input id="phone" name="phone1" class="text" type="text" size="3" value="<?php echo $contact->phone1; ?>" />
                <input id="phone" name="phone2" class="text" type="text" size="3" value="<?php echo $contact->phone2; ?>" />
                <input id="phone" name="phone3" class="text" type="text" size="4" value="<?php echo $contact->phone3; ?>"  />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Edit Client" />
    </fieldset>
</form>