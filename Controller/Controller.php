<?php

namespace Controller;

class Controller
{

  private $lv;
  private $pv;
  private $mv;

  public function __construct(\View\ListView $lV, \View\PageView $pV, \View\MemberView $mV)
  {
    $this->lv = $lV;
    $this->pv = $pV;
    $this->mv = $mV;
  }

  public function doRenderPageView()
  {
    if (!isset($_GET["member"])) {
      $this->doRenderListView();
    } else if (isset($_GET["member"])) {
      $this->doRenderMemberView((int) $_GET["member"]);
    }
  }

  public function doRenderListView()
  {
    $this->pv->render($this->lv);
  }

  public function doRenderMemberView($memberID)
  {
    $this->pv->render($this->mv);
  }
}
