<?php
  $conn = new PDO('pgsql:host=localhost;port=5432;dbname=chat_php;user=postgres;password=docker');
  
  function insert($username, $message, $time) {
    try {
      global $conn;

      $insert = $conn->prepare("INSERT INTO chat (username, message, time) VALUES (:username, :message, :time)");
      $inserted = $insert->execute([
        ':username' => $username,
        ':message' => $message,
        ':time' => $time
      ]);

      return $inserted;
    } catch (PDOException $err) {
      echo $err->getMessage();
    }
  }

  function getMessages() {
    try {
      global $conn;

      $select = $conn->query("SELECT * FROM chat");
      $messages = $select->fetchAll(PDO::FETCH_ASSOC);
  
      return $messages;
    } catch (PDOException $err) {
      echo $err->getMessage();
    }
  }