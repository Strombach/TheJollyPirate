<?php

namespace View;

class ListView
{

  private $memberStorage;

  public function __construct($ms)
  {
    $this->memberStorage = $ms->getData();
  }

  public function response()
  {
    return '
    <p>This is from the ListView class, awesome!</p>
    ';
  }

  public function createCompactList()
  {
    $listString = '';
    for ($i = 0; $i < sizeof($this->memberStorage); $i++) {
      $name = $this->memberStorage[$i]->name;
      $listString .= "<li>$name has " . sizeof($this->memberStorage[$i]->boats) . " boat.</li>";
    }
    return $listString;
  }

  public function createVerboseList()
  {
    $listString = '';
    for ($i = 0; $i < sizeof($this->memberStorage); $i++) {
      $name = $this->memberStorage[$i]->name;
      $boatList = $this->createBoatList($this->memberStorage[$i]->boats);
      $listString .= "<li>$name has " . $boatList . "</li>";
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
