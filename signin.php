<?php
  require_once './vendor/autoload.php';
  // Get $id_token via HTTPS POST.
  $id_token = $_POST['idtoken'];
  // $client_id = $_POST['client_id'];

  $client = new Google_Client(['client_id'=>$client_id]);
  // echo "eh $id_token";
  // echo $client;
  $payload = $client->verifyIdToken($id_token);
  if ($payload) {
    echo 'pay';
    $userid = $payload['sub'];
    // If request specified a G Suite domain:
    //$domain = $payload['hd'];
  } else {
    // Invalid ID token
    $userid = 'invalid';
  }
  echo $userid;
?>
