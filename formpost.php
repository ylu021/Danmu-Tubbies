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
		if($count==0){
			// echo "emptyz";
			$query = "INSERT INTO user(id, video_id) VALUES(?, ?)";
			$stmt = $db->prepare($query);
			if($stmt->execute(array(urldecode($_GET['email']), $_GET['q']))) {
				$db = null;
				$newURL = "./test.php?q=" . $_GET['q'] . "&email=" . urlencode($_GET['email']);
				// echo $newURL;
				header('Location: ' . $newURL);
		// exit('<a href="' . $newURL . '">This is your first time using our system, we have created an account base on your google profile, now redirecting you to the site </a>');
			}else {
				echo 'failed inserting';
			}
			
		}else{
			$db = null;
			$newURL = "./test.php?q=" . $_GET['q'] . "&email=" . urlencode($_GET['email']);
			// echo $newURL;
			header('Location: ' . $newURL);
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
