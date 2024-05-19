<?php

namespace model;
require_once "IAction.php";
abstract class Room implements IAction
{
    private bool $isVisited;
    private int $id;

    // $availableDoors = [left_door, bot_door, top_door, right_door] like vim hjkl
    private array $availableDoors;
    private bool $isEnd;

    private RoomRarity $roomType;

    public function __construct(RoomRarity $type, int $id)
    {
        $this->id = $id;
        $this->isVisited = false;
        $this->isEnd = false;
        $this->roomType = $type;
    }

    public function isVisited(): bool
    {
        return $this->isVisited;
    }

    public function visit() : void
    {
        $this->isVisited = true;
    }

    public function getAvailableDoors(): array
    {
        return $this->availableDoors;
    }

    public function setAvailableDoors(array $availableDoors): void
    {
        $this->availableDoors = $availableDoors;
    }

    public function getRoomType(): RoomRarity
    {
        return $this->roomType;
    }

    public function setRoomType(RoomRarity $roomType): void
    {
        $this->roomType = $roomType;
    }

    public function isEnd(): bool
    {
        return $this->isEnd;
    }

    public function setIsEnd(bool $isEnd): void
    {
        $this->isEnd = $isEnd;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}