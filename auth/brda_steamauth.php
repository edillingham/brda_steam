<?php
	require_once("openid.php");
	require_once("brda_steamauth.config.php");

	if(empty($_SESSION['steam_openid'])) {
		try {
			$openID = new LightOpenID($sc_config["LOCAL_DOMAIN"]);
			// Establish the provider and redirect to Steam's auth page
			if(!$openID->mode) {
				$openID->identity = $sc_config["STEAM_PROVIDER_URL"];
				header('Location: ' . $openID->authUrl());
			} // If the user cancels, we're done here
			elseif($openID->mode == 'cancel') {
				echo "Authenticaton Cancelled";
			} /* If the authentication is successful, the 'identity' property of $openID will have the steam
		 * user ID url, eg,
		 * 	http://steamcommunity.com/openid/id/<NUMERIC_USER_ID>
		 *
		 * Otherwise it will fail with the message "Could not be authenticated"
		 */
			else {
				$_SESSION['steam_openid'] = ($openID->validate() ? $openID->identity : null);
			}
		} catch(ErrorException $e) {
			echo $e->getMessage();
		}
	}
?>
