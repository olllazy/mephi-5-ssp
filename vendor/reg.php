<?php

session_start();
  

require_once 'connect.php';


$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$patronymic = $_POST['patronymic'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$birthday = $_POST['birthday'];
$login = $_POST['login'];
$password = $_POST['psw'];
$password_confirm = $_POST['psw_confirm'];

if ($password === $password_confirm) {

    $res = $conn -> query(
        "SELECT * FROM `client` WHERE 'email' = '$email'
    ");

    $check_user = $conn -> query("SELECT * FROM `client` WHERE `email`='$email'");
    $client = $check_user -> fetch_assoc();   


    if (count($client) === 0) {

        if (!$conn -> query(
            "INSERT INTO `client` (
                `last_name`, `first_name`, `patronymic`, 
                `email`, `birthday`,`phone`, `password`) 
            VALUES (
                '$last_name', '$first_name', '$patronymic', 
                '$email', '$birthday','$phone', '$password')
            ")) 
        {
            $_SESSION['message'] = 'Проверьте правильность введенных данных';
            header('Location: ../reg_form.php');

        } else {
            $_SESSION['message'] = 'Вы успешно зарегистрированы';
            header('Location: ../auth_form.php');
        }
    } else {

        $_SESSION['message'] = 'Такая почта уже занята';
        header('Location: ../reg_form.php');
    
    }
} else {
    $_SESSION['message'] = 'Введенные пароли не совпадают';
    header('Location: ../reg_form.php');
}
?>
