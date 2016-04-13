<?php

require_once("lib/stats.model.php");

header('Content-Type: application/json');

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

	case 'getRequestID':
		echo json_encode(getAuthToken($dbh, $appConfig['TOKEN_TIMEOUT_MS']));
		break;		

	case 'validateRequestID':
		if(isset($_GET['requestID'])){
			$requestID = SQLite3::escapeString($_GET['requestID']);
			echo json_encode(validateAuthToken($dbh, $requestID));
		}
		else{
			echo json_encode('error!');
		}
		break;
	default: break;
}
?>
