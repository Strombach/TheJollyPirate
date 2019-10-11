<?php

namespace View;

class MemberView
{
  private $ms;



  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }

  // private function userWantsInfo () {
  //   return $_GET["info"];
  // }

  public function response($memberID)
  {
    $ret = '<a href="?compact">Back to list</a>';

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->showMemberInfo($name, $id, $pn, $boats);

    return $ret;
  }

  private function showMemberInfo($name, $id, $pn, $boats)
  {
    $ret = "";

    $ret .= "
    <p>Name: $name</p>
    <p>ID: $id</p>
    <p>Personal Number: $pn</p>
    ";

    // TODO: Boats-table, loopa genom o grejer. Kanske göra en egen privat metod åt detta

    return $ret;
  }
}
