<?php
    session_start();      

    
    $cs_id = $_GET['cs_id'];
    $old_satus = $_GET['status_id'];
    $new_status = $_GET['action'];



    //print_r($_GET);

    if ($old_satus === $new_status) 
    {
        if ($old_satus === '2') {
            $_SESSION['message'] = 'Статус встречи уже "Завершен"';
            header('Location: ../employee.php');
        } 
        else {
            $_SESSION['message'] = 'Статус встречи уже "Отменено"';
            header('Location: ../employee.php'); 
        }
    } 
    else {
        

        require_once 'connect.php';
        $sql = "UPDATE `client_service` SET `status_id` = {$new_status} WHERE `id` = {$cs_id} ";
        $res = mysqli_query($conn,$sql);

        if ($res===true and $conn->affected_rows > 0)
        {
            if ($new_status === '2') {
                $_SESSION['message'] = 'Статус встречи успешно обновлен на "Завершен"';
                //header('Location: ../employee.php');
            } 
            else {
                $_SESSION['message'] = 'Статус встречи успешно обновлен на "Отменено"';
                //header('Location: ../employee.php'); 
            }
        } else {
            $_SESSION['message'] = 'Ошибка при обращении к базе даных';
        }
        header('Location: ../employee.php'); 
    }

    

?>

