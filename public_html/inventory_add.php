<?php require_once('../includes/initialize.php'); ?>

<!--Session page section-->
<?php if($session->is_logged_in()) : ?>
<?php session_include_layout_header($session); ?>
<?php session_include_layout_body($session,'inventory_add.php'); ?>
<?php session_include_layout_footer($session); ?>
<?php die;endif;?>

<?php redirect_to('index.php'); ?>
