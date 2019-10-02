<?php

require_once('view/PageView.php');
require_once('view/ListView.php');
require_once('model/MemberStorage.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$pageView = new PageView();
$listView = new ListView(new MemberStorage('database.json'));

$pageView->render($listView);