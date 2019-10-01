<?php

class MemberStorage {
  private $jsonFile;
  private $phpObj;

  public function __construct ($path) {
    $this->jsonFile = file_get_contents($path, true);
    $this->phpObj = json_decode($this->jsonFile);
  }

  public function getData () {
    return $this->phpObj;
  }
}