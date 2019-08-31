<?php 
  session_start();
  require_once './vendor/autoload.php';
  require_once './utils/php/db_functions.php';

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

  if ($_POST && !empty($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    setcookie('username', $_POST['username']);
    insertOnlineUser($_POST['username']);
    
    $pusher->trigger('channel', 'userAction', getOnlineUsers());
  } else {
    header('Location: index.html');
  }
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
    <link
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="./assets/css/global.css" />
    <link rel="stylesheet" href="./assets/css/chat.css" />
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
    <script defer src="utils/js/getCookie.js"></script>
    <!-- pusher scripts -->
    <script defer src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script defer src="utils/js/listener.js"></script>
  </head>
  <body>
    <main>
      <header>
        <nav class="navbar navbar-light bg-transparent">
          <a href="index.html" class="navbar-brand">
            <img
              src="./assets/img/logo.png"
              width="30"
              height="30"
              class="d-inline-block align-top"
              alt=""
            />
            Chatzin
          </a>
          <form action="utils/php/logout.php" method="POST" class="form-inline">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">
              Logout
            </button>
          </form>
        </nav>
      </header>
      <div class="chat-container">
        <div class="col-sm-6 frame screen">
          <ul id="screen">
            <?php foreach(getMessages() as $chat) : ?>
              <li style="width:100%">
                <div class="<?= $chat['username'] === $_SESSION['username'] ? 'msj-rta' : 'msj' ?> macro">
                  <div class="text <?= $chat['username'] === $_SESSION['username'] ? 'text-l' : 'text-r' ?>">
                    <?php if($chat['username'] != $_SESSION['username']) : ?>
                      <p class="user font-weight-bold"><?= $chat['username'] ?></p>
                    <?php endif; ?>
                    <p class="message"><?= $chat['message'] ?></p>
                    <p class="time"><small><?= substr($chat['time'], 0, 5)?></small></p>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <form id="form" class="input-container">
              <input
              id="username"
              type="hidden"
              value="<?= $_SESSION['username'] ?>"
              placeholder="Type your username"
            />
            <input id="message" type="text" placeholder="Type a message" />
            <button type="submit">
              <i class="fa fa-arrow-right"></i>
            </button>
          </form>
        </div>
        <div class="col-sm-3 online-users">
          <h4 class="mb-6">Online Users</h4>
          <div>
            <p class="text-success font-weight-bold"><?= $_SESSION['username'] ?></p>
            <div class="users">
              <?php foreach(getOnlineUsers() as $onlineUser) : ?>
                <?php if ($onlineUser['username'] != $_SESSION['username']) : ?>
                  <p class="text-success"><?= $onlineUser['username'] ?></p>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script>
      window.onload = () => {
        scrollDown('#screen', 100)
      }
    </script>
  </body>
</html>
