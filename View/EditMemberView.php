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

  // public function getUpdatedBoatsFromPost(): \Model\Member
  // {
  //   return new \Model\Member($_POST["id"], $_POST["name"], $_POST["pn"], []);
  // }

  public function userWantsToUpdateInfo()
  {
    return isset($_POST["name"]);
  }

  public function response($memberID): string
  {
    $ret = "<form action='?member=$memberID' method='post'>
    <input type='submit' value='Save member information'>";

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->createEditForm($name, $id, $pn, $boats);


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

    $ret .= '</form>';

    $ret .= $this->createBoatTable($boats, $id);

    return $ret;
  }

  private function createBoatTable(array $boats, int $memberID): string
  {
    $ret = "
    <h3>Boats</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Length</th>
      </tr>";

    $ret .= $this->createEditBoatTableRows($boats, $memberID);

    $ret .= "
      </table>";
    return $ret;
  }

  private function createEditBoatTableRows($boats, int $memberID): string
  {
    $ret = "";
    for ($i = 0; $i < sizeof($boats); $i++) {
      $id = $boats[$i]->getID();
      $type = $boats[$i]->getType();
      $length = $boats[$i]->getLength();

      $ret .= "
     
    <tr>
      <form action='?memberedit=$memberID' method='post'>
      <td><input readonly type='text' name='boatID' value='$id'></td>
      <td><input type='text' name='boatType' value='$type'></td>
      <td><input type='text' name='boatLength' value='$length'> cm</td>
      <td><input type='submit' value='Save this boat'></td>
      </form>
    </tr>
    ";
    }
    return $ret;
  }
}
