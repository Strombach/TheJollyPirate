<?php

namespace Model;

use Exception;

class Boat
{
  private $type;
  private $lengthInCm;
  private $id;

  // Arguments are NOT strictly typed because the setter handles errors.
  public function __construct(string $id, $type, $lengthInCm)
  {
    $this->id = $id;
    $this->updateType($type);
    $this->updateLength($lengthInCm);
  }


  public function updateLength($newLength): void
  {
    if ($newLength > 0 && is_int($newLength) === true) {
      $this->lengthInCm = $newLength;
    } else {
      throw new Exception('Boat length must be a number and greater than zero.');
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
