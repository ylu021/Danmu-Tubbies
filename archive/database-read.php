<?php
	include 'db-info.php';

	try {
		// print "No error!";
		$db = new PDO($dsn);
		$query = "SELECT * from user WHERE id=?";
		// echo $_GET['email'];
		$stmt = $db->prepare($query);
		$stmt->execute(array(urldecode($_GET['email'])));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

	}catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	// echo urldecode($_GET['email']) . "&" . $_GET['q'];

	// 3. Use returned data (if any)

	// print_r($rows);
	if(!$rows) {
		die('nothing found');
	}

	$db = null;
?>
