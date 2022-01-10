<?php

  session_start();    
  $_SESSION['page'] = 'auth';

 ?>

<!DOCTYPE html >
<html lang="ru, en">
<head>
  <meta charset=utf-8>
  <link rel="stylesheet" href="css/index.css?v=<%= DateTime.Now.Ticks %">
  <link rel="stylesheet" href="css/auth_form.css">
  <title>Авторизация</title>
</head>
<body>
  <?php require "blocks/header.php" ?>
  <//?php require "blocks/sidenav.php" ?>


  <div class="auth_main">
      <h3>Войти в аккаунт</h3>
      <form class="container" action="vendor/auth.php" method="post">
        <label for="email" style="margin-left: 10px"><b>Email</b></label>
        <input type="text" placeholder="Введите email" name="email" required>

        <label for="psw" style="margin-left: 10px"><b>Пароль</b></label>
        <input type="password" placeholder="Введите пароль" name="psw" required>

        <?php // TODO: нормальный стиль для кнопки! ?>
        <button type="submit" style="auth_button">Войти как пользователь</button>

         <?php  if (isset($_SESSION['message'])) {
            echo "<script>alert('".$_SESSION['message']."');</script>";
            unset($_SESSION['message']);
        } ?>

        <p>
          Ещё нет аккаунта? <a href="reg_form.php" style = "text-decoration: none;">Зарегистрируйтесь</a>
        </p>
      </form>

      <hr>
      <h3>Вход для менеджеров</h3>

      <form class="container" action="vendor/auth_employee.php" method="post">
        <label for="login"><b>Логин</b></label>
        <input type="text" placeholder="Введите логин" name="login" required>

        <label for="psw"><b>Пароль</b></label>
        <input type="password" placeholder="Введите пароль" name="psw" required>

        <button type="submit">Войти как менеджер</button>


      </form>
    </div>

</div>

</body>
</html>
