<?php

require_once('View/PageView.php');
require_once('View/ListView.php');
require_once('Model/MemberStorage.php');
require_once('Controller/Controller.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$pageView = new \View\PageView();
$listView = new \View\ListView(new \Model\MemberStorage('database.json'));

$controller = new \Controller\Controller($listView, $pageView);
//$pageView->render($listView);
