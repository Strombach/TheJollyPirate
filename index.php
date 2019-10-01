<?php

require_once('view/PageView.php');
require_once('view/ListView.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$pageView = new PageView();
$listView = new ListView();

$pageView->render($listView);