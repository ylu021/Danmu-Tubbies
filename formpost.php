<?php
  ob_start();
	include 'db-info.php';

	try {
		$db = new PDO($dsn);
		print "No error!";
		$query = "SELECT * from user WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->execute(array($_GET['email']));
		$count = $stmt->rowCount();
		echo "How many $count";
		if($rows = $stmt->fetch()){
			echo "";
		}else{
			echo "emptyz";
			$query = "INSERT INTO user(id, video_id) VALUES(?, ?)";
			$stmt = $db->prepare($query);
			$stmt->execute(array(urldecode($_GET['email']), $_GET['q']));
		}
		
		$db = null;
		echo 'here';
		$newURL = "./test.php?q=" . $_GET['q'] . "&email=" . urlencode($_GET['email']);
		echo $newURL;
		header('Location: ' . $newURL);
		exit('<a href="' . $newURL . '">Redirecting you to site </a>');
	}catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

?>
