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
    $this->pv->render($this->lv);
  }

  public function doRenderMemberView($memberID)
  {
    $this->pv->render($this->mv->response($memberToRender));
  }
}
