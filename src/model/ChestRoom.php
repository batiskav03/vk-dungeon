<?php

namespace model;

require_once "../model/Room.php";
class ChestRoom extends Room
{
    private int $points;

    public function __construct(RoomRarity $type, int $id)
    {
        parent::__construct($type, $id);
        switch ($this->getRoomType()) {
            case RoomRarity::DEFAULT:
                $this->points = 50;
                break;
            case RoomRarity::RARE:
                $this->points = 80;
                break;
            case RoomRarity::MYTHICAL:
                $this->points = 150;
                break;
        }
    }


    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function action(): int
    {
        if ($this->isVisited()) {

            return 0;
        }
        $this->visit();
        echo "finally find chest...free points";


        return $this->getPoints();
    }
}