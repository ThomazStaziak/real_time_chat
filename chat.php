<?php 
  session_start();
  require 'utils/php/db_functions.php';
  if ($_POST && !empty($_POST['username'])) 
    $_SESSION['username'] = $_POST['username'];
  else 
    header('Location: index.html');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- <meta http-equiv="refresh" content="5"> -->
    <title>Chat PHP</title>
    <!-- bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="styles/global.css" />
    <link rel="stylesheet" href="styles/chat.css" />
    <script
      defer
      src="https://code.jquery.com/jquery-3.4.1.js"
      integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous"
    ></script>
    <script
      defer
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"
    ></script>
    <script
      defer
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"
    ></script>

    <!-- custom scripts -->
    <script defer src="utils/js/scrollDown.js"></script>
    <!-- pusher scripts -->
    <script defer src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script defer src="utils/js/listener.js"></script>
  </head>
  <body>
    <div class="chat-container">
      <h1>Hey <?= $_SESSION['username'] ?> welcome to the chat</h1>
      <div id="screen" class="message-container">
        <?php foreach(getMessages() as $chat) : ?>
          <div class="<?= $_SESSION['username'] == $chat['username'] ? 'mine' : 'yours' ?> message">
            <div class="row w-100 d-flex justify-content-between p-2 m-0">
              <span><b><?= $chat['username'] ?></b></span>
              <span><?= substr($chat['time'], 0, 5)?></span>
            </div>
            <p class="p-2"><?= $chat['message'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="input-container row">
        <input
          id="username"
          type="hidden"
          value="<?= $_SESSION['username'] ?>"
          class="form-control"
          placeholder="Type your username"
        />
        <div class="form-group col-8 p-0">
          <input
            id="message"
            class="form-control"
            placeholder="Type your message"
          >
        </div>
        <div class="form-group col-4 p-0">
          <button id="button" class="btn btn-login col-12 h-100">Send</button>
        </div>
    </div>
    </div>

    <script>
      window.onload = () => {
        scrollDown('#screen', 10)
      }
    </script>
  </body>
</html>
