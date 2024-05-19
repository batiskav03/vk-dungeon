## ```input file format:``` 
```` ebnf
    {
        room<id> : {
            <id> : <num>,
            <roomType>: <roomType>,
            <roomRarity>: <roomRarity>,
            <exit_room>: <bool>,
            <start_room>: <bool>
        }
        map : {
            {
                <id> : <num>,
                <left_door>: <num>,
                <right_door>: <num>,
                <top_door>: <num>,
                <bot_door>: <num>
            }
        }
    }
    
    <id> - индефекатор комнаты,
    <roomType> - тип комнаты,
    <roomRarity> - редкость,
    <exit_room> - является ли комната выходом,
    <start_room> - является ли комната первой
    
    <*_door> - в какую комната ведет дверь, null - если пути нет.
````
## ```example:``` 

```` ebnf
{
  "room1": {
    "id": 1,
    "roomType": "boss",
    "roomRarity": "RARE",
    "exit_room": false,
    "start_room": true
  },
  "room2": {
    "id": 2,
    "roomType": "boss",
    "roomRarity": "DEFAULT",
    "exit_room": false,
    "start_room": false
  },
  "room3": {
    "id": 3,
    "roomType": "boss",
    "roomRarity": "DEFAULT",
    "exit_room": false,
    "start_room": false
  },
  "room4": {
    "id": 4,
    "roomType": "empty",
    "roomRarity": "DEFAULT",
    "exit_room": true,
    "start_room": false
  },
  "map": [
    {
      "id": 1,
      "left_door": -1,
      "right_door": 2,
      "top_door": -1,
      "bot_door": -1
    },
    {
      "id": 2,
      "left_door": 1,
      "right_door": 4,
      "top_door": 3,
      "bot_door": -1
    },
    {
      "id": 3,
      "left_door": -1,
      "right_door": -1,
      "top_door": -1,
      "bot_door": 2
    },
    {
      "id": 4,
      "left_door": 2,
      "right_door": -1,
      "top_door": -1,
      "bot_door": -1
    }
  ]
}
````