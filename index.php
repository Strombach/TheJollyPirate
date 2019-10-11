<?php

require_once('View/PageView.php');
require_once('View/ListView.php');
require_once('View/MemberView.php');
require_once('View/EditMemberView.php');
require_once('View/EditBoatView.php');

require_once('Model/Member.php');
require_once('Model/MemberStorage.php');
require_once('Model/Boat.php');

require_once('Controller/Controller.php');

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$memberStorage = new \Model\MemberStorage('database.json');
$pageView = new \View\PageView();
$listView = new \View\ListView($memberStorage);
$memberView = new \View\MemberView($memberStorage);
$editMemberView = new \View\EditMemberView($memberStorage);
$editBoatView = new \View\EditBoatView($memberStorage);

$controller = new \Controller\Controller($listView, $pageView, $memberView, $editMemberView, $memberStorage, $editBoatView);

$controller->doRenderPageView();
