<?php
class PlayerStats {
	public $id;
	public $username;
}

class GameData {
	public $id;
	public $name;
	public $numPlayers;
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
		
	case 'getGamesByPlayer':
		echo json_encode(getGamesByPlayer($dbh, $_GET['id']));
		break;
		
	case 'getPlayersByGame':
		echo json_encode(getPlayersByGame($dbh, $_GET['id']));
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
	$result = $db->query('SELECT g.*, c.numPlayers FROM game g INNER JOIN (SELECT game_id, COUNT(*) as numPlayers FROM stats GROUP BY game_id) c ON c.game_id = g.id ORDER BY LOWER(name)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}

function getPlayer($db, $playerId) {
	$result = $db->query('SELECT * FROM player WHERE id = '.$playerId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

function getGame($db, $gameId) {
	$result = $db->query('SELECT * FROM game WHERE id = '.$gameId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}

function getGamesByPlayer($db, $playerId) {
	$result = $db->query('SELECT * FROM game WHERE id IN (SELECT game_id FROM stats WHERE user_id = "'.$playerId . '") ORDER BY LOWER(name)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}

function getPlayersByGame($db, $gameId) {
	$result = $db->query('SELECT * FROM player WHERE id IN (SELECT user_id FROM stats WHERE game_id = "'.$gameId . '") ORDER BY LOWER(username)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}
?>