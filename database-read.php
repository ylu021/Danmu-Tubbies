<?php
	include 'db-info.php';

	try {
		$dsn = "mysql:host=$dbhost;dbname=$dbname";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$db = new PDO($dsn, $dbuser, $dbpass, $opt);
		// print "No error!";
		$query = "SELECT * from user WHERE id=?";
		echo $_GET['email'];
		$stmt = $db->prepare($query);
		$stmt->execute(array(urldecode($_GET['email'])));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

	}catch(PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
	// echo urldecode($_GET['email']) . "&" . $_GET['q'];

?>

<!doctype html>
<html>
<head>
	<title>Phonebook</title>
</head>
<body>

	<h1>Phonebook</h1>

	<table border>
		<tr>
		<th>Id</th>
		<th>vid</th>
		</tr>
<?php
	// 3. Use returned data (if any)

	print_r($rows);
	if(!$rows) {
		die('nothing found');
	}
?>

		<tr>
			<td><?php echo $rows['id']; ?></td>
			<td><?php echo $rows['video_id']; ?></td>
		</tr>

	</table>

	<br>
	<a href=".">Back to the Index</a>

</body>
</html>

<?php
	//close database
	$db = null;
?>
