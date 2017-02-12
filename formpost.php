<?php
	// list($video_id, $video_title) = explode("&", $_GET['q']);
	$queries = explode("&", $_GET['q']);
	print $queries[0];
	$str = urldecode($video_title);
	print "the vid id is $video_id, the title is $str";
	print "yehh";
	//add db

?>