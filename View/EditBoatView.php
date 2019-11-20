<?php

namespace View;

/**
 * Class that creates a form for a specific boat and handles the input of the
 * form to create a Boat object from that data that is used to update an existing boat.
 */
class EditBoatView
{
  private $memberStorage;

  private static $id = "EditBoatView::ID";
  private static $updatedType = "EditBoatView::UpdatedType";
  private static $updatedLength = "EditBoatView::UpdatedLength";
  private static $member = \View\Config\Constants::memberURL;
  private static $editBoat = \View\Config\Constants::editBoatURL;

  public function __construct(\Model\MemberStorage $mS)
  {
    $this->memberStorage = $mS;
  }

  public function wantsEditBoatPage()
  {
    return isset($_GET[self::$editBoat]);
  }

  public function getBoatToEdit()
  {
    return $_GET[self::$editBoat];
  }

  public function getUpdatedBoatFromPost(): \Model\Boat
  {
    $id = $_POST[self::$id];
    $type = $_POST[self::$updatedType];
    $length = (int) $_POST[self::$updatedLength];

    return new \Model\Boat($id, $type, $length);
  }

  public function userWantsToUpdateBoat(): bool
  {
    return isset($_POST[self::$updatedLength]);
  }

  /**
   * This method returns a html string with a form prefilled with details 
   * about a specific boat.
   * 
   * @param {string} $boatID The id of a boat.
   */
  public function response(string $boatID): string
  {
    $memberID = (int) substr($boatID, 0, 1);

    $ret = "<form action='?" . self::$member . "=$memberID' method='post'>
    <input type='submit' value='Save'>";

    $boat = $this->memberStorage->findBoatByID($memberID, $boatID);

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
    <p>ID: <input readonly type='text' name='" . self::$id . "' value='$id'></p>
    <p>Type:</p>
    <select type='dropdown' name='" . self::$updatedType . "'>
      <option name='" . self::$updatedType . "' value='Sailboat'>Sailboat</option>
      <option name='" . self::$updatedType . "' value='Motorsailer'>Motorsailer</option>
      <option name='" . self::$updatedType . "' value='Kayak/Canoe'>Kayak/Canoe</option>
      <option name='" . self::$updatedType . "' value='Other'>Other</option>
    </select>
    <br>
    <p>Length: <input type='text' name='" . self::$updatedLength . "' value='$length'>cm</p>
    ";

    return $ret;
  }
}
