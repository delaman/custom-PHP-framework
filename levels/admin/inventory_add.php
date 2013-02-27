<?php

/* Get contactID */
$contactID = $_GET['contactID'];
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
    $item = new Item();
    foreach (array_keys($_POST) as $key) {
        $$key = $_POST[$key];
        $item->$key = ${$key};
    }
    $item->contactID = $contactID;

    /* Save new record into database */
    if($item->create()) {
        /* Success */

        /* This is done after $item->create() */
        $item->make_itemNumber();

        if($item->update() && mkdir(SITE_ROOT .DS. 'images' .DS . $item->itemNumber) && mkdir(SITE_ROOT .DS. 'conditionReports' .DS . $item->itemNumber) ) {

            /* log entry */
            $log = new Log();
            $log->priority = 0;
            $log->time = time();
            $log->log = "Item added: {$employee->full_name()}, added item number <a href=\"item.php?id={$item->id}\">{$item->itemNumber}</a>.";
            $log->create();

            $session->message("Item added successfully!");
            /* Delete the submit variable */
            unset($_POST['submit']);
            /* Refresh the page */
            redirect_to("item.php?id=$item->id");

        }
        
    } else {
        /* Failure */
        $session->message("Item NOT added!");
    }
}

?>

<form action="inventory_add.php?contactID=<?php echo $contactID; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>General Information</legend>
        <ol>
            <li>
                <label for="artist">Artist:</label>
                <input id="artist" name="artist" class="text" type="text" />
            </li>
            <li>
                <label for="title">Title:</label>
                <input id="title" name="title" class="text" type="text" />
            </li>
            <li>
                <label for="medium">Medium:</label>
                <select id="medium" name="medium" class="text">
                    <option disabled value="">Select One</option>
                    <option value="Photography">Photography</option>
                    <option value="Oil on Canvas">Oil on Canvas</option>
                    <option value="Acrylic on canvas">Acrylic on Canvas</option>
                    <option value="Graphite on Paper">Graphite on Paper</option>
                    <option value="Mixed Media">Mixed Media</option>
                    <option value="Charcoal">Charcoal</option>
                    <option value="Colored Pencil">Colored Pencil</option>
                    <option value="Pastel">Pastel</option>
                    <option value="Pen/Ink">Pen/Ink</option>
                    <option value="Sculpture">Sculpture</option>
                    <option value="Other">Other</option>
                </select>
                <input id="mediumExtra" name="mediumExtra" class="text" type="text" />
            </li>
        </ol>
    </fieldset>
    <fieldset>
        <legend>Dimensions</legend>
        <ol>
            <li>
                <input name="length" class="text" type="text" size="5" value="0" /> x <input name="width" class="text" type="text" size="5" value="0" /> x <input name="height" class="text" type="text" size="5" value="0" /> inches
                <input class="submit" value="cm to in" type="button" onclick="cent2inch(this.form)">
            </li>
        </ol>
    </fieldset>
    <fieldset>
        <legend>Insurance</legend>
        <ol>
            <li>
                <label for="insuredBy">Insured By:</label>
                <select id="insuredBy" name="insuredBy" class="text">
                    <option disabled value="">Select One</option>
                    <option value="TYart">TYart</option>
                    <option value="Client">Client</option>
                    <option value="Other">Other</option>
                    <option value="None">None</option>
                </select>
            </li>
            <li>
                <label for="value">Value:</label>
                <input id="value" name="value" class="text" type="text" />
            </li>
        </ol>
    </fieldset>
    <fieldset>
        <legend></legend>
        <ol>
            <li>
                <label for="location">Location:</label>
                <input id="location" name="location" class="text" type="text" />
            </li>
            <li>
                <label for="transportation">Transportation:</label>
                <input id="transportation" name="transportation" class="text" type="text" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Insert" />
    </fieldset>
</form>