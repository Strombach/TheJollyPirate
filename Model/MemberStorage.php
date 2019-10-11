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
    $this->members = $this->getMemberObjectArray();
  }

  public function getMembers(): array
  {
    return $this->members;
  }

  private function getMemberObjectArray(): array
  {
    $memberObjectArray = array();
    for ($i = 0; $i < sizeof($this->membersJSONArray); $i++) {
      $ID = $this->membersJSONArray[$i]->id;
      $name = $this->membersJSONArray[$i]->name;
      $personalNumber = $this->membersJSONArray[$i]->pn;
      $boats = $this->membersJSONArray[$i]->boats;
      array_push($memberObjectArray, new \Model\Member($ID, $name, $personalNumber, $boats));
    }
    return $memberObjectArray;
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
