<?php

namespace View;

class MemberView
{
  private $ms;


  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }


  public function response($memberID): string
  {
    $ret = '<a href="?compact">Back to list</a>
    <a href="?memberedit=' . $memberID . '">Edit member</a>';

    $member = $this->ms->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->showMemberInfo($name, $id, $pn, $boats);

    return $ret;
  }


  private function showMemberInfo($name, $id, $pn, $boats): string
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

  private function createBoatTableRows($boats): string
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
