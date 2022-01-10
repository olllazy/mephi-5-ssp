<?php
  session_start();
  require_once "connect.php";

  $login = $_POST['login'];
  $password = $_POST['psw'];

  $check_user = $conn -> query("SELECT * FROM `employee` WHERE `login`='$login' AND `password`='$password'");

  $employee = $check_user -> fetch_assoc();



  if (count($employee) === 0) { 

    $_SESSION['message'] = 'Неверные логин и пароль';
    header('Location: ../auth_form.php');
  }
  
  else {
    $_SESSION['employee'] = array(
      "id" => $employee['emp_id'],
      "name" => $employee['name_emp'],
    );

    $_SESSION['message'] = 'Вы вошли как сотрудник';
    header('Location: ../employee.php');
  }

 ?>
