<?php

namespace Model;

class MemberStorage
{
  private $members;
  private $jsonFile;
  private $membersJSONArray;
  private $path;

  public function __construct($path)
  {
    $this->path = $path;
    $this->jsonFile = file_get_contents($this->path, true);
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
      $boats = $this->createBoatObjects($this->membersJSONArray[$i]->boats);

      array_push($memberObjectArray, new \Model\Member($ID, $name, $personalNumber, $boats));
    }
    return $memberObjectArray;
  }

  private function createBoatObjects($boats): array
  {
    $ret = array();

    for ($i = 0; $i < sizeof($boats); $i++) {
      $id = $boats[$i]->id;
      $type = $boats[$i]->type;
      $lengthInCm = $boats[$i]->lengthInCm;

      $boatObject = new \Model\Boat($id, $type, $lengthInCm);
      array_push($ret, $boatObject);
    }
    return $ret;
  }

  private function saveToDatabase(): void
  {
    $membersJSON = array();

    for ($i = 0; $i < sizeof($this->members); $i++) {
      $boats = $this->members[$i]->getBoats();

      $phpObj = new \stdClass();
      $phpObj->id = $this->members[$i]->getID();
      $phpObj->name = $this->members[$i]->getName();
      $phpObj->pn = $this->members[$i]->getPersonalNumber();
      $phpObj->boats = array();

      for ($j = 0; $j < sizeof($boats); $j++) {
        $phpObjBoat = new \stdClass();

        $phpObjBoat->type = $boats[$j]->getType();
        $phpObjBoat->lengthInCm = $boats[$j]->getLength();
        $phpObjBoat->id = $boats[$j]->getID();

        array_push($phpObj->boats, $phpObjBoat);
      }

      array_push($membersJSON, $phpObj);
    }

    $membersJSON = json_encode($membersJSON);

    file_put_contents($this->path, $membersJSON);
  }

  public function addMember(\Model\Member $newMember): void
  {
    array_push($this->members, $newMember);
  }

  public function updateMemberInfo(\Model\Member $updatedMemberInfo): void
  {
    $id = $updatedMemberInfo->getID();
    $name = $updatedMemberInfo->getName();
    $personalNumber = $updatedMemberInfo->getPersonalNumber();

    $member = $this->findMemberByID($id);

    $member->setName($name);
    $member->setPersonalNumber($personalNumber);

    $this->saveToDatabase();
  }

  public function updateBoatInfo(\Model\Boat $updatedBoatInfo): void
  {
    $id = $updatedBoatInfo->getID();
    $type = $updatedBoatInfo->getType();
    $length = $updatedBoatInfo->getLength();

    $memberID = $memberID = (int) substr($id, 0, 1);
    $boat = $this->findBoatByID($memberID, $id);

    $boat->updateType($type);
    $boat->updateLength($length);

    $this->saveToDatabase();
  }

  public function findMemberByID(int $ID): \Model\Member
  {
    foreach ($this->members as $member) {
      if ($member->getID() == $ID) {
        return $member;
      }
    }
  }

  public function findBoatByID(int $memberID, string $boatID): \Model\Boat
  {
    $boatOwner = $this->findMemberByID($memberID);

    $boat = $boatOwner->findBoatByID($boatID);

    return $boat;
  }

  public function removeMember(int $ID): void
  {
    $memberToRemove = $this->findMemberByID($ID);
    array_splice($this->members, $memberToRemove);
  }
}
