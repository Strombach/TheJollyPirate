<?php

namespace Model;

class Boat
{
  private $type;
  private $lengthInCm;
  private $id;



  public function __construct(string $id, string $type, int $lengthInCm)
  {
    $this->id = $id;
    $this->updateType($type);
    $this->updateLength($lengthInCm);
  }


  public function updateLength(int $newLength): void
  {
    if ($newLength > 0 && is_int($newLength) === true) {
      $this->lengthInCm = $newLength;
    }
  }

  public function updateType($newType): void
  {
    $this->type = $newType;
  }



  public function getType(): string
  {
    return $this->type;
  }

  public function getLength(): int
  {
    return $this->lengthInCm;
  }

  public function getID(): string
  {
    return $this->id;
  }
}
