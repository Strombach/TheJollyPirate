<?php

namespace Model;

class Member
{
  private $ID;
  private $name;
  private $personalNumber;
  private $boats;

  public function __construct($ID, $name, $personalNumber, $boats)
  {
    $this->ID = $ID;
    $this->name = $name;
    $this->personalNumber = $personalNumber;
    $this->boats = $boats;
  }


  public function setID(int $ID): void
  {
    $this->ID = $ID;
  }

  public function setName(string $name): void
  {
    $this->name = $name;
  }

  public function setPersonalNumber(string $personalNumber): void
  {
    $this->personalNumber = $personalNumber;
  }



  public function getID(): int
  {
    return $this->ID;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getPersonalNumber(): string
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

  // public function removeBoatByID(string $ID): void
  // {
  //   $boatToRemove = $this->findBoatByID($ID);
  //   array_splice($this->boats, $boatToRemove);
  // }

  public function removeBoatByID(string $ID): void
  {
    $boatToRemove = $this->findBoatByID($ID);

    $key = array_search($boatToRemove, $this->boats);
    $removedBoat = array_splice($this->boats, $key, 1);
  }
}
