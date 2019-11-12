<?php

namespace View;

/**
 * The class creates the HTML for a specific member and presents the members boats.
 */
class MemberView
{
  private $memberStorage;

  private static $type = "MemberView::Type";
  private static $length = "MemberView::Length";
  private static $member = \View\Config\Constants::memberURL;


  public function __construct(\Model\MemberStorage $memberStorage)
  {
    $this->memberStorage = $memberStorage;
  }


  public function wantsMemberPage()
  {
    return isset($_GET[self::$member]);
  }

  public function getUserID()
  {
    return (int) $_GET[self::$member];
  }

  public function userWantsToAddBoat(): bool
  {
    return isset($_POST[self::$type]);
  }

  public function getNewBoatInfoFromPost(): object
  {
    $type = $_POST[self::$type];
    $length = (int) $_POST[self::$length];

    $boatInfo = new \stdClass();

    $boatInfo->type = $type;
    $boatInfo->length = $length;

    return $boatInfo;
  }


  /**
   * This method returns a html string
   * with all the details of a specific
   * member.
   * @param {int} $memberID The id of a member.
   */
  public function response(int $memberID): string
  {
    $ret = '<a href="?compact">Back to list</a>
    <a href="?editmember=' . $memberID . '">Edit member</a>';

    $member = $this->memberStorage->findMemberByID($memberID);

    $name = $member->getName();
    $id = $member->getID();
    $pn = $member->getPersonalNumber();
    $boats = $member->getBoats();

    $ret .= $this->showMemberInfo($name, $id, $pn, $boats);

    $ret .= $this->createAddBoatForm($id);

    return $ret;
  }


  private function createAddBoatForm(int $id): string
  {
    $ret = "<form action='?" . self::$member . "=$id' method='post'>

    <label for='type'>Boat type:</label>
    <br>
    <select type='dropdown' name='" . self::$type . "'>
      <option name='" . self::$type . "' value='Sailboat'>Sailboat</option>
      <option name='" . self::$type . "' value='Motorsailer'>Motorsailer</option>
      <option name='" . self::$type . "' value='Kayak/Canoe'>Kayak/Canoe</option>
      <option name='" . self::$type . "' value='Other'>Other</option>
    </select>
    <br>
    <label for='" . self::$length . "'>Length in Cm:</label>
    <input type='text' name='" . self::$length . "' placeholder='XXXX'>

    <input type='submit' value='Add new boat'>

    </form>
    ";

    return $ret;
  }

  private function showMemberInfo(string $name, int $id, int $pn, array $boats): string
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
