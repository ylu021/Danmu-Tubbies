<?php
  ob_start();
  require_once 'db-info.php';

	try {
		$db = new PDO($dsn);
		print "No error!";
		$data = array(
				':sid' => urldecode($_POST['email']),
				':sname' => urldecode($_POST['name'])
		);
		$query = "SELECT 1 from Tubbies_User WHERE :sid=id AND :sname=name";
		$stmt = $db->prepare($query);
		$stmt->execute($data);
		$count = $stmt->rowCount();
		echo "How many $count";
		if($count==0){
			echo "emptyz,";
			$query = "INSERT INTO Tubbies_User VALUES(:sid, :sname);";
			$stmt = $db->prepare($query);
			$result = $stmt->execute($data);
			if($result){
				echo 'successfully inserted';
				header('Location: ' . '/');
			}else{
				echo $result;
			}
		}else{
			echo 'already exist';
			header('Location: ' . '/');
		}
		// exit('<a href="' . $newURL . '">This is your first time using our system, we have created an account base on your google profile, now redirecting you to the site </a>');
			
		
		
		
	}catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

?>
