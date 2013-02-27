<div style="clear: both;"> </div>
</div><!-- content end-->

<div class="menu"></div>
<div id="footer">&copy; Copyright <?php echo date("Y", time()); ?>, </div>

</div><!-- wrapper end-->
</body>
</html>


<?php if(isset($database)) {
    $database->close_connection();
} ?>
