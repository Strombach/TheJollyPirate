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

  public function addBoat(\Model\Boat $newBoat): void
  {
    array_push($this->boats, $newBoat);
  }

  public function findBoatByID(int $ID): \Model\Boat
  {
    foreach ($this->boats as $boat) {
      if ($boat->id == $ID) {
        return $boat;
      }
    }
  }

  public function removeBoat(int $ID): void
  {
    $boatToRemove = $this->findBoatByID($ID);
    array_splice($this->boats, $boatToRemove);
  }
}
