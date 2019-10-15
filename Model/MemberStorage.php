<?php

namespace Model;

class MemberStorage
{
  private $members;
  private $jsonFile;
  private $membersJSONArray;
  private $path;


  public function __construct(string $path)
  {
    $this->path = $path;
    $this->jsonFile = file_get_contents($this->path, true);
    $this->membersJSONArray = json_decode($this->jsonFile);
    $this->members = $this->createMembersFromDatabase();
  }


  public function getMembers(): array
  {
    return $this->members;
  }

  public function getMemberIDs(): array
  {
    $members = $this->getMembers();

    $memberIDs = array();
    for ($i = 0; $i < sizeof($members); $i++) {
      array_push($memberIDs, $members[$i]->getID());
    }
    return $memberIDs;
  }

  public function getFirstVacantMemberID(array $memberIDs): int
  {
    for ($i = 1; $i <= sizeof($memberIDs); $i++) {
      if ($memberIDs[$i - 1] != $i) {
        return $i;
      }
    }
    return sizeof($memberIDs) + 1;
  }

  public function saveToDatabase(): void
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

    $this->saveToDatabase();
  }

  public function updateMember(\Model\Member $updatedMember): void
  {
    $id = $updatedMember->getID();
    $name = $updatedMember->getName();
    $personalNumber = $updatedMember->getPersonalNumber();

    $member = $this->findMemberByID($id);

    $member->setName($name);
    $member->setPersonalNumber($personalNumber);

    $this->saveToDatabase();
  }

  public function updateBoat(\Model\Boat $updatedBoat): void
  {
    $id = $updatedBoat->getID();
    $type = $updatedBoat->getType();
    $length = $updatedBoat->getLength();

    $memberID = $memberID = (int) substr($id, 0, 1);
    $boat = $this->findBoatByID($memberID, $id);

    $boat->updateType($type);
    $boat->updateLength($length);

    $this->saveToDatabase();
  }

  public function findMemberByID(int $id): \Model\Member
  {
    foreach ($this->members as $member) {
      if ($member->getID() == $id) {
        return $member;
      }
    }
    throw new Exception("Member not found");
  }

  public function findBoatByID(int $memberID, string $boatID): \Model\Boat
  {
    $boatOwner = $this->findMemberByID($memberID);

    $boat = $boatOwner->findBoatByID($boatID);

    return $boat;
  }

  public function removeMemberByID(int $id): void
  {
    $memberToRemove = $this->findMemberByID($id);

    $key = array_search($memberToRemove, $this->members);
    $removedMember = array_splice($this->members, $key, 1);

    if ($removedMember == null) {
      throw new Exception("Failed to remove");
    }

    $this->saveToDatabase();
  }

  private function createMembersFromDatabase(): array
  {
    $memberObjectArray = array();
    for ($i = 0; $i < sizeof($this->membersJSONArray); $i++) {
      $ID = $this->membersJSONArray[$i]->id;
      $name = $this->membersJSONArray[$i]->name;
      $personalNumber = $this->membersJSONArray[$i]->pn;
      $boats = $this->createBoatsFromMember($this->membersJSONArray[$i]->boats);

      array_push($memberObjectArray, new \Model\Member($ID, $name, $personalNumber, $boats));
    }
    return $memberObjectArray;
  }

  private function createBoatsFromMember(array $boats): array
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
}
