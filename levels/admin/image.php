<?php
  if(empty($_GET['photographID'])) {
    $session->message("No photograph ID was provided.");
    redirect_to('index.php');
  }

  $photo = Photograph::find_by_id($_GET['photographID']);
  if(!$photo) {
    $session->message("The photo could not be located.");
    redirect_to('index.php');
  }
?>


<center><a href="images.php?itemID=<?php echo $photo->itemID; ?>"><img width="800" alt="<?php echo $photo->caption; ?>" src="<?php echo $photo->image_path(); ?>" /></a></center>

