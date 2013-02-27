<?php

/*
 * Make a variable ($key) of $_POST['nameHere'].
 * Also fill in the attrtibutes of the class.
*/
$item = new Item();
foreach (array_keys($_POST) as $key) {
    $$key = $_POST[$key];
    $item->$key = ${$key};
}

/* Search for the clients in the database. */
$items = $item->search();

?>
<?php
/* How long the names in the inventory boxes will be. */
$length = 15;
?>

<?php if(!empty($items)) :?>
<h2>Items - <?php echo count($items)?></h2>
<?php foreach($items as $item) : ?>
<div style="float: left;">
        <?php $photograph = Photograph::find_by_itemID($item->id); ?>
    <a style="width: auto;" href="item.php?id=<?php echo $item->id; ?>">
        <div class="box" style="height: 230px; width: 170px;">
            <ul>
                <li><div class="inventoryTitle"><?php echo $item->itemNumber; ?></div></li>
                <center><?php if($photograph) :?><li><img alt="image" src="<?php echo $photograph->image_thumbnail_path(1); ?>" width="100" /></li><?php endif;?></center>
                <li>Artist: <?php echo $item->get_artist_abr($length); ?></li>
                <li>Title: <?php echo $item->get_title_abr($length); ?></li>
                <li>Medium: <?php echo $item->get_medium_abr($length); ?></li>
            </ul>
        </div>
    </a>
</div>
<?php endforeach;?>
<?php endif;?>

<?php if(empty($items)) :?>
<div id="noResults">
    No Items found!
</div>
<?php endif;?>