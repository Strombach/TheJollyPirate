<?php

namespace View;

class MemberView
{
  private $ms;


  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }


  public function userWantsToAddBoat(): bool
  {
    return isset($_POST["type"]);
  }

  public function getNewBoatInfoFromPost()
  {
    $type = $_POST["type"];
    $length = (int) $_POST["length"];

    $boatInfo = new \stdClass();

    $boatInfo->type = $type;
    $boatInfo->length = $length;

    return $boatInfo;
  }

  public function response($memberID): string
  {
    $ret = '<a href="?compact">Back to list</a>
    <a href="?editmember=' . $memberID . '">Edit member</a>';

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->showMemberInfo($name, $id, $pn, $boats);

    $ret .= $this->createAddBoatForm($id);

    return $ret;
  }


  private function createAddBoatForm($id): string
  {
    $ret = "<form action='?member=$id' method='post'>

    <label for='type'>Boat type:</label>
    <br>
    <select type='dropdown' name='type'>
      <option name='type' value='Sailboat'>Sailboat</option>
      <option name='type' value='Motorsailer'>Motorsailer</option>
      <option name='type' value='Kayak/Canoe'>Kayak/Canoe</option>
      <option name='type' value='Other'>Other</option>
    </select>
    <br>
    <label for='length'>Length in Cm:</label>
    <input type='text' name='length' placeholder='XXXX'>

    <input type='submit' value='Add new boat'>

    </form>
    ";

    return $ret;
  }

  private function showMemberInfo($name, $id, $pn, array $boats): string
  {
    $ret = "";

    $ret .= "
    <p>Name: $name</p>
    <p>ID: $id</p>
    <p>Personal Number: $pn</p>
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

    $ret .= $this->createBoatTableRows($boats);

    $ret .= "
      </table>";
    return $ret;
  }

  private function createBoatTableRows(array $boats): string
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
    </tr>";
    }
    return $ret;
  }
}
