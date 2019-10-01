<?php

class ListView {

  private $memberStorage; 

  public function __construct ($ms) {
    $this->memberStorage = $ms->getData();
  }

  public function response () {
    return '
    <p>This is from the ListView class, awesome!</p>
    ';
  }

  public function createList() {
    $listString = '';
    for ($i = 0; $i < sizeof($this->memberStorage); $i++) {
      $name = $this->memberStorage[$i]->name;
      $listString .= "<li>$name</li>";
    }
    return $listString;
  }
}