<?php

header("Content-type: application/json");

if (!isset($_GET['action']) || $_GET['action'] == "") {
    $output['meta']['status'] = 400; //Action parameter is required and may not be empty (Bad request)
    $output['meta']['error'] = "Missing page parameter!";
} else {
    $output['meta']['status'] = 200;

    switch ($_GET['action']) {
        case "uuid":
            //do mojang shit
            if (!isset($_GET['username']) || $_GET['username'] == "") {
                $output['meta']['status'] = 400; //username parameter is required and may not be empty (Bad request)
                $output['meta']['error'] = "No username given";
            } else {
                $mojangraw = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $_GET['username']);
                $mojang = json_decode($mojangraw, true);
                $uuid = $mojang['id'];

                if ($uuid == null) {
                    $output['meta']['status'] = 404; //user not in mojangs system (Not found)
                    $output['meta']['error'] = "User doesn't exist";
                } else {
                    $output['data']['id'] = $uuid;
                    $newuuid = substr_replace($uuid, "-", 8, 0);
                    $newuuid = substr_replace($newuuid, "-", 13, 0);
                    $newuuid = substr_replace($newuuid, "-", 18, 0);
                    $newuuid = substr_replace($newuuid, "-", 23, 0);
                    $output['data']['uuid'] = $newuuid;
                }
            }
            break;
        case "player":
            //do playa shit
            if (!isset($_GET['uuid']) || $_GET['uuid'] == "") {
                $output['meta']['status'] = 400; //uuid parameter is required and may not be empty (Bad request)
                $output['meta']['error'] = "No UUID given";
            } else {
                require_once 'db.php';

                if ($db == "error") {
                    die("nope");
                }
                $uuid = $_GET['uuid'];

                $query = "SELECT players.id AS player_id,username,COUNT(kills.id) AS killcount,(SELECT COUNT(kills.id) FROM kills WHERE loser_id = '" . $uuid . "') AS deathcount FROM players JOIN kills ON players.UUID = kills.winner_id WHERE players.UUID = '" . $uuid . "' LIMIT 30";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));

                while ($row = mysqli_fetch_assoc($result)) {
                    $output['data']['id'] = $row['player_id'];
                    $output['data']['user'] = $row['username'];
                    $output['data']['killcount'] = $row['killcount'];
                    //$output['data']['most_kills'] = $row['most_kills'];
                    $output['data']['deathcount'] = $row['deathcount'];
                    //$output['data']['most_deaths'] = $row['most_deaths'];
                }

                $query = "SELECT username AS most_kills,COUNT(username) AS occurrence FROM kills JOIN players ON loser_id = players.uuid WHERE winner_id = '" . $uuid . "' GROUP BY loser_id ORDER BY occurrence DESC LIMIT 1";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                while ($row = mysqli_fetch_assoc($result)) {
                    $output['data']['most_kills'] = $row['most_kills'];
                    $output['data']['most_kills_count'] = $row['occurrence'];
                }
                $query = "SELECT username AS most_deaths,COUNT(username) AS occurrence FROM kills JOIN players ON winner_id = players.uuid WHERE loser_id = '" . $uuid . "' GROUP BY winner_id ORDER BY occurrence DESC LIMIT 1";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                while ($row = mysqli_fetch_assoc($result)) {
                    $output['data']['most_deaths'] = $row['most_deaths'];
                    $output['data']['most_deaths_count'] = $row['occurrence'];
                }

                if (!isset($_GET['page']) || $_GET['page'] == "" || !is_numeric($_GET['page']) || $_GET['page'] < 2) {
                    $page = "";
                } else {
                    $page = (($_GET['page'] - 1) * 25) . ", ";
                }

                $query = "SELECT kills.id,kills.datetime,match_id,gamemode,weapon,winner_health,(SELECT username FROM players WHERE UUID = kills.winner_id) AS winner,(SELECT username FROM players WHERE UUID = kills.loser_id) AS loser FROM kills JOIN matches on match_id = matches.id WHERE kills.winner_id = '" . $uuid . "' OR loser_id = '" . $uuid . "' LIMIT " . $page . "25";
                $result = mysqli_query($db, $query) or die(mysqli_error($db));

                $i = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $output['data']['kills'][$i]['id'] = $row['id'];
                    $output['data']['kills'][$i]['datetime'] = $row['datetime'];
                    $output['data']['kills'][$i]['match_id'] = $row['match_id'];
                    $output['data']['kills'][$i]['gamemode'] = $row['gamemode'];
                    $output['data']['kills'][$i]['winner'] = $row['winner'];
                    $output['data']['kills'][$i]['loser'] = $row['loser'];
                    $output['data']['kills'][$i]['weapon'] = $row['weapon'];
                    $output['data']['kills'][$i]['winner_health'] = $row['winner_health'];
                    $i++;
                }

                if ($output['data']['id'] == null) {
                    $output['meta']['status'] = 404; //couldn't find a player (Not found)
                    $output['meta']['error'] = "Player not found";
                    $output['data'] = [];
                }
            }
            break;
        case "top":
            //do top kek shit
            break;
        case "log":
            //view shit log
            break;
        case "match":
            //view match shit
            break;
        default:
            //dindu nuffin
            $output['meta']['status'] = 405; //didn't match anything (Method not allowed)
            $output['meta']['error'] = "Page not recognized / not found";
            break;
    }
}


$json = json_encode($output);
echo $json;
exit;