<?php

namespace Controller;

/**
 * Class for Controller.
 * Gathers information from the programs' different views and performs actions thereafter.
 */
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
    if ($this->memberView->wantsMemberPage()) {
      $this->doRenderMemberView();
    } else if ($this->editMemberView->wantsEditMemberPage()) {
      $this->doRenderEditMemberView();
    } else if ($this->editBoatView->wantsEditBoatPage()) {
      $this->doRenderEditBoatView();
    } else {
      $this->doRenderListView();
    }

    if ($this->editMemberView->userWantsToUpdateMember()) {
      $this->doUpdateMember();
    }
    if ($this->editBoatView->userWantsToUpdateBoat()) {
      $this->doUpdateBoat();
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

    $this->listView->redirect();
  }

  private function doDeleteMember(): void
  {
    $memberToDeleteID = $this->listView->getMemberToDelete();
    $this->memberStorage->removeMemberByID($memberToDeleteID);

    $this->listView->redirect();
  }

  private function doAddBoat(): void
  {
    $memberToAddBoatTo = $this->memberStorage->findMemberByID($this->memberView->getUserID());

    $newBoatInfo = $this->memberView->getNewBoatInfoFromPost();

    $boatIDs = $memberToAddBoatTo->getBoatIDs();

    $IDToUse = $memberToAddBoatTo->getFirstVacantBoatID($boatIDs);

    $newBoat = new \Model\Boat($IDToUse, $newBoatInfo->type, $newBoatInfo->length);

    $memberToAddBoatTo->addBoatToMember($newBoat);

    $this->memberStorage->saveToDatabase();

    $ID = $this->memberView->getUserID();
    $this->memberView->redirect($ID);
  }

  private function doDeleteBoat(): void
  {
    $memberID = substr($this->editMemberView->getBoatToDelete(), 0, 1);
    $memberToDeleteBoatFrom = $this->memberStorage->findMemberByID($memberID);

    $boatToDeleteID = $this->editMemberView->getBoatToDelete();
    $memberToDeleteBoatFrom->removeBoatByID($boatToDeleteID);

    $this->memberStorage->saveToDatabase();

    $this->memberView->redirect($memberID);
  }

  private function doUpdateMember(): void
  {
    $updatedMemberObject = $this->editMemberView->getUpdatedMemberFromPost();
    $this->memberStorage->updateMember($updatedMemberObject);

    $ID = $updatedMemberObject->getID();

    $this->memberView->redirect($ID);
  }

  private function doUpdateBoat(): void
  {
    $updatedBoatObject = $this->editBoatView->getUpdatedBoatFromPost();
    var_dump($updatedBoatObject);
    $this->memberStorage->updateBoat($updatedBoatObject);

    $ID = $updatedBoatObject->getID();
    
    $this->memberView->redirect($ID);
  }
}
