<?php

/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);

if(empty($_GET['contactID'])) {
    $session->message("No contact ID was provided.");
    redirect_to('index.php');
} else {

    $contactID = $_GET['contactID'];
    $contact = Contact::find_by_id($contactID);

    /* Check if contact is a good one. */
    if(!$contact) {
        $session->message("The contact could not be located.");
        redirect_to('index.php');
    }

    /* All good now, may proceed with below. */
}
?>
<?php

/* Check if post request has been made */
if (isset($_POST['submit'])) {

    /*
     * Make a variable ($key) of $_POST['nameHere'].
     * Also fill in the attrtibutes of the class
    */
    $address = new Address();
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $address->$key = ${$key};
    }
    $address->contactID = $_GET['contactID'];

    /*
     * Make all other addresses of the contact 'default' type. It is later in the
     * create() method that this address that is being added by the user will
     * be made the billing type.
     */
    if($address->role == 1)
            Address::make_all_default_addresses_by_contactID($contactID);

    /* Create database */
    if($address->create()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Address added: {$employee->full_name()}, added address to contact <a style=\"text-decoration: none;\" href=\"contact.php?id={$contact->id}\">{$contact->full_name()}</a>.";
        $log->create();


        $session->message("Address created successfully!");
        unset($_POST['submit']);
        redirect_to("contact.php?id=". $address->contactID );
    } else {
        /* Failure */
        $session->message("Address NOT added successfully!");
    }
}
?>




<form action="address_add.php?contactID=<?php echo $contactID; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Add Address</legend>
        <ol>
            <li>
                <label for="type">Type:</label>
                <input id="type" name="type" class="text" type="text" />
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
                <label for="role">Billing:</label>
                <input id="role" name="role" type="checkbox" value="1" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Add address" />
    </fieldset>
</form>
