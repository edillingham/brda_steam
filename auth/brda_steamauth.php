<?php
	require_once("openid.php");
	require_once("brda_steamauth.config.php");

	try{
		$openID = new LightOpenID($config["LOCAL_DOMAIN"]);
		// Establish the provider and redirect to Steam's auth page
 		if(!$openID->mode){
			$openID->identity = $config["STEAM_PROVIDER_URL"];
			header('Location: '  .$openID->authUrl());
		}
		// If the user cancels, we're done here
		elseif($openID->mode == 'cancel'){
			echo "Authenticaton Cancelled";
		}
		/* If the authentication is successful, the 'identity' property of $openID will have the steam
		 * user ID url, eg,
		 * 	http://steamcommunity.com/openid/id/<NUMERIC_USER_ID>
		 *
		 * Otherwise it will fail with the message "Could not be authenticated"
		 */
		else{
			echo ($openID->validate() ? $openID->identity : "Could not be authenticated");
		}
	}catch(ErrorException $e){
		echo $e->getMessage();
	}
?>
