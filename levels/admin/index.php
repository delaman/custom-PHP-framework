<?php

/* Get current page */
$page = !empty ($_GET['page']) ? (int) $_GET['page'] : 1;
/* Amount of logs per page */
$per_page = 50;
/* Count total amount of logs */
$total_count = Log::count_all();
/* Pagination information */
$pagination = new Pagination($page, $per_page, $total_count);
/* Get selected logs */
$logs = Log::find_all_by_page($page,$pagination);

?>

<?php echo $session->message(); ?>

<h2>Administrative Logs</h2>
<div class="box">
    <table id="logs" border="0" width="100%" cellpadding="10">
        <tr style="background-color: white;">
            <th width="10%">id</th>
            <th width="30%">time</th>
            <th width="60%">log</th>
        </tr>
        <?php foreach($logs as $log) : ?>
        <tr class="<?php echo $log->style_class();?>">
            <td align="center"><?php echo $log->id; ?></td>
            <td align="center"><?php echo $log->get_time(); ?></td>
            <td id="actualNote"><?php echo $log->log; ?></td>
        </tr>
        <?php endforeach;?>
    </table>
</div> <!--box-->

<div id="pagination" style="clear: both;">
    <?php

    if ($pagination->total_pages() > 1) {

        if ($pagination->has_previous_page()) {
            echo "<a href=\"index.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo; Previous</a> ";
        }

        for ($i = 1; $i <= $pagination->total_pages(); $i++) {
            if ($i == $page) {
                echo " <span class=\"selected\">{$i}</span> ";
            } else {
                echo " <a href=\"index.php?page={$i}\">{$i}</a> ";
            }
        }

        if ($pagination->has_next_page()) {
            echo " <a href=\"index.php?page=";
            echo $pagination->next_page();
            echo "\">Next &raquo;</a> ";
        }

    }
    ?>
</div>
