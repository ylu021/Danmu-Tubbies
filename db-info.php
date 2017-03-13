<?php
	//$url = parse_url(getenv("DATABASE_URL"));
	//$dbport = 
	//$dbhost = $url["host"];
	//$dbuser = $url["user"];
	//$dbpass = $url["pass"];
	//$dbname = substr($url["path"], 1);
	$dsn = "pgsql:"
	. "host=ec2-54-204-32-145.compute-1.amazonaws.com;"
	. "dbname=dfto47bc53vjl4;"
	. "user=uerabqodddbfaw;"
	. "port=5432;"
	. "sslmode=require;"
	. "password=8db9224be2aef8dee159bdddd686b9a25630148636a779764de5be7f4e60738a";

?>
