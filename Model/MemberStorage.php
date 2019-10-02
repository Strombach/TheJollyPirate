<?php

namespace Model;

class MemberStorage
{
  private $members;
  private $jsonFile;

  public function __construct($path)
  {
    $this->jsonFile = file_get_contents($path, true);
    $this->members = json_decode($this->jsonFile);

    var_dump($this->members);
  }

  public function addMember(\Model\Member $newMember): void
  { 
    array_push($this->members, $newMember);
  }

  public function findMemberByID(int $ID): \Model\Member
  { 
    foreach ($this->members as $member) {
      if ($member->id == $ID) {
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
