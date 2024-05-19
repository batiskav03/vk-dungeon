<?php

require_once "../model/BossRoom.php";
require_once "../model/EmptyRoom.php";
require_once "../model/RoomRarity.php";
require_once "../model/Room.php";
require_once "../model/Game.php";

use model\Game;


const PREFIX_URI = "/vk-dungeon/src/public/index.php";


function route($requestURI, Game $game): void
{

    $requestURI = parse_url($requestURI, PHP_URL_PATH);
    switch ($requestURI) {
        case PREFIX_URI . "/createHero":
            $name = $_GET["name"];
            $game->createHero($name);
            echo "Hero '{$name}' created";
            break;
        case PREFIX_URI . "/load":
            $jsonString = file_get_contents('php://input');
            $game->loadDungeon($jsonString);
            $shortestPath = $game->shortestPath();
            if (is_null($shortestPath)) {
                $_SESSION['game'] = new Game();
            } else {
                $game->setShortestPath($shortestPath);
            }
            break;
        case PREFIX_URI . "/shortestPath":
            echo $game->getShortestPath();
            break;
        case PREFIX_URI . "/start":
            $game->startGame();
            break;
        case PREFIX_URI . "/points":
            echo $game->getHeroPoints();
            break;
        case PREFIX_URI . "/way/left":
            $game->goLeft();
            break;
        case PREFIX_URI . "/way/right":
            $game->goRight();
            break;
        case PREFIX_URI . "/roomId":
            var_dump($game->getCurrentRoom()->getId());
            break;
        case PREFIX_URI . "/way/top":
            $game->goTop();
            break;
        case PREFIX_URI . "/way/bottom":
            $game->goBottom();
            break;
        case PREFIX_URI . "/way":
            $game->getPossibleWays();
            break;
        default:
            echo "404 error page";
            break;
    }
}

function main(): void
{
    session_start();
    if (!isset($_SESSION['game'])) {
        $_SESSION['game'] = new Game();
    }
    $game = $_SESSION['game'];
    $requestURI = $_SERVER["REQUEST_URI"];
    route($requestURI, $game);

}


main();

