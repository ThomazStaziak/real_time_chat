<?php
  session_start();
  require_once '../../vendor/autoload.php';
  require_once 'db_functions.php';

  $app_id = '846919';
  $app_key = '2fb071cffdac6f3ff0d7';
  $app_secret = 'b06a98782716d59c6079';
  $options = [
    'cluster' => 'us2',
    'useTLS' => true
  ];
  
  $pusher = new Pusher\Pusher(
    $app_key, 
    $app_secret, 
    $app_id, 
    $options
  );
  
  insertChat($_POST['username'], $_POST['message'], date('H:i', time()));
  $chats = getMessages();
  $chat = end($chats);
  
  $pusher->trigger('channel', 'chat', [$chat, $_SESSION['username']]);
?>
  