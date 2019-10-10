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
    $this->ms->findMemberByID($memberID);
    return "
    <p>" . $member->getName() . "</p>
    ";
  }
}
