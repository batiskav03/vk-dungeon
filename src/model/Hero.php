<?php

namespace model;

class Hero
{
    private string $name;
    private int $points;


    private int $roomCount;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->points = 0;
        $this->roomCount = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function addPoints(int $points): void
    {
        if ($this->points + $points < 0) {
            $this->points = 0;

            return;
        }

        $this->points += $points;
    }

    public function clearRoom(Room $room) : void {
        if ($this->checkAndUpdateRoomCount($room)) {
            $getPoints = $room->action();
            $room->visit();
            $this->addPoints($getPoints);
            echo "I get {$getPoints} points for this room... ";
            return;
        }

        echo "I already has been in this room... \n";
    }

    public function revealWay(Room $room) : void {
        echo "i can go ";
        $doors = $room->getAvailableDoors();
        if ($doors[0] != null)
            echo "left... ";
        if ($doors[1] != null)
            echo "bottom... ";
        if ($doors[2] != null)
            echo "top... ";
        if ($doors[3] != null)
            echo "right... ";
        echo "\n";

    }

    public function goNextDoorByWay(Room $room, string $way) : Room {
        $door = 0;
        switch ($way) {
            case "left":
                $door = 0;
                break;
            case "bottom":
                $door = 1;
                break;
            case "top":
                $door = 2;
                break;
            case "right":
                $door = 3;
                break;
        }
        return $this->goNextDoor($room, $door);
    }

    public function goNextDoor(Room $room, int $door) : Room {
        $checkRoom = $room->getAvailableDoors()[$door];
        if ($checkRoom != null) {
            return $checkRoom;
        }

        echo "there is no way... \n";

        return $room;

    }

    public function checkAndUpdateRoomCount(Room $room) : bool {
        if (!$room->isVisited()) {
            $this->roomCount++;

            return true;
        }


        return false;
    }
}