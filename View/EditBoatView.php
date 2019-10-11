<?php

namespace View;

class EditBoatView
{
  private $ms;


  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }

  public function response($boatID): string
  {
    $memberID = (int) substr($boatID, 0, 1);

    $ret = "<form action='?member=$memberID' method='post'>
    <input type='submit' value='Save'>";

    $boat = $this->ms->findBoatByID($memberID, $boatID);

    $id = $boat->getID();
    $type = $boat->getType();
    $length = $boat->getLength();

    $ret .= $this->createEditForm($id, $type, $length);

    $ret .= '</form>';

    return $ret;
  }

  private function createEditForm(string $id, string $type, int $length): string
  {
    $ret = "";

    $ret .= "
    <p>ID: <input readonly type='text' name='name' value='$id'></p>
    <p>Type: <input type='text' name='id' value='$type'></p>
    <p>Length: <input type='text' name='pn' value='$length'>cm</p>
    ";

    return $ret;
  }
}
