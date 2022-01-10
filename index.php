<?php
  session_start();
  $_SESSION['page'] = 'index';

  if (isset($_COOKIE['client'])) {

    $lifetime = 120;
    $id =  $_SESSION['client']['id'];
    setcookie('client', $id, time() + $lifetime, '/');

  }
  
 ?>


<!DOCTYPE html>
<html lang="ru, en">
<head>
  <meta charset="utf-8">
  <link rel='stylesheet' href='css/index.css?v=<%= DateTime.Now.Ticks %'>
  <title>Основная страница</title>
</head>
<body>

  <?php require "blocks/header.php";
  require "blocks/footer.php";



  if (isset($_SESSION['message'])) {
      echo "<script>alert('".$_SESSION['message']."');</script>";
      unset($_SESSION['message']);
  }        


  ?>


  <div class="index_main">
    <p> Что говорит уточка? </p>
    <p><img src="imgs/duck2.jpg" alt="duck1" width = 100%></p>
    <p> Что говорит уточка, когда ты не составляешь брачный договор? </p>
    <p><img src="imgs/duck.jpg" alt="duck2" width = 100%></p>
  </div>

</body>
</html>
