<?php //require_once("../includes/initialize.php"); ?>
<?php //include_layout_template('header.php'); ?>

<?php //include_layout_template('footer.php'); ?>

<?php require_once('../includes/initialize.php'); ?>

<!--Session page section-->
<?php if($session->is_logged_in()) : ?>
<?php session_include_layout_header($session); ?>
<?php session_include_layout_body($session,'index.php'); ?>
<?php session_include_layout_footer($session); ?>
<?php die;endif;?>


<?php include_layout_template('header.php'); ?>

<?php include_layout_template('footer.php'); ?>
