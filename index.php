<?php

require_once('View/PageView.php');
require_once('View/ListView.php');
require_once('View/MemberView.php');
require_once('View/EditMemberView.php');
require_once('View/EditBoatView.php');

require_once('View/Config/Constants.php');

require_once('Model/Member.php');
require_once('Model/MemberStorage.php');
require_once('Model/Boat.php');

require_once('Controller/Controller.php');

try {
    $views = new stdClass();

    $views->memberStorage = new \Model\MemberStorage('database.json');
    $views->pageView = new \View\PageView();
    $views->listView = new \View\ListView($views->memberStorage);
    $views->memberView = new \View\MemberView($views->memberStorage);
    $views->editMemberView = new \View\EditMemberView($views->memberStorage);
    $views->editBoatView = new \View\EditBoatView($views->memberStorage);

    $controller = new \Controller\Controller($views);

    $controller->doRenderPageView();
} catch (Exception $e) {
    echo '<h3>Error: ',  $e->getMessage(), "\n</h3>";
}
