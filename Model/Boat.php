<?php

namespace Model;

class Boat
{
  private $type;
  private $lengthInCm;
  private $id;



  public function __construct(String $type, int $length)
  {
    $this->id = abs(crc32(uniqid('', true)));
    $this->updateType($type);
    $this->updateLength($length);
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


  
  public function getBoatType(): string
  {
    return $this->type;
  }

  public function getBoatLength(): int
  {
    return $this->lengthInCm;
  }

  public function getBoatId(): int
  {
    return $this->id;
  }
}
