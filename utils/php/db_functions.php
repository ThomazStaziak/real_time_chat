<?php
  $conn = new PDO('pgsql:host=localhost;port=5432;dbname=chat_php;user=postgres;password=docker');
  
  function insertChat($username, $message, $time) {
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

  function insertOnlineUser($username) {
    try {
      global $conn;

      $insert = $conn->prepare("INSERT INTO online_users (username) VALUES (:username)");
      $inserted = $insert->execute([
        ':username' => $username
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

  function getOnlineUsers() {
    try {
      global $conn;

      $select = $conn->query("SELECT * FROM online_users");
      $users = $select->fetchAll(PDO::FETCH_ASSOC);
  
      return $users;
    } catch (PDOException $err) {
      echo $err->getMessage();
    }
  }

  function getOnlineUserByName($username) {
    try {
      global $conn;

      $select = $conn->prepare("SELECT * FROM online_users WHERE username = :username");
      $select->execute([
        ':username' => $username
      ]);
      $user = $select->fetch(PDO::FETCH_ASSOC);
  
      return $user;
    } catch (PDOException $err) {
      echo $err->getMessage();
    }
  }

  function deleteOnlineUser($id) {
    try {
      global $conn;

      $delete = $conn->prepare("DELETE FROM online_users WHERE id = :id");
      $deleted = $delete->execute([
        ':id' => $id
      ]);
  
      return $deleted;
    } catch (PDOException $err) {
      echo $err->getMessage();
    }
  }