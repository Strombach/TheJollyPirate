<?php

namespace View;

class MemberView
{
  private $ms;
  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }

  public function response($memberID)
  {
    $ret = "";

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $ret = "<p>$name</p>";

    return $ret;
  }
}
