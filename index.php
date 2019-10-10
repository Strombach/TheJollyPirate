<?php

require_once('View/PageView.php');
require_once('View/ListView.php');
require_once('Model/MemberStorage.php');
require_once('Controller/Controller.php');
require_once('Model/Member.php');
require_once('View/MemberView.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$memberStorage = new \Model\MemberStorage('database.json');
$pageView = new \View\PageView();
$listView = new \View\ListView($memberStorage);
$memberView = new \View\MemberView($memberStorage);

$controller = new \Controller\Controller($listView, $pageView, $memberView);

$controller->doRenderPageView();
