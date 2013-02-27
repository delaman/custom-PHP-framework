<?php require_once("../includes/initialize.php"); ?>

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
    $item->clientID = $_GET['id'];

    /* Save into database */
    if($item->create()) {
        /* Success */
        $session->message("Item added successfully!");
        unset($_POST['submit']);
    } else {
        /* Failure */
        $session->message("Item NOT added!");
    }
}
?>


<?php include_layout_template('header.php'); ?>
<?php echo output_message($message); ?>
<form action="item_insert.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Art Piece</legend>
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
                <input id="medium" name="medium" class="text" type="text" />
            </li>
            <li>
                <label for="dimensions">Dimensions:</label>
                <input id="dimensions" name="length" class="text" type="text" size="2" />
                <input id="dimensions" name="width" class="text" type="text" size="2" />
                <input id="dimensions" name="height" class="text" type="text" size="2" />
            </li>
        </ol>
    </fieldset>
    <fieldset>
        <legend>Photograph</legend>
        <ol>
            <li>
                <label for="photo">Photo:</label>
                <input type="file" name="file_upload" />
            </li>
        </ol>
    </fieldset>


    <fieldset>
        <legend>Insurance</legend>
        <ol>
            <li>
                <label for="insuredBy">Insured by:</label>
                <input id="insuredBy" name="insuredBy" class="text" type="text" />
            </li>
            <li>
                <label for="value">Value:</label>
                <input id="value" name="value" class="text" type="text" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Insert" />
    </fieldset>
</form>

<?php include_layout_template('footer.php'); ?>