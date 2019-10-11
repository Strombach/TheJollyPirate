<?php

namespace Controller;

class Controller
{
  private $lv;
  private $pv;
  private $mv;

  public function __construct(\View\ListView $lV, \View\PageView $pV, \View\MemberView $mV, \View\EditMemberView $eMV, \Model\MemberStorage $mS, \View\EditBoatView $eBV)
  {
    $this->lv = $lV;
    $this->pv = $pV;
    $this->mv = $mV;
    $this->emv = $eMV;
    $this->ms = $mS;
    $this->ebv = $eBV;
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

    if ($this->emv->userWantsToUpdateMemberInfo()) {
      $this->doUpdateMemberInfo();
    }

    if ($this->ebv->userWantsToUpdateBoatInfo()) {
      $this->doUpdateBoatInfo();
    }
  }

  private function doRenderListView(): void
  {
    $this->pv->render($this->lv);
  }

  private function doRenderMemberView(): void
  {
    $this->pv->render($this->mv);
  }

  private function doRenderEditMemberView(): void
  {
    $this->pv->render($this->emv);
  }

  private function doRenderEditBoatView(): void
  {
    $this->pv->render($this->ebv);
  }

  private function doUpdateMemberInfo(): void
  {
    $updatedMemberObject = $this->emv->getUpdatedMemberFromPost();
    $this->ms->updateMemberInfo($updatedMemberObject);
  }

  private function doUpdateBoatInfo(): void
  {
    $updatedBoatObject = $this->ebv->getUpdatedBoatFromPost();
    $this->ms->updateBoatInfo($updatedBoatObject);
  }
}
