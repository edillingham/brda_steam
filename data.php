<?php
class PlayerStats {
	public $id;
	public $username;
}

class GameData {
	public $id;
	public $name;
}

$dbh = new PDO('sqlite:stats.db');

switch($_GET['op']) {
	case 'getPlayer':
		echo json_encode(getPlayer($dbh, $_GET['id']));
		break;
		
	case 'getAllPlayers':
		echo json_encode(getAllPlayers($dbh));
		break;
		
	case 'getAllGames':
		echo json_encode(getAllGames($dbh));
		break;
		
	default:
		echo json_encode('error!');
		break;
}

function getAllPlayers($db) {
	// TODO: allow order to be specified dynamically
	$result = $db->query('SELECT * FROM player ORDER BY LOWER(username)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

function getAllGames($db) {
	// TODO: allow order to be specified dynamically
	$result = $db->query('SELECT * FROM game ORDER BY LOWER(name)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}

function getPlayer($db, $playerId) {
	$result = $db->query('SELECT * FROM player WHERE id = '.$playerId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

function getGame($db, $gameId) {
	$result = $db->query('SELECT * FROM game WHERE id = '.gameId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}
?>