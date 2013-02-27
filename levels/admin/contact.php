<?php
/* Get current page view */
$view = !empty ($_GET['view']) ? (int) $_GET['view'] : 1;
/* Get contact information into an object */
$contact = Contact::find_by_id($_GET['id']);
/* Get addresses by contact ID */
$addresses = Address::find_by_contactID($_GET['id']);
/* Get items by contact ID */
$items = Item::find_by_contactID($_GET['id']);
/* How long the names in the inventory boxes will be. */
$length = 15;

?>


<div id="contactHeader">
    <a href="#">
        <ul>
            <li><?php echo $contact->full_name(); ?></li>
            <div id="contactHeaderSub">
                <?php if($contact->email) : ?> <li><?php echo $contact->email; ?></li><?php endif;?>
                <?php if($contact->full_telephone_number()) : ?><li><?php echo $contact->full_telephone_number(); ?></li><?php endif;?>
                <?php if($contact->full_telephone_number2()) : ?><li><?php echo $contact->full_telephone_number2(); ?></li><?php endif;?>
            </div>
        </ul>
    </a>
</div>


<h2>Address </h2>
<a href="address_add.php?contactID=<?php echo $contact->id; ?>" >Add new</a>

<div>
    <?php foreach($addresses as $address) : ?>
    <div style="float: left;">
        <h3><?php echo $address->type; ?></h3>

        <a href="contact_edit_address.php?id=<?php echo $address->id; ?>&contactID=<?php echo $contact->id; ?>" >
            <div class="box">
                <ul>
                    <li><?php echo $address->address1; ?></li>
                        <?php if(!empty($address->address2)):  ?><li><?php echo $address->address2; ?></li> <?php endif; ?>
                    <li><?php echo $address->city; ?>, <?php echo $address->state; ?> <?php echo $address->postcode; ?></li>
                </ul>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div><!--Address-->

<div style="clear: both;"></div>

<hr>


<?php if($view==1) : ?>

<h2>Inventory - <?php echo count($items); ?></h2>
<a href="#">Print excel sheet</a><br />
<a href="inventory_add.php?contactID=<?php echo $contact->id; ?>">Add Inventory</a>
<div>
        <?php foreach($items as $item) : ?>
            <?php $photograph = Photograph::find_by_itemID($item->id); ?>
    <a style=" width: auto;" href="item.php?id=<?php echo $item->id; ?>">
        <div style="float: left;">
            <div class="box" style="height: 220px; width: 170px;">
                <ul>
                    <li><div id="inventoryTitle"><?php echo $item->itemNumber; ?></div></li>
                    <center><?php if($photograph) :?><li><img alt="image" src="<?php echo $photograph->image_thumbnail_path(1); ?>" width="100" /></li><?php endif;?></center>
                    <li>Artist: <?php echo $item->get_artist_abr($length); ?></li>
                    <li>Title: <?php echo $item->get_title_abr($length); ?></li>
                    <li>Medium: <?php echo $item->get_medium_abr($length); ?></li>
                </ul>
            </div><!--box-->
        </div>
    </a>
        <?php endforeach; ?>
</div><!--Inventory-->

<?php endif;?>

<?php if($view==2) : ?>

<h2>Inventory - <?php echo count($items); ?></h2>
<a href="#">Print excel sheet</a> <br />
<a href="inventory_add.php?contactID=<?php echo $contact->id; ?>">Add Inventory</a>
<table id="contactExcelTable">
    <tr>
        <th>Item Number</th>
        <th>Client</th>
        <th>Artist</th>
        <th>Title</th>
        <th>Image</th>
        <th>Medium</th>
        <th>Dimensions</th>
        <th>Location</th>
    </tr>

        <?php foreach($items as $item) : ?>
            <?php $photograph = Photograph::find_by_itemID($item->id); ?>
    <tr>
        <td><?php echo $item->itemNumber; ?></td>
        <td></td>
        <td><?php echo $item->artist; ?></td>
        <td><?php echo $item->title; ?></td>
        <td><?php if($photograph) :?><img alt="image" src="<?php echo $photograph->image_thumbnail_path(1); ?>" width="100" /><?php endif;?></td>
        <td><?php echo $item->medium; ?></td>
        <td></td>
        <td><?php echo $item->location; ?></td>
    </tr>
        <?php endforeach; ?>
</table>
<?php endif; ?>