

<div style="clear: both;"> </div>
</div><!-- content end-->

<div id="bottom"> </div>
<div id="footer">Copyright <?php echo date("Y", time()); ?>,</div>

</div><!-- wrapper end-->
</body>
</html>


<?php if(isset($database)) {
    $database->close_connection();
} ?>
