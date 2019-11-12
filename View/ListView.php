<?php

namespace View;

/**
 * Class that handles rendering of lists of members and their
 * respective boats in a compact or a verbose manner.
 */
class ListView
{
  private $members;
  private $memberStorage;

  private static $member = \View\Config\Constants::memberURL;
  private static $fullname = "ListView::Fullname";
  private static $ssn = "ListView::Ssn";
  private static $delete = \View\Config\Constants::deleteURL;
  private static $verbose = \View\Config\Constants::verboseURL;
  private static $compact = \View\Config\Constants::compactURL;


  public function __construct($memberStorage)
  {
    $this->members = $memberStorage->getMembers();
    $this->memberStorage = $memberStorage;
  }

  /**
   * This method returns a HTML string with a list of all members in
   * either compact or verbose form.
   */
  public function response(): string
  {
    $ret = '';

    $ret .= $this->createAddMemberForm();

    if ($this->userWantsCompactList() || $this->userEntersSite()) {
      $ret .= $this->createCompactList();
    } else if ($this->userWantsVerboseList()) {
      $ret .= $this->createVerboseList();
    }

    return $ret;
  }

  public function getMemberToDelete()
  {
    return $_GET[self::$delete];
  }

  public function getNewMemberFromPost(): object
  {
    $name = $_POST[self::$fullname];
    $ssn = $_POST[self::$ssn];

    if (empty($name) || empty($ssn)) {
      throw new \Exception("All fields must be filled.");
    }

    $memberInfo = new \stdClass();

    $memberInfo->name = $name;
    $memberInfo->ssn = $ssn;

    return $memberInfo;
  }

  public function userWantsToAddNewMember(): bool
  {
    return isset($_POST[self::$fullname]);
  }

  public function userWantsToDeleteMember(): bool
  {
    return isset($_GET[self::$delete]);
  }


  private function userWantsVerboseList(): bool
  {
    return isset($_GET[self::$verbose]);
  }

  private function userWantsCompactList(): bool
  {
    return isset($_GET[self::$compact]);
  }

  private function userEntersSite(): bool
  {
    return empty($_GET);
  }

  private function createCompactList(): string
  {
    $listString = '<a href="?' . self::$verbose . '">Verbose List</a>';
    for ($i = 0; $i < sizeof($this->members); $i++) {
      $name = $this->members[$i]->getName();
      $id = $this->members[$i]->getID();
      $listString .= "<li>$name has " . $this->members[$i]->getBoatCount() . " boat.
      <a href='?" . self::$member . "=" . $id . "'>Manage</a>
      <a href='?" . self::$delete . "=" . $id . "'>Delete</a>
      </li>";
    }
    return $listString;
  }

  private function createVerboseList(): string
  {
    $listString = '<a href="?' . self::$compact . '">Compact List</a>';
    for ($i = 0; $i < sizeof($this->members); $i++) {
      $name = $this->members[$i]->getName();
      $id = $this->members[$i]->getID();
      $pn = $this->members[$i]->getPersonalNumber();
      $boatList = $this->createBoatList($this->members[$i]->getBoats());

      $listString .= "<li>$name ($pn), Member ID $id:<br> " . $boatList . "
      <a href='?" . self::$member . "=" . $id . "'>Manage</a>
      <a href='?" . self::$delete . "=" . $id . "'>Delete</a>
      </li>";
    }
    return $listString;
  }

  private function createAddMemberForm(): string
  {
    $ret = "<form action='?" . self::$compact . "=' method='post'>

    <label for='" . self::$fullname . "'>Full Name:</label>
    <input type='text' name='" . self::$fullname . "' placeholder='John Doe'>
    <label for='" . self::$ssn . "'>Social Security Number:</label>
    <input type='text' name='" . self::$ssn . "' placeholder='YYMMDDXXXX'>

    <input type='submit' value='Add new member'>

    </form>
    ";

    return $ret;
  }

  private function createBoatList(array $boatArr): string
  {
    $listString = '';
    for ($i = 0; $i < sizeof($boatArr); $i++) {
      $type = $boatArr[$i]->getType();
      $length = $boatArr[$i]->getLength();
      $id = $boatArr[$i]->getID();
      $boatNumber = $i + 1;

      $listString .= "Boat $boatNumber ID: $id Type: " . $type . " Length: $length cm.<br>";
    }
    return $listString;
  }
}
