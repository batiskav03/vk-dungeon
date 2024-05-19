<?php

namespace model;

enum RoomRarity
{
    case DEFAULT;
    case RARE;
    case MYTHICAL;

    public static function stringConvert(string $str) : RoomRarity {
        if ($str == "DEFAULT") return RoomRarity::DEFAULT;
        else if ($str == "RARE") return RoomRarity::RARE;
        return RoomRarity::MYTHICAL;
    }
}