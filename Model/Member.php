<?php

namespace Model;

class Member
{
  private $ID;
  private $name;
  private $personalNumber;
  private $boats;

  public function __construct()
  { }

  public function getID(): int
  {
    return $this->ID;
  }
}