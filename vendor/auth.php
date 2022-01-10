<?php
  
     
  session_start();
  try {
  include "connect.php";
  //require "blocks/footer.php" ;



  $email = $_POST['email'];
  $password = $_POST['psw'];

  $check_user = $conn -> query("SELECT * FROM `client` WHERE `email`='$email' AND `password`='$password'");

  $client = $check_user -> fetch_assoc();

  if (count($client) === 0) {

    $_SESSION['message'] = 'Неверные логин и пароль';
    header('Location: ../auth_form.php');
 
  } else {

    $_SESSION['client'] = array (
      "id" => $client['client_id'],
      "last_name" => $client['last_name'],
      "first_name" => $client['first_name'],
    );

    $lifetime = 120;
    $name = 'client';
    $id =  $_SESSION['client']['id'];
    setcookie($name, $id, time() + $lifetime, '/');
    

    $_SESSION['message'] = 'Вы авторизованы';
    header('Location: ../user.php');

  }
  } catch (Exception $e) {

      $_SESSION['message'] =  'Caught exception: '.$e->getMessage()."\n";
      header('Location: ../auth_form.php');

  }

  $conn->close();
?> 
