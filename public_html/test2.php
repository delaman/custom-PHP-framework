<?php require_once("../includes/initialize.php"); ?>

<?php

    /* Get all the items */
    $item = Item::find_by_id(1);

    $item->set_inventory_in();


?>

