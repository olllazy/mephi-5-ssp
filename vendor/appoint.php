<?php

	include "connect.php";

	session_start();

  if (!isset($_COOKIE['client'])) {

   	$_SESSION['message'] = "Вы вышли из аккаунта";
    header('Location: ../index.php'); 

  } else {

    $lifetime = 120;
    $id =  $_SESSION['client']['id'];
    setcookie('client', $id, time() + $lifetime, '/');

  

	$option = explode("|", $_POST['emp']);

	$emp_id = $option[0];
	$shed_id = $option[1];

	$client_id = $_SESSION['client']['id'];
	$day = $_POST['day'];
	$serv_id = $_POST['service'];
	$comment = $_POST['comment'];

	$process = date('Y-m-d H:i:s')." | {$client_id} | {$_SESSION['client']['last_name']}";

	mysqli_query($conn,"LOCK TABLES `client_service` WRITE, `shed_empl` WRITE, `process` WRITE;");

	//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	

	try {

		//$conn->begin_transaction();

		$query = "INSERT INTO `process`(`name_proc`) VALUES ( '{$process}' );";
		$result = mysqli_query($conn,$query);

		if ($result===true && mysqli_affected_rows($conn) > 0) {
			$_SESSION['message'] = "Вы записаны"; 

			$process_id = mysqli_insert_id($conn);

			$query = "INSERT INTO `client_service`( `client_id`, `process_id`, `service_id`, `status_id`, `shed_empl_id`, `comment`) VALUES (".$client_id.", ".$process_id.", ".$serv_id.", 1, ".$shed_id.", '".$comment."');";

			$result = mysqli_query($conn,$query); 				

			if ($result===true && mysqli_affected_rows($conn) > 0) {
				$_SESSION['message'] = "Вы записаны";
			}
			else {
				$_SESSION['message'] = "Ошибка при обращении к базам данных";
			}

		}
		else {
			$_SESSION['message'] = "Ошибка при обращении к базам данных";
		}		
		
		sleep(10);

		//$conn->commit();
		mysqli_query($conn,"UNLOCK TABLES;");

		header('Location: ../user.php');

	} catch (Except $exception) {

		//$conn->rollback();

		$_SESSION['message'] = "Ошибка при обращении к базам данных";
		header('Location: ../appointment.php');

	}

		


}
	

?>
