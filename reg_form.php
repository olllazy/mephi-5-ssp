<?php
 session_start();
 $_SESSION['page'] = 'reg';

?>

<!DOCTYPE html>
<html lang="ru, en">
<head>
  <meta charset=utf-8>
  <link rel='stylesheet' href='css/reg_form.css?v=<%= DateTime.Now.Ticks %'>
  <link rel="stylesheet" href="css/index.css?v=<%= DateTime.Now.Ticks %">
  <title>Регистрация</title>
</head>
<body>
  <?php require "blocks/header.php" ?>
  
  <form class="reg_main" action="vendor/reg.php" method="post">
    <h1>Регистрация</h1>
    <p class="sub-title" style="color: grey"><i> Обязательные поля помечены * </i></p>

    <label for="last_name"><b>Фамилия *</b></label>
    <input type="text" placeholder="Введите фамилию" name="last_name" required> <br>

    <label for="first_name"><b>Имя *</b></label>
    <input type="text" placeholder="Введите имя" name="first_name" required> <br>

    <label for="patronymic"><b>Отчество</b></label>
    <input type="text" placeholder="Введите отчество (если есть)" name="patronymic"> <br>

    <label for="birthday"><b>День рождения *</b></label>
    <input type="date" placeholder="гггг.мм.дд" name="birthday"
    pattern="\d{4}.\d{1,2}.\d{1,2}" required max="<?php echo date("Y-m-d") ?>">
        
    
    <label for="phone"><b>Номер телефона *</b></label>
    <input type="tel" id="phone" name="phone" pattern="[+][7][9][0-9]{9}" placeholder="+79XXXXXXXXX" required>

    <hr>

    <label for="email"><b>Почта *</b></label>
    <input type="email" placeholder="Введите почту" name="email" required> <br>

    <label for="psw"><b>Пароль *</b></label>
    <input type="password" placeholder="Введите пароль" name="psw" required>

    <label for="psw-repeat"><b>Повторите пароль *</b></label>
    <input type="password" placeholder="Подтвердите пароль" name="psw_confirm" required>

    <button type="submit" class="signupbtn">Зарегистрироваться</button>

    <!-- <div class="clearfix">
      <button type="submit" class="signupbtn">Зарегистрироваться</button>
    </div> -->

    <br>
    <br>
    <div class="container">
      Уже есть регистрация? <a href="auth_form.php">Войти</a>
    </div>
  </form>

  <?php  if ($_SESSION['message']){
     echo "<script>alert('".$_SESSION['message']."');</script>";
     unset($_SESSION['message']);
 } ?>

</body>
</html>
