<?php
  include 'db-info.php';
  //
  try {
    //$dsn = "mysql:host=$dbhost;dbname=$dbname";
    //$opt = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    //$db = new PDO($dsn, $dbuser, $dbpass, $opt);
    // print "No error!";
    $query = "SELECT COUNT(*) from comment WHERE user_id=?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($_GET['user_id']));
    $rows = $stmt->fetchAll();

		if(count($rows) == 0) {
      echo "i dont have it";
    }else{
      echo "i have it";
      $query = "INSERT INTO comment(comment_id, comment_text, comment_time, video_id, user_id) VALUES(?,?,?,?,?)";
      $stmt = $db->prepare($query);
      $stmt->execute(array(
        uniqid(),
        $_POST['text'],
        $_POST['time'],
        $_POST['video_id'],
        urldecode($_POST['user_id'])
      ));

      print $stmt->errorCode();

    }
    // $query = "INSERT INTO comment(comment_id, comment_text, comment_time, video_id, user_id) VALUES(?, ?, ?, ?, ?)";

    // $stmt = $db->prepare($query);

    // print_r($_POST);
    // echo uniqid(), $_POST['text'],$_POST['time'],$_POST['user_id'], $_POST['video_id'];
    // $stmt->execute(array(
    //   uniqid(),
    //   $_POST['text'],
    //   $_POST['time'],
    //   $_POST['user_id'],
    //   $_POST['video_id']
    // );
    // $db = null;

  }catch(PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
?>
