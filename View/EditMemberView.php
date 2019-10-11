<?php

namespace View;

class EditMemberView
{
  private $ms;
  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }

  private function userWantsToEdit()
  {
    return isset($_GET["member"]);
  }

  private function userWantsToSave()
  {
    return isset($_POST["saveedit"]);
  }

  public function response($memberID)
  {
    $ret = '<a href="?compact">Back to list</a>';

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->editMemberInfo($name, $id, $pn, $boats);

    return $ret;
  }

  private function editMemberInfo($name, $id, $pn, $boats)
  {
    $ret = "";

    $ret .= "
    <form action='/?member=$id' method='post'>
      <button type='submit' formmethod='post'>Submit using POST</button>
    </form>
    <p>Name: $name</p>
    <p>ID: $id</p>
    <p>Personal Number: $pn</p>
    ";

    if ($this->userWantsToEdit()) {
      echo 'userWantsToEdit';
    }

    // TODO: Boats-table, loopa genom o grejer. Kanske göra en egen privat metod åt detta

    return $ret;
  }


}
