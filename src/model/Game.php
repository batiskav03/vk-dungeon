<?php

namespace model;
use SplQueue;

require_once "Hero.php";
class Game
{
    private ?Room $currentRoom;
    private bool $isStarted;
    private ?Hero $hero;
    private string $ShortestPath;
    private const FILENAME = "../resources/results";



    public function __construct()
    {
        $this->currentRoom = null;
        $this->hero = null;
        $this->isStarted = false;
    }

    public function getCurrentRoom(): ?Room
    {
        return $this->currentRoom;
    }

    public function setCurrentRoom(Room $currentRoom): void
    {
        $this->currentRoom = $currentRoom;
    }

    public function getHero() : ?Hero
    {
        return $this->hero;
    }

    public function setHero(Hero $hero): void
    {
        $this->hero = $hero;
    }

    public function getShortestPath(): string
    {
        return $this->ShortestPath;
    }

    public function setShortestPath(string $ShortestPath): void
    {
        $this->ShortestPath = $ShortestPath;
    }

    public function createHero(string $name) : void {
        $this->setHero(new Hero($name));
    }

    public function getHeroPoints() : int {
        return $this->hero->getPoints();
    }


    public function loadDungeon($inputString) : void {
        $this->setCurrentRoom($this->converter($inputString));
    }

    function checkGameStart() : bool {
        return $this->isStarted;
    }

    function checkHero() : bool {
        return is_null($this->getHero());
    }

    public function startGame() : void {
        if ($this->checkGameStart()) {
            echo "game already started\n";

            return;
        }
        if ($this->checkHero()) {
            echo "please, create hero before start";

            return;
        }
        if (is_null($this->getCurrentRoom())) {
            echo "please, load dungeon before playing game \n";

            return;
        }
        $this->isStarted = true;
        $this->hero->clearRoom($this->currentRoom);
    }

    public function getPossibleWays() : void {
        $this->getHero()->revealWay($this->getCurrentRoom());
    }

    public function goNextDoor(string $way) : void {
        $this->currentRoom = $this->getHero()->goNextDoorByWay($this->getCurrentRoom(), $way);
        $this->hero->clearRoom($this->currentRoom);
        if ($this->getCurrentRoom()->isEnd()) {
            echo "game is over, your total points {$this->getHeroPoints()} \n";
            file_put_contents(self::FILENAME,
                "{$this->getHero()->getName()}: {$this->getHeroPoints()}\n",
                FILE_APPEND);
            session_destroy();
        }
    }

    public function goRight() : void {
        if (!$this->isStarted) {
            echo "game not yet started \n";

            return;
        }
        $this->goNextDoor("right");
    }

    public function goLeft() : void {
        if (!$this->isStarted) {
            echo "game not yet started \n";

            return;
        }
        $this->goNextDoor("left");
    }

    public function goTop() : void {
        if (!$this->isStarted) {
            echo "game not yet started \n";

            return;
        }
        $this->goNextDoor("top");
    }

    public function goBottom() : void {
        if (!$this->isStarted) {
            echo "game not yet started \n";

            return;
        }
        $this->goNextDoor("bottom");
    }




    private function converter($inputString) : Room
    {
        $jsonString = json_decode($inputString, true);
        $map = [];
        $startRoom = null;
        foreach ($jsonString as $key => $value) {
            if (str_starts_with($key, "room")) {
                $id = $value["id"];
                $roomRarity = $value["roomRarity"];
                $roomType = $value["roomType"];
                $roomInit = null;
                if ($roomType == "empty") {
                    $roomInit = new EmptyRoom(RoomRarity::stringConvert($roomRarity), $id);
                } else if ($roomType == "boss") {
                    $roomInit = new BossRoom(RoomRarity::stringConvert($roomRarity), $id);
                }  else if ($roomType == "chest") {
                    $roomInit = new ChestRoom(RoomRarity::stringConvert($roomRarity), $id);
                }
                $roomInit->setIsEnd($value["exit_room"]);


                if (!is_null($roomInit)) {
                    $map[$id] = $roomInit;
                } else {
                    throw new \http\Exception\RuntimeException("{$roomType} type of room does not exist, only boss, empty and chest");
                }

                if ($value["start_room"]) {
                    $startRoom = $roomInit;
                }


            } else if (str_starts_with($key, "map")) {
                foreach ($value as $mapKey => $room) {
                    $roomId = $room["id"];
                    $availableDoorsId = [$room["left_door"], $room["bot_door"], $room["top_door"], $room["right_door"]];
                    $availableDoors = [];
                    for ($i  = 0; $i < count($availableDoorsId); $i++) {
                        if ($availableDoorsId[$i] == -1) {
                            $availableDoors[$i] = null;
                            continue;
                        }
                        $door = $map[$availableDoorsId[$i]];
                        if (in_array($door, $availableDoors)) {
                            throw new \http\Exception\RuntimeException("can't be two same doors in one room");
                        }
                        $availableDoors[$i] = $door;
                    }
                    $targetRoom = $map[$roomId];
                    $targetRoom->setAvailableDoors($availableDoors);
                }

            }
        }
        echo "dungeon successfully loaded \n";

        return $startRoom;
    }
    function shortestPath() : ?string {
        $start = $this->currentRoom;
        $queue = new SplQueue();
        $queue->enqueue([$start]);
        while (!$queue->isEmpty()) {
            $path = $queue->dequeue();
            $node = end($path);
            if (isset($visited[$node->getId()])) {
                continue;
            }
            $visited[$node->getId()] = true;
            if ($node->isEnd()) {
                $result = "";
                for ($i = 0; $i < count($path); $i++) {
                    if ($i != count($path) - 1) {
                        $result .= "{$path[$i]->getId()} -> ";
                    } else {
                        $result .= "{$path[$i]->getId()}. \n";
                    }
                }
                return $result;
            }
            foreach ($node->getAvailableDoors() as $neighbor) {
                if (!is_null($neighbor)) {
                    $newPath = $path;
                    $newPath[] = $neighbor;
                    $queue->enqueue($newPath);
                }
            }

        }
        echo "loaded dungeon isn't correct \n";

        return null;
    }


}