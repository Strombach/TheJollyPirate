<?php

namespace View;

class ListView
{

  // private $memberStorage;
  private $members;

  public function __construct($ms)
  {
    $this->members = $ms->getMemberObjectArray();
  }

  public function response()
  {
    return '
    <p>This is from the ListView class, awesome!</p>
    ';
  }

  public function userWantsVerbose()
  {
    if (!isset($_GET["verbose"])) {
      return $this->createCompactList();
    } else {
      return $this->createVerboseList();
    }
  }

  public function createCompactList()
  {
    $listString = '';
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
    $listString = '';
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
      $length = $boatArr[$i]->cm;
      if ($i > 0) {
        $listString .= " And a " . $type . " and the length is: $length cm<br>";
      } else {
        $listString .= "a " . $type . " and the length is: $length cm.";
      }
    }
    return $listString;
  }
}
