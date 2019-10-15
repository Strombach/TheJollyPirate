<?php

namespace Model;

use Exception;

class Member
{
  private $ID;
  private $name;
  private $personalNumber;
  private $boats;

  // Arguments are NOT strictly typed because the setter handles errors.
  public function __construct($ID, $name, $personalNumber, $boats)
  {
    $this->setID($ID);
    $this->setName($name);
    $this->setPersonalNumber((int)$personalNumber);
    $this->boats = $boats;
  }


  public function setID($ID): void
  {
    $this->ID = $ID;
  }

  public function setName($name): void
  {
    if (strlen($name) >= 2) {
      $this->name = $name;
    } else {
      throw new Exception('Name must be at least 2 characters.');
    }
  }

  public function setPersonalNumber($personalNumber): void
  {
    if (is_int($personalNumber) && strlen($personalNumber) == 10) {
      $this->personalNumber = $personalNumber;
    } else {
      throw new Exception('Personal number must contain only numbers and be formatted as YYMMDDXXXX.');
    }
  }



  public function getID(): int
  {
    return $this->ID;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getPersonalNumber(): int
  {
    return $this->personalNumber;
  }

  public function getBoatCount(): int
  {
    return count($this->boats);
  }

  public function getBoats(): array
  {
    return $this->boats;
  }

  public function getBoatIDs(): array
  {
    $boats = $this->getBoats();
    $boatIDs = array();
    for ($i = 0; $i < sizeof($boats); $i++) {
      array_push($boatIDs, $boats[$i]->getID());
    }
    return $boatIDs;
  }

  public function getFirstVacantBoatID($boatIDs): string
  {
    $memberIDString = $this->getID() . '_';

    for ($i = 1; $i <= sizeof($boatIDs); $i++) {
      if ($boatIDs[$i - 1] != $memberIDString . $i) {
        return $memberIDString . $i;
      }
    }
    return $memberIDString . (sizeof($boatIDs) + 1);
  }

  public function addBoat(\Model\Boat $newBoat): void
  {
    array_push($this->boats, $newBoat);
  }

  public function findBoatByID(string $ID): \Model\Boat
  {
    foreach ($this->boats as $boat) {
      if ($boat->getID() == $ID) {
        return $boat;
      }
    }
  }

  public function removeBoatByID(string $ID): void
  {
    $boatToRemove = $this->findBoatByID($ID);

    $key = array_search($boatToRemove, $this->boats);
    $removedBoat = array_splice($this->boats, $key, 1);
  }
}
