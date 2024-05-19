<?php

namespace model;
require_once "../model/Room.php";
class EmptyRoom extends Room
{

    public function action(): int
    {
        if (!$this->isVisited()) {

            return 0;
        }
        echo 'room is empty...';
        $this->visit();

        return 0;
        // TODO: Implement action() method.
    }
}