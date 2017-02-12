<?php
  ob_start();
	include 'db-info.php';

	try {
		$dsn = "mysql:host=$dbhost;dbname=$dbname";
		$opt = [
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	    PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$db = new PDO($dsn, $dbuser, $dbpass, $opt);
		print "No error!";
		$query = "SELECT COUNT(*) from user WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->execute(array($_GET['email']));
		$rows = $stmt->fetchAll();
		// echo $rows['id'];
		echo count($rows);
		if(count($rows) == 0) {
			echo "im  hre";
			$query = "INSERT INTO user(id, video_id) VALUES(?, ?)";
			$stmt = $db->prepare($query);
			$stmt->execute(array(urldecode($_GET['email']),$_GET['q']));
		}
		$db = null;
		echo 'here';
		$newURL = "./database-read.php?q=" . $_GET['q'] . "&email=" . urlencode($_GET['email']);
		echo $newURL;
		header('Location: ' . $newURL);
		exit('<a href="' . $newURL . '">Redirecting you to site </a>');
	}catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

?>
