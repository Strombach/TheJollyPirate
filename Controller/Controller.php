<?php

namespace Controller;

class Controller
{
  private $lv;
  private $pv;
  private $mv;

  // public function __construct(\View\ListView $lV, \View\PageView $pV, \View\MemberView $mV, \View\EditMemberView $eMV, \Model\MemberStorage $mS, \View\EditBoatView $eBV)
  public function __construct(object $views)
  {
    $this->memberStorage = $views->memberStorage;
    $this->pageView = $views->pageView;
    $this->listView = $views->listView;
    $this->memberView = $views->memberView;
    $this->editMemberView = $views->editMemberView;
    $this->editBoatView =$views->editBoatView;
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

    if ($this->editMemberView->userWantsToUpdateMemberInfo()) {
      $this->doUpdateMemberInfo();
    }

    if ($this->editBoatView->userWantsToUpdateBoatInfo()) {
      $this->doUpdateBoatInfo();
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

  private function doAddNewMember (): void {
    $newMember = $this->listView->getNewMemberFromPost();
  }

  private function doUpdateMemberInfo(): void
  {
    $updatedMemberObject = $this->editMemberView->getUpdatedMemberFromPost();
    $this->memberStorage->updateMemberInfo($updatedMemberObject);
  }

  private function doUpdateBoatInfo(): void
  {
    $updatedBoatObject = $this->editBoatView->getUpdatedBoatFromPost();
    $this->memberStorage->updateBoatInfo($updatedBoatObject);
  }
}
