<?php

namespace model;

use Random\RandomException;

require_once "../model/Room.php";

class BossRoom extends Room
{
    private int $bossStrength;


    private int $points;


    public function __construct(RoomRarity $type, int $id)
    {
        parent::__construct($type, $id);
        switch ($this->getRoomType()) {
            case RoomRarity::DEFAULT:
                $this->bossStrength = 100;
                $this->points = 100;
                break;
            case RoomRarity::RARE:
                $this->bossStrength = 150;
                $this->points = 200;
                break;
            case RoomRarity::MYTHICAL:
                $this->bossStrength = 200;
                $this->points = 300;
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

    public function getBossStrength(): int
    {
        return $this->bossStrength;
    }

    public function setBossStrength(int $bossStrength): void
    {
        $this->bossStrength = $bossStrength;
    }

    public function addStrength(int $strengthCount): void
    {

        $this->setBossStrength($this->getBossStrength() + $strengthCount);
    }


    public function fight(): int
    {
        $fightCount = 1;
        try {
            $rand = random_int(0, 300);
            while ($rand <= $this->getBossStrength()) {
                $fightCount++;
                $rand = random_int(0, 300);
                $this->addStrength(-50);

            }
        } catch (RandomException $e) {
            echo $e->getMessage();
        }

        return $fightCount;
    }

    public function action(): int
    {
        if ($this->isVisited()) {

            return 0;
        }

        $count = $this->fight();
        $this->visit();
        echo "you trying to beat this monster {$count} times\n";

        return $this->getPoints();
    }
}