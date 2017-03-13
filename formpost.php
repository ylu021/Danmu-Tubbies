<?php
  ob_start();
	include 'db-info.php';

	try {
		$db = new PDO($dsn);
		print "No error!";
		$query = 'SELECT * from Tubbies_User WHERE id=?';
		$stmt = $db->prepare($query);
		$stmt->execute(array($_POST['email']));
		$count = $stmt->rowCount();
		echo "How many $count";
		if($count==0){
			echo "emptyz, " . 
			$email = urldecode($_POST['email']);
			$name = urldecode($_POST['name']);
			$query = 'INSERT INTO Tubbies_User(id, name) VALUES(?, ?)';
			$stmt = $db->prepare($query);
			if($stmt->execute(array($email, $name))) {
				echo 'successfully inserted';
				$db = null;
				// echo $newURL;
				header('Location: ' . '/');
		// exit('<a href="' . $newURL . '">This is your first time using our system, we have created an account base on your google profile, now redirecting you to the site </a>');
			}else {
				echo 'failed inserting';
			}
			
		}else {
			
		}
		
		
	}catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

?>
