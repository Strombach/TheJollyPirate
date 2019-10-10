<?php

namespace Model;

class MemberStorage
{
  private $members;
  private $jsonFile;
  private $membersJSONArray;

  public function __construct($path)
  {
    $this->jsonFile = file_get_contents($path, true);
    $this->membersJSONArray = json_decode($this->jsonFile);
<<<<<<< HEAD
    var_dump($this->membersJSONArray);
=======
    $this->members = $this->getMemberObjectArray();
>>>>>>> master
  }

  public function getMemberObjectArray(): array
  {
    $memberObjectArray = array();
<<<<<<< HEAD
    for ($i=0; $i < sizeof($this->membersJSONArray); $i++) {
      $ID = $this->membersJSONArray[$i]->id;
      $name = $this->membersJSONArray[$i]->name;
      $personalNumber = $this->membersJSONArray[$i]->p.n;
      $boats = $this->membersJSONArray[$i]->boats;
      array_push($memberObjectArray, new \Model\Member($ID, $name, $personalNumber, $boats));
    }
    return $this->memberObjectArray;
=======
    for ($i = 0; $i < sizeof($this->membersJSONArray); $i++) {
      $ID = $this->membersJSONArray[$i]->id;
      $name = $this->membersJSONArray[$i]->name;
      $personalNumber = $this->membersJSONArray[$i]->pn;
      $boats = $this->membersJSONArray[$i]->boats;
      array_push($memberObjectArray, new \Model\Member($ID, $name, $personalNumber, $boats));
    }
    return $memberObjectArray;
>>>>>>> master
  }

  public function addMember(\Model\Member $newMember): void
  {
    array_push($this->members, $newMember);
  }

  public function findMemberByID(int $ID): \Model\Member
  {
    foreach ($this->members as $member) {
      if ($member->getID() == $ID) {
        return $member;
      }
    }
  }

  public function removeMember(int $ID): void
  {
    $memberToRemove = $this->findMemberByID($ID);
    array_splice($this->members, $memberToRemove);
  }
}
