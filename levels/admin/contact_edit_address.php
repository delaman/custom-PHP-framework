<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>
<?php

/* Check if post request has been made */
if (isset($_POST['submit'])) {

    $address = Address::find_by_id($_GET['id']);

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $address->$key = ${$key};
    }

    /* Get values from URL  */
    $address->contactID = $_GET['contactID'];
    /* Get contactID */
    $contactID = $address->contactID;
    /* Find contact information */
    $contact = Contact::find_by_id($contactID);

    /* Update database */
    if($address->update()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Address edited: {$employee->full_name()}, edited address \"{$address->type}\"  to contact <a style=\"text-decoration: none;\" href=\"contact.php?id={$contact->id}\">{$contact->full_name()}</a>.";
        $log->create();

        $session->message("Client edited successfully!");
        unset($_POST['submit']);
        redirect_to("contact.php?id=". $address->contactID );
    } else {
        /* Failure */
        $session->message("Client NOT edited!");
    }
}
?>

<?php

/*
 * Delete the address from the contact records.
*/

/* Check if post request has been made */
if (isset($_POST['submitDelete'])) {

    /* Find address */
    $address = Address::find_by_id($_GET['id']);
    /* Get contactID */
    $contactID = $address->contactID;
    /* Find contact information */
    $contact = Contact::find_by_id($contactID);

    /* Update database */
    if($address->delete()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 1;
        $log->time = time();
        $log->log = "Address deleted: {$employee->full_name()}, deleted address \"{$address->type}\" of contact <a style=\"text-decoration: none;\" href=\"contact.php?id={$contact->id}\">{$contact->full_name()}</a>.";
        $log->create();

        $session->message("Client deleted successfully!");
        unset($_POST['submitDelete']);
        redirect_to("contact.php?id=". $address->contactID );
    } else {
        /* Failure */
        $session->message("Client NOT deleted!");
    }
}
?>

<?php
/* Check if post request has been made */
if (isset($_POST['submitBilling'])) {

    /* Find address */
    $address = Address::find_by_id($_GET['id']);
    /* Get contactID */
    $contactID = $address->contactID;
    /* Find contact information */
    $contact = Contact::find_by_id($contactID);
    


    /* Make the address record the only one with billing type role. */
    if($address->make_billing()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Address made billing: {$employee->full_name()}, address \"{$address->type}\" of contact <a style=\"text-decoration: none;\" href=\"contact.php?id={$contact->id}\">{$contact->full_name()}</a>.";
        $log->create();

        $session->message("Address made billing type successfully!");
        unset($_POST['submitBilling']);
        redirect_to("contact.php?id=". $address->contactID );
    } else {
        /* Failure */
        $session->message("Address NOT made billing type.!");
    }
}
?>

<?php

/**
 * Get address information from the id php tag.
 */
$address = Address::find_by_id($_GET['id']);

?>


<?php //echo output_message($message); ?>

<form action="contact_edit_address.php?id=<?php echo $_GET['id']; ?>&contactID=<?php echo $_GET['contactID']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Client</legend>
        <ol>
            <li>
                <label for="type">Type:</label>
                <input id="type" name="type" class="text" type="text" value="<?php echo $address->type; ?>" />
            </li>
            <li>
                <label for="address1">Address 1:</label>
                <input id="address1" name="address1" class="text" type="text" value="<?php echo $address->address1; ?>" />
            </li>
            <li>
                <label for="address2">Address 2:</label>
                <input id="address2" name="address2" class="text" type="text" value="<?php echo $address->address2; ?>" />
            </li>
            <li>
                <label for="city">City:</label>
                <input id="city" name="city" class="text" type="text" value="<?php echo $address->city; ?>" />
            </li>
            <li>
                <label for="state">State:</label>
                <input id="state" name="state" class="text" type="text" value="<?php echo $address->state; ?>" />
            </li>
            <li>
                <label for="postcode">Postcode:</label>
                <input id="postcode" name="postcode" class="text textSmall" type="text" value="<?php echo $address->postcode; ?>" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Save Changes" />
    </fieldset>
</form>

<form action="contact_edit_address.php?id=<?php echo $_GET['id']; ?>&contactID=<?php echo $_GET['contactID']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="billing">Make Billing Account:</label>
                <input id="billing" name="role" class="text" type="checkbox" value="1" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submitBilling" value="Make BIlling Account" />
    </fieldset>
</form>

<form action="contact_edit_address.php?id=<?php echo $_GET['id']; ?>&contactID=<?php echo $_GET['contactID']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="type">Delete Address:</label>
                <input id="type" name="type" class="text" type="checkbox" value="1" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submitDelete" value="Delete Address" />
    </fieldset>
</form>