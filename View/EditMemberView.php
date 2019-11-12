<?php

namespace View;

/**
 * Class that creates a form for a specific member and handles the input of the
 * form to create a  Member object from that data to update an existing
 * member in the database.
 */
class EditMemberView
{
  private $ms;

  private static $editMember = "editmember";
  private static $member = \View\Config\Constants::memberURL;


  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }


  public function wantsEditMemberPage()
  {
    return isset($_GET[self::$editMember]);
  }

  public function getUpdatedMemberFromPost(): \Model\Member
  {
    return new \Model\Member($_POST["id"], $_POST["name"], $_POST["pn"], []);
  }

  public function userWantsToUpdateMember(): bool
  {
    return isset($_POST["name"]);
  }

  public function userWantsToDeleteBoat(): bool
  {
    return isset($_GET["deleteboat"]);
  }


  /**
   * This method returns a html string with a form prefilled with details about a specific member.
   * 
   * @param {int} $memberID The id of a member.
   */
  public function response(int $memberID): string
  {
    $ret = "<form action='?" . self::$member . "=$memberID' method='post'>
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


  private function createEditForm(string $name, int $id, int $pn, array $boats): string
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

  private function createEditBoatTableRows(array $boats): string
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
      <td><a href='?editboat=" . $id . "'>Edit</a></td>
      <td><a href='?deleteboat=" . $id . "'>Delete</a></td>
    </tr>";
    }
    return $ret;
  }
}
