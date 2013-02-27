<?php

/*
 * Make a variable ($key) of $_POST['nameHere'].
 * Also fill in the attrtibutes of the class.
*/
$contact = new Contact();
foreach (array_keys($_POST) as $key) {
    $$key = $_POST[$key];
    $contact->$key = ${$key};
}

/* Search for the clients in the database. */
$contacts = $contact->search();

?>

<?php if(!empty($contacts)) :?>
<h2>Contacts</h2>
<?php foreach($contacts as $contact) : ?>
<a href="<?php echo "contact.php?id=". $contact->id; ?>">
    <div class="box">
        <ul>
            <li><?php echo $contact->full_name(); ?></li>
        </ul>
    </div>
</a>
<?php endforeach;?>
<?php endif;?>

<?php if(empty($contacts)) :?>
<div id="noResults">
    No Clients found!
</div>
<?php endif;?>
