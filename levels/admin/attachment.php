<?php

$conditionReportID = $_GET['conditionReportID'];

$conditionReport = ConditionReport::find_by_id($conditionReportID);

$item = Item::find_by_id($conditionReport->itemID);

/**
 * lighttpd's feature of X-Sendfile explained.
 *
 * @author Björn Schotte <schotte@mayflower.de>
 */
$file_on_harddisk = SITE_ROOT ."/conditionReports/" . $item->itemNumber . "/" . $conditionReport->filename  ;
$file_to_download = $conditionReport->filename;
        header( "Content-Disposition: attachment; filename=\"" . $file_to_download . '"' );
        header( "X-LIGHTTPD-send-file: " . $file_on_harddisk);
        header("Content-type: " . $conditionReport->type);
?>