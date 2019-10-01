<?php

require_once('view/PageView.php');
require_once('view/ListView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$pageView = new PageView();
$listView = new ListView();

$pageView->render();