<?php

namespace Controller;

class Controller
{
  private $memberStorage;
  private $pageView;
  private $listView;
  private $memberView;
  private $editMemberView;
  private $editBoatView;


  public function __construct(object $views)
  {
    $this->memberStorage = $views->memberStorage;
    $this->pageView = $views->pageView;
    $this->listView = $views->listView;
    $this->memberView = $views->memberView;
    $this->editMemberView = $views->editMemberView;
    $this->editBoatView = $views->editBoatView;
  }


  public function doRenderPageView(): void
  {
    if (isset($_GET["member"])) {
      $this->doRenderMemberView();
    } else if (isset($_GET["editmember"])) {
      $this->doRenderEditMemberView();
    } else if (isset($_GET["editboat"])) {
      $this->doRenderEditBoatView();
    } else {
      $this->doRenderListView();
    }

    if ($this->editMemberView->userWantsToUpdateMember()) {
      $this->doUpdateMemberInfo();
    }
    if ($this->editBoatView->userWantsToUpdateBoat()) {
      $this->doUpdateBoatInfo();
    }

    if ($this->listView->userWantsToAddNewMember()) {
      $this->doAddNewMember();
    }
    if ($this->listView->userWantsToDeleteMember()) {
      $this->doDeleteMember();
    }

    if ($this->memberView->userWantsToAddBoat()) {
      $this->doAddBoat();
    }
    if ($this->editMemberView->userWantsToDeleteBoat()) {
      $this->doDeleteBoat();
    }
  }


  private function doRenderListView(): void
  {
    $this->pageView->render($this->listView);
  }

  private function doRenderMemberView(): void
  {
    $this->pageView->render($this->memberView);
  }

  private function doRenderEditMemberView(): void
  {
    $this->pageView->render($this->editMemberView);
  }

  private function doRenderEditBoatView(): void
  {
    $this->pageView->render($this->editBoatView);
  }

  private function doAddNewMember(): void
  {
    $newMemberInfo = $this->listView->getNewMemberFromPost();

    $memberIDs = $this->memberStorage->getMemberIDs();

    $IDToUse = $this->memberStorage->getFirstVacantMemberID($memberIDs);

    $newMember = new \Model\Member($IDToUse, $newMemberInfo->name, $newMemberInfo->ssn, array());

    $this->memberStorage->addMember($newMember);

    header("Location: /");
  }

  private function doDeleteMember(): void
  {
    $memberToDeleteID = $_GET["delete"];
    $this->memberStorage->removeMemberByID($memberToDeleteID);

    header("Location: /");
  }

  private function doAddBoat(): void
  {
    $memberToAddBoatTo = $this->memberStorage->findMemberByID($_GET["member"]);

    $newBoatInfo = $this->memberView->getNewBoatInfoFromPost();

    $boatIDs = $memberToAddBoatTo->getBoatIDs();

    $IDToUse = $memberToAddBoatTo->getFirstVacantBoatID($boatIDs);

    $newBoat = new \Model\Boat($IDToUse, $newBoatInfo->type, $newBoatInfo->length);

    $memberToAddBoatTo->addBoat($newBoat);

    $this->memberStorage->saveToDatabase();

    $ID = $_GET["member"];
    header("Location: /?member=$ID");
  }

  private function doDeleteBoat(): void
  {
    $memberID = substr($_GET["deleteboat"], 0, 1);
    $memberToDeleteBoatFrom = $this->memberStorage->findMemberByID($memberID);

    $boatToDeleteID = $_GET["deleteboat"];
    $memberToDeleteBoatFrom->removeBoatByID($boatToDeleteID);

    $this->memberStorage->saveToDatabase();

    header("Location: /?member=$memberID");
  }

  private function doUpdateMemberInfo(): void
  {
    $updatedMemberObject = $this->editMemberView->getUpdatedMemberFromPost();
    $this->memberStorage->updateMemberInfo($updatedMemberObject);

    $ID = $updatedMemberObject->getID();
    header("Location: /?member=$ID");
  }

  private function doUpdateBoatInfo(): void
  {
    $updatedBoatObject = $this->editBoatView->getUpdatedBoatFromPost();
    $this->memberStorage->updateBoatInfo($updatedBoatObject);

    $ID = $updatedBoatObject->getID();
    header("Location: /?member=$ID");
  }
}
