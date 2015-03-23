<?php
class PlayerStats {
	public $id;
	public $username;
}

$dbh = new PDO('sqlite:stats.db');

switch($_GET['op']) {
	case 'getPlayer':
		echo json_encode(getPlayer($dbh, $_GET['id']));
		break;
		
	default:
		echo json_encode('error!');
		break;
}

function getAllPlayers($db) {
	$result = $db->query('SELECT * FROM player');
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

function getPlayer($db, $playerId) {
	$result = $db->query('SELECT * FROM player WHERE id = '.$playerId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}
?>