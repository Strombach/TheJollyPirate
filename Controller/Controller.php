<?php

namespace Controller;

class Controller
{

  private $lv;
  private $pv;

  public function __construct(\View\ListView $listView, \View\PageView $pageView)
  {
    $this->lv = $listView;
    $this->pv = $pageView;
  }

  public function doRenderPageView()
  {
    $this->pv->render($this->lv);
  }
}
