<script type="text/javascript">
    function validate() {
        if (form.name1.value=='') {
            alert('First name is a required field. Please try again.');
            event.returnValue=false;
        } else if (form.name2.value=='') {
            alert('Last name is a required field. Please try again.');
            event.returnValue=false;
        }
    }
</script>

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
    $contact->itemNumberIndex = 1;

    /* Save new record into database */
    if($contact->create()) {
        /* Success */

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Contact added: {$employee->full_name()}, added, <a style=\"text-decoration: none;\"href=\"contact.php?id={$contact->id}\">{$contact->full_name()}</a>.";
        $log->create();

        $session->message("Contact added successfully!");
        /* Delete the submit variable */
        unset($_POST['submit']);
        /* Refresh the page */
        redirect_to("contact.php?id={$contact->id}");
    } else {
        /* Failure */
        $session->message("Contact NOT added!");
    }
}

?>

<?php //echo output_message($message); ?>
<h2>Add Client</h2>
<form action="contact_insert.php" enctype="multipart/form-data" method="POST" onsubmit="validate();" name="form">
    <fieldset  class="fieldsetAdd">
        <legend></legend>
        <ol>
            <li>
                <label for="name1">First Name:</label>
                <input id="name1" name="name1" class="text" type="text" />
            </li>
            <li>
                <label for="name2">Last Name:</label>
                <input id="name2" name="name2" class="text" type="text" />
            </li>
            <li>
                <label for="email">Email Address:</label>
                <input id="email" name="email" class="text" type="text" />
            </li>
            <li>
                <label for="phone">Telephone:</label>
                <input id="phone" name="phone1" class="text" type="text" size="3" />
                <input id="phone" name="phone2" class="text" type="text" size="3" />
                <input id="phone" name="phone3" class="text" type="text" size="4"  />
            </li>
            <li>
                <label for="phone">Alternative:</label>
                <input id="phone" name="phone4" class="text" type="text" size="3" />
                <input id="phone" name="phone5" class="text" type="text" size="3" />
                <input id="phone" name="phone6" class="text" type="text" size="4"  />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Add Contact" />
    </fieldset>
</form>
