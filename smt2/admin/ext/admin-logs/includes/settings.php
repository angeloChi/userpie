<?php
// if JavaScript is not enabled, get page number (otherwise, start from scratch)
$page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;

// use this value in case of having empty values both from DB and current session
$defaultNumRecords = 20;
// use this flag to reset DB query
$resetFlag = "prevall";
// the 'more' link text
$showMoreText = "More results";
// use this text to stop requesting more records from DB
$noMoreText = '<h4 class="alert alert-danger" align="center">No more records found!</h4>';
?>