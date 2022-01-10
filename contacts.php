<?php
 session_start();
 $_SESSION['page'] = 'сontacts';
 
 if (isset($_COOKIE['client'])) {

   $lifetime = 120;
   $id =  $_SESSION['client']['id'];
   setcookie('client', $id, time() + $lifetime, '/');

 }

 ?>

 <!DOCTYPE html>
<html lang="ru, en"> 
<head>
    <link rel="stylesheet" href="css/index.css?v=<%= DateTime.Now.Ticks %">
    <title>Контакты</title>
    <style type="text/css">
        table {

            width: 95%;
            margin-bottom: 20px;
            border: 1px solid #dddddd;
            border-collapse: collapse;
            margin: auto; 
        }
        th {
            font-weight: bold;
            padding: 5px;
            background: #efefef;
            border: 1px solid #dddddd;
        }
        td {
            border: 1px solid #dddddd;
            padding: 5px;
        }

    </style>
</head>
<body>
    <?php require "blocks/header.php"; ?>
    <?php require "blocks/footer.php" ?>
    <br>
    <h1><center><strong>Контакты для связи</center></strong></h1>
    <header>
      <h2>Бобровская Ольга Сергеевна</h2>
    </header>
    <article>
      <p><b>Телефон</b>: +79093632036</p>
      <p><b>Электронная почта</b>: <a href = "mailto: osbobrovskaya@mail.ru">osbobrovskaya@mail.ru</a></p>
    </article>
</body>
</html>