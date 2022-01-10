<?php
    session_start();

    if (!isset($_COOKIE['client'])) {

      $_SESSION['message'] = "Время сессии закончилось. \nПожалуйста, авторизуйтесь повторно.";
      header('Location: ../index.php'); 

    } else {

        $lifetime = 120;
        //$name = ;
        $id =  $_SESSION['client']['id'];
        setcookie('client', $id, time() + $lifetime, '/');

    }
  

    include "connect.php";
    //require "blocks/footer.php";
    

    $id = $_SESSION['client']['id'];
    $output = '';

   if(isset($_GET["query"]))
   {
        
        $search = mysqli_real_escape_string($conn, $_GET["query"]);
        $query = "
        WITH `tmp1` AS ( SELECT `service_id`, `status_id`, `shed_empl_id` 
        FROM `client_service` 
        WHERE `client_id` = '$id'), 

      `tmp2` AS ( SELECT `service_id`, `name_st`, `shed_empl_id`
        FROM `tmp1` INNER JOIN `status` 
        ON `tmp1`.`status_id` = `status`.`status_id`), 

        `tmp3` AS (SELECT `name_serv`, `name_st`, `shed_empl_id`
        FROM `tmp2` INNER JOIN `service` 
        ON `tmp2`.`service_id` = `service`.`id`), 

      `tmp4` AS (SELECT `name_serv`, `name_st`, `day`, `emp_id`
        FROM `tmp3`, `shed_empl` 
        WHERE `tmp3`.`shed_empl_id` = `shed_empl`.`shed_id`)  

      SELECT `name_serv`, `name_st`, `day`, `name_emp` 
        FROM `tmp4` INNER JOIN `employee`
        ON `tmp4`.`emp_id` = `employee`.`emp_id`
        WHERE `name_st` LIKE '%$search%'
        OR `name_serv` LIKE '%$search%'
        OR `day` LIKE '%$search%'
        OR `name_emp` LIKE '%$search%'
        ORDER BY `day` DESC;
    ";
    } 
    else
    {
        $query = "
        WITH `tmp1` AS ( SELECT `service_id`, `status_id`, `shed_empl_id` 
        FROM `client_service` 
        WHERE `client_id` = '$id'), 

      `tmp2` AS ( SELECT `service_id`, `name_st`, `shed_empl_id`
        FROM `tmp1` INNER JOIN `status` 
        ON `tmp1`.`status_id` = `status`.`status_id`), 

        `tmp3` AS (SELECT `name_serv`, `name_st`, `shed_empl_id`
        FROM `tmp2` INNER JOIN `service` 
        ON `tmp2`.`service_id` = `service`.`id`), 

      `tmp4` AS (SELECT `name_serv`, `name_st`, `day`, `emp_id`
        FROM `tmp3`, `shed_empl` 
        WHERE `tmp3`.`shed_empl_id` = `shed_empl`.`shed_id`)  

      SELECT `name_serv`, `name_st`, `day`, `name_emp` 
        FROM `tmp4` INNER JOIN `employee`
        ON `tmp4`.`emp_id` = `employee`.`emp_id`
        ORDER BY `day` DESC;
    ";
    }

    $result = mysqli_query($conn, $query);
     
    if(mysqli_num_rows($result) > 0)
    { 
        $output .= '
        <style type="text/css">
            .table_serv table {
                /*font-size: 1;*/
                width: 95%;
                margin-bottom: 20px;
                align-content: center;
                border: 1px solid #dddddd;
                border-collapse: collapse;
                margin: auto; 
              }
               th {
                font-size: 16;
                font-weight: bold;
                padding: 10px;
                background: #efefef;
                border: 1px solid #dddddd;
              }
              td {
                font-size: 14;
                  align-content: center;
                  border: 1px solid #dddddd;
                  padding: 10px;
               }
               .top {
                 border-top: 4px solid #dddddd;
                 }
        </style>
        <table class="table_serv">
        <thead>
        <tr>
            <th> <center><strong>Дата</strong></center> </th> 
            <th> <center><strong>Нотариальное действие</strong></center> </th> 
            <th> <center><strong>Статус</strong></center> </th> 
            <th> <center><strong>Сотрудник</strong></center> </th>
        </tr>
        </thead><tbody>';
        
        while ($row = mysqli_fetch_array($result)) 
        {
            $output .= '
            <tr>
                <td align="center">' . $row["day"] . '</td>
                <td>' . $row["name_serv"] . '</td>';
                $name_st = $row['name_st'];
                $Color = "black";
                if ($name_st === 'Завершен') {
                  $Color = "green";
                } else if ($name_st === 'Отменено') {
                  $Color = "red";
                }
            $output .= '
                <td align="center"><div style="Color:'.$Color.'">'.$name_st.'</div></td>
                <td>' . $row["name_emp"] . '</td>
            </tr>
            ';
        }
        $output .= '</tbody></table>';
        echo $output;
    } 
    else
    {
        echo 'Не найдено совпадений';
    }

?>


