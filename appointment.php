<?php
    session_start();

    if (!isset($_COOKIE['client'])){

        $_SESSION['message'] = "Время сессии закончилось. Пожалуйста, авторизуйтесь повторно.";
        header('Location: ../index.php'); 

    } else {

        $lifetime = 120;
        $id =  $_SESSION['client']['id'];
        setcookie('client', $id, time() + $lifetime, '/');

    }

        include 'vendor/connect.php';
        
        
        function POSTDays() {
            global $conn;
            //echo "quack";

            $query = "SELECT DISTINCT `day` FROM `shed_empl` WHERE `is_free`=0 AND `day`>CURRENT_DATE ORDER BY `day` ASC;";

            $res = mysqli_query($conn, $query);

            return mysqli_fetch_all($res, MYSQLI_ASSOC);
        }
        

        function POSTEmps() {
            global $conn;
            $code = mysqli_real_escape_string($conn, $_POST['code']);
            $query = "SELECT DISTINCT `shed_id`, `shed_empl`.`emp_id`, `employee`.`name_emp` FROM `shed_empl`,`employee` WHERE `shed_empl`.`emp_id` = `employee`.`emp_id` AND `is_free`=0 AND `shed_empl`.`day`  = '$code';
        ";
            $res = mysqli_query($conn, $query);
            $data = '';

            $data .= "<option value='' disabled selected>Выберите сотрудника</option>";

            while($row = mysqli_fetch_assoc($res)){
                
                $data .= "<option value='{$row['emp_id']}|{$row['shed_id']}'>{$row['name_emp']}</option>";
            }
            return $data;
        }

        if(!empty($_POST['code'])) {
            //echo $_POST['code'];
            
            echo POSTEmps();
            exit;
        }

        

    ?>

<!DOCTYPE html>
<html lang="en,ru" dir="ltr">
     <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/user.css">
        <link rel='stylesheet' href='css/reg_form.css?v=<%= DateTime.Now.Ticks %'/>
        


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

        <title>Запись к нотариусу</title>

        <style type="text/css">
            .emp-select{
                display: none;
            }
        </style>
</head>
<body>
<?php require "blocks/header.php"; ?>
<?php require "blocks/footer.php" ?>

<form class="reg_main" method="POST" action="/vendor/appoint.php">
<h1>Запись к нотариусу</h1>

    <p class="msg">
      <?php
      //echo "<script>alert('quack');</script>";
      //echo $_SESSION['message'];
        if (isset($_SESSION['message'])) {
            echo "<script>alert('".$_SESSION['message']."');</script>";
            unset($_SESSION['message']);
        }        
       
      ?>
    </p> <br>

    <label for="service"><b>Нотариальное действие</b></label><br>
    <select class="form-control" id="service" name="service" required>

        <option value="" disabled selected> Выберите услугу </option>
        <?php 
            $res_service = $conn -> query("SELECT `id`,`name_serv` FROM `service` ORDER BY `id` ASC;"); 
            while ($row = mysqli_fetch_array($res_service)) 
            {
                //echo '<option value='1'>quack</option>'; 
                echo '<option value="'.$row['id'].'"">'.$row['name_serv'].'</option>'; 
            }
        ?>

    </select><br>

    <label for="service"><b>День посещения</b></label><br>

    <select class="form-control" name="day" id="day" required>

        <?php $days = POSTDays(); ?>
        <option disabled selected > Выберите день </option>
        <?php foreach($days as $row): 
            echo '<option value="'.$row['day'].'">'.$row['day'].'</option>'; 
        endforeach; ?>

    </select>
    <br>



    <div class="form-group emp-select" >
        <label for="tmp"><b>Сотрудник</b></label><br>
        <select class="form-control" name="emp" id="emp" required>

        </select>
    </div>  

    
    <label for="text"><b>Комментарий</b></label>
    <input type="text" placeholder="Напишите комментарий" name="comment"> <br>
    

    <input type="hidden" id="client_id" name="client_id" value="<?=$_SESSION['client']['id']?>"><br>
    
    <script>
    $(function() {

        $('#day').change(function() {
            var code = $(this).val();
            $('#emp').load('appointment.php', {code: code}, function(){
                $('.emp-select').fadeIn('slow');
            });

        });

    });
    </script>

    <button type="submit" class="signupbtn" >Записаться</button>
    
    </div>
  </form>

</body>