<?php
	$url = parse_url(getenv("DATABASE_URL"));

	$dbhost = $url["host"];
	$dbuser = $url["user"];
	$dbpass = $url["pass"];
	$dbname = substr$($url["path"], 1);

?>
