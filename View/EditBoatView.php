<?php

namespace View;

/**
 * Class that creates a form for a specific boat and handles the input of the
 * form to create a Boat object from that data that is used to update an existing boat.
 */
class EditBoatView
{
  private $ms;


  public function __construct(\Model\MemberStorage $mS)
  {
    $this->ms = $mS;
  }


  public function getUpdatedBoatFromPost(): \Model\Boat
  {
    $id = $_POST["id"];
    $type = $_POST["updatedType"];
    $length = (int) $_POST["updatedLength"];

    return new \Model\Boat($id, $type, $length);
  }

  public function userWantsToUpdateBoat(): bool
  {
    return isset($_POST["updatedLength"]);
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
    <p>ID: <input readonly type='text' name='id' value='$id'></p>
    <p>Type:</p>
    <select type='dropdown' name='updatedType'>
      <option name='updatedType' value='Sailboat'>Sailboat</option>
      <option name='updatedType' value='Motorsailer'>Motorsailer</option>
      <option name='updatedType' value='Kayak/Canoe'>Kayak/Canoe</option>
      <option name='updatedType' value='Other'>Other</option>
    </select>
    <br>
    <p>Length: <input type='text' name='updatedLength' value='$length'>cm</p>
    ";

    return $ret;
  }
}
