<?php

namespace View;

class ListView
{
  private $members;

  public function __construct($ms)
  {
    $this->members = $ms->getMembers();
  }

  public function response()
  {
    $ret = '';

    if ($this->userWantsCompactList() || $this->userEntersSite()) {
      $ret .= $this->createCompactList();
    } else if ($this->userWantsVerboseList()) {
      $ret .= $this->createVerboseList();
    }

    return $ret;
  }


  public function createCompactList()
  {
    $listString = '<a href="?verbose">Verbose List</a>';
    for ($i = 0; $i < sizeof($this->members); $i++) {
      $name = $this->members[$i]->getName();
      $id = $this->members[$i]->getID();
      $listString .= "<li>$name has " . $this->members[$i]->getBoatCount() . " boat.
      <a href='?member=" . $id . "'>Manage</a>
      </li>";
    }
    return $listString;
  }

  public function createVerboseList()
  {
    $listString = '<a href="?compact">Compact List</a>';
    for ($i = 0; $i < sizeof($this->members); $i++) {
      $name = $this->members[$i]->getName();
      $id = $this->members[$i]->getID();
      $boatList = $this->createBoatList($this->members[$i]->getBoats());
      $listString .= "<li>$name has " . $boatList . "
      <a href='?member=" . $id . "'>Manage</a>
      </li>";
    }
    return $listString;
  }

  private function createBoatList($boatArr)
  {
    $listString = '';
    for ($i = 0; $i < sizeof($boatArr); $i++) {
      $type = $boatArr[$i]->type;
      $length = $boatArr[$i]->lengthInCm;
      if ($i > 0) {
        $listString .= " And a " . $type . " and the length is: $length cm<br>";
      } else {
        $listString .= "a " . $type . " and the length is: $length cm.";
      }
    }
    return $listString;
  }

  
  private function userWantsVerboseList(): bool
  {
    return isset($_GET["verbose"]);
  }

  private function userWantsCompactList(): bool
  {
    return isset($_GET["compact"]);
  }

  private function userEntersSite(): bool
  {
    return empty($_GET);
  }
}
