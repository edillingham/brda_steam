Author:  kingatomic <kingatmc@gmail.com>
License: wtfpl

First: Fuck you.

Second: This is pretty simple to use, customize it as you see fit.  There are three files included:
	* openid.php: the OpenID Library
	* brda_steamauth.php: the OpenID consumer that will initiate authentication through Steam
	* brda_steamauth.config.php: configuration parameters for the OpenID consumer

The first step is to update the `brda_steamauth.config.php` file with your server's domain.

Second, include the `brda_steamauth.php` file wherever you want to perform authentication.  It
is configured to automatically redirect to the Steam Community auth page, where it will request
the user logon.  Once the user successfully logins, it will automatically redirect back to the
same URL as it was redirected from (via referrer header, I believe) and echo the Steam User URL, eg, 
	http://steamcommunity.com/openid/id/<NUMERIC_USER_ID>

You can parse the URL to grab the User ID, and compare that against known Steam IDs in the Steam
Group Stats database.  
