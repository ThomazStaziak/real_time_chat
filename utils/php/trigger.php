<?php
  require_once '../../vendor/autoload.php';

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

  $data['username'] = $_POST['username'];
  $data['message'] = $_POST['message'];
  $data['time'] = date('h:i', time());

  $pusher->trigger('channel', 'chat', $data);
?>
  