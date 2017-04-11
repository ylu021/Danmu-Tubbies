<?php
  include 'db-info.php';
  //
  try {
    $db = new PDO($dsn);
    // print "No error!";
    $query = 'SELECT COUNT(*) from "Tubbies_Comment" WHERE user_id=?';
    $stmt = $db->prepare($query);
    $stmt->execute(array($_GET['user_id']));
    $rows = $stmt->fetchAll();

		if(count($rows) == 0) {
      echo "i dont have it";
    }else{
      echo "i have it";
      $data = array(
        uniqid(),
        $_POST['text'],
        $_POST['time'],
        $_POST['video_id'],
        urldecode($_POST['user_id'])
      );
      echo 'hi'.$data;
      $query = 'INSERT INTO "Tubbies_Comment"(comment_id, comment_text, comment_time, video_id, user_id) VALUES(?,?,?,?,?)';
      $stmt = $db->prepare($query);
      if($stmt->execute($data)){
        echo "success!";
      }
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
