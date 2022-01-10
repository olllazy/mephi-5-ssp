<?php
 session_start();
 $_SESSION['page'] = 'tariff';
 
 if (isset($_COOKIE['client'])) {

   $lifetime = 120;
   $id =  $_SESSION['client']['id'];
   setcookie('client', $id, time() + $lifetime, '/');

 }

?> 

<?php 
     try {
        include "vendor/connect.php";
        $result = mysqli_query($conn,"SELECT * FROM `service`;");
        
        
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    //INSERT INTO job(name_job) VALUE ("");
    // INSERT INTO employee(name,login,password,phone,job_id) VALUES
    /*
    
*/

?>



<!DOCTYPE html>
<html lang="ru, en"> 
<head>
    <link rel="stylesheet" href="css/index.css?v=<%= DateTime.Now.Ticks %">
    <title>Тарифы</title>
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
    <?php require "blocks/header.php" ?>
    <?php require "blocks/footer.php" ?>
    <br>
    <h2><center><strong>ТАРИФЫ ЗА СОВЕРШАЕМЫЕ НОТАРИАЛЬНЫЕ ДЕЙСТВИЯ И УСЛУГИ ПРАВОВОГО И ТЕХНИЧЕСКОГО ХАРАКТЕРА </center></strong></h2>
    <p><center><strong>за 2021 год</center></strong></p>
    <table>
        <thead>
        <tr>
        <th> <center><strong>№</strong></center> </th> 
        <th> <center><strong>Нотариальное действие</strong></center> </th> 
        <th> <center><strong>Тариф по НК и ОЗоН</strong></center> </th> 
        <th> <center><strong>Услуги ПиТХ</strong></center> </th>
        </tr> 
        </thead>
        <tbody>
        <?php while ( $row = mysqli_fetch_assoc($result) ) { ?>
            <tr> 
            <td><p> <?php echo $row['id']; ?></p></td> 
            <td> <?php echo $row['name_serv']; ?>   </td>
            <td> <?php echo $row['tariff'];?> </td> 
            <td> <?php echo $row['payment_UPTH'];?>  </td> 
            </tr>
        <?php   } ?>
    </tbody>
    </table>
</body>
</html>