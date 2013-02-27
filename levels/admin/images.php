<?php
/* Get employee information */
$employee = Employees::find_by_id($session->employeeID);
?>
<?php
/* Get itemID */
$itemID = $_GET['itemID'];
/* Get photographs information */
$photographs = Photograph::find_all_by_itemID($itemID);
?>
<?php

if (isset ($_POST['submit'])) {

    $photograph = new Photograph();
    $photograph->itemID = $itemID;
    $photograph->attach_file($_FILES['file_upload']);
    $photograph->caption = $_POST['caption'];

    if ($photograph->save()) {
        // Success

        /* log entry */
        $log = new Log();
        $log->priority = 0;
        $log->time = time();
        $log->log = "Photo added: {$employee->full_name()} added photo id <a href=\"image.php?photographID={$photograph->id}\">{$photograph->id}</a>.";
        $log->create();

        $session->message("Photograph uploaded successfully.");
        redirect_to("images.php?itemID=$itemID");
    } else {
        // Failure
        $message = join("<br />", $photograph->errors);
        echo $message;
    }
}
?>

<a href="item.php?id=<?php echo $itemID; ?>">&laquo; back</a>
<?php if(!empty($photographs)) : ?>
<div class="box">

    <!--Begin displaying photos-->
        <?php foreach($photographs as $photograph) : ?>
    <div style="float: left; margin-left: 20px;">
        <a href="image.php?photographID=<?php echo $photograph->id; ?>" ><img alt="image" src="<?php echo $photograph->image_thumbnail_path(2); ?>" width="400"/></a>
        <center>Photograph id: <?php echo $photograph->id; ?></center>
        <center><?php echo $photograph->caption; ?></center>
        <center><input type="button" onclick="confirmationDeletePhoto(<?php echo $photograph->id;?>)" value="Delete Photo"></center>
    </div>
        <?php endforeach; ?>
    <!--End displaying photos-->

</div> <!--box-->
<?php endif; ?>

<form action="images.php?itemID=<?php echo $itemID; ?>" enctype="multipart/form-data" method="POST">
    <fieldset>
        <legend>Add Photo</legend>
        <ol>
            <li>
                <label for="file_upload">Photo:</label>
                <input id="file_upload"  name="file_upload" type="file" />
            </li>
            <li>
                <label for="caption">Caption:</label>
                <input id="caption"  name="caption" class="text" type="text" />
            </li>
        </ol>
    </fieldset>

    <fieldset class="submit">
        <input class="submit" type="submit" name="submit" value="Add photo" />
    </fieldset>
</form>