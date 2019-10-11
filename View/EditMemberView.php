<?php

namespace View;

class EditMemberView
{
  private $ms;


  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }

  public function getUpdatedMemberFromPost(): \Model\Member
  {
    return new \Model\Member($_POST["id"], $_POST["name"], $_POST["pn"], []);
  }

  public function userWantsToUpdateMemberInfo()
  {
    return isset($_POST["name"]);
  }

  public function response($memberID): string
  {
    $ret = "<form action='?member=$memberID' method='post'>
    <input type='submit' value='Save'>";

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->createEditForm($name, $id, $pn, $boats);

    $ret .= '</form>';

    return $ret;
  }

  private function createEditForm($name, $id, $pn, $boats): string
  {
    $ret = "";

    $ret .= "
    <p>Name: <input type='text' name='name' value='$name'></p>
    <p>ID: <input readonly type='text' name='id' value='$id'></p>
    <p>Personal Number: <input type='text' name='pn' value='$pn'></p>
    ";

    $ret .= $this->createBoatTable($boats);

    return $ret;
  }

  private function createBoatTable(array $boats): string
  {
    $ret = "
    <h3>Boats</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Length</th>
      </tr>";

    $ret .= $this->createEditBoatTableRows($boats);

    $ret .= "
      </table>";
    return $ret;
  }

  private function createEditBoatTableRows($boats): string
  {
    $ret = "";
    for ($i = 0; $i < sizeof($boats); $i++) {
      $id = $boats[$i]->getID();
      $type = $boats[$i]->getType();
      $length = $boats[$i]->getLength();

      $ret .= "
    <tr>
      <td>$id</td>
      <td>$type</td>
      <td>$length cm</td>
      <td><a href='?editboat=" . $id . "'>Edit boat</a></td>
    </tr>";
    }
    return $ret;
  }
}
