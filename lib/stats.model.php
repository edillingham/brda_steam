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

class AuthToken {
	public $uuid;
	public $timestamp;
	public $ttl;
}

$dbh = new PDO('sqlite:stats.db');

function getAllPlayers($db) {
	// TODO: allow order to be specified dynamically
	$result = $db->query('SELECT * FROM player ORDER BY LOWER(username)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

// special case: PHP doesn't correctly json_encode the string vs. integer values id vs. numPlayers, so
// let's skip that classmap bullshit and build our objects from scratch so we have full control over typing
function getAllGames($db) {
	$result = $db->query('SELECT g.*, c.numPlayers FROM game g INNER JOIN (SELECT game_id, COUNT(*) as numPlayers FROM stats GROUP BY game_id) c ON c.game_id = g.id ORDER BY LOWER(name)');

	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		// fuck you, php
		$obj = new StdClass;
		$obj->id = $row['id'];
		$obj->name = $row['name'];
		$obj->numPlayers = (int)$row['numPlayers'];
		
		$output[] = $obj;
	}
	
	return $output;
}

function getPlayer($db, $playerId) {
	$result = $db->query('SELECT * FROM player WHERE id = '.$playerId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

function getGame($db, $gameId) {
	$result = $db->query('SELECT *, 0 as numPlayers FROM game WHERE id = '.$gameId);
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}

function getGamesByPlayer($db, $playerId) {
	$result = $db->query('SELECT g.*, COUNT(*) as numPlayers FROM game g INNER JOIN stats s ON s.game_id = g.id WHERE g.id IN (SELECT game_id FROM stats WHERE user_id = "'.$playerId . '") GROUP BY g.id ORDER BY LOWER(name)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'GameData');
}

function getPlayersByGame($db, $gameId) {
	$result = $db->query('SELECT * FROM player WHERE id IN (SELECT user_id FROM stats WHERE game_id = "'.$gameId . '") ORDER BY LOWER(username)');
	return $result->fetchAll(PDO::FETCH_CLASS, 'PlayerStats');
}

function getAuthToken($db,$ttl){	
	$token = uniqid('BRDA_',true);
	$db->exec('INSERT INTO authtokens (uuid,timestamp,ttl) VALUES (\'' . $token . '\',' . time() . ',' . $ttl . ')'); 
	//print_r($db->errorInfo());
	return $token;
}

function validateAuthToken($db,$token){
	$result = $db->query('SELECT * FROM authtokens WHERE uuid = "' . $token . '"');
	$authTokens = $result->fetchAll(PDO::FETCH_CLASS, 'AuthToken');
	if(count($authTokens) != 1) return "error!"; // null set => error, possibly a csrf attempt or re-submitted form
	$authToken = $authTokens[0];
	$currentTime = time();
	if($currentTime > ($authToken->timestamp + ($authToken->ttl / 1000) )) return "timeout"; // Timeout, if current time is greater than token's insertion time + the TTL
	$db->query('DELETE FROM authtokens WHERE uuid = "' . $authToken->uuid . '"');
	return $authToken;
}
?>
