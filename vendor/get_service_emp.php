<?php
    session_start();
  

    include "connect.php";
    //require "blocks/footer.php";
    

    $id = $_SESSION['employee']['id'];
    $output = '';

   if(isset($_GET["query"]))
   {
        
        $search = mysqli_real_escape_string($conn, $_GET["query"]);
        $query = 
        "WITH `tmp1` AS (SELECT `shed_id`, `day` 
          FROM `shed_empl` 
          WHERE `emp_id` = '$id'),

        -- берем процессы 
        `tmp2` AS ( SELECT `client_service`.`id` AS `cs_id`, `shed_id`,`day`,`client_id`,`process_id`,`service_id`,`status_id`,`comment`
          FROM `client_service` INNER JOIN `tmp1` 
          ON `client_service`.`shed_empl_id` = `tmp1`.`shed_id` ),
        
        -- берем ФИО 
        `tmp3` AS (SELECT `cs_id`, `shed_id`,`day`, `process_id`,`service_id`,`status_id`,`comment`,
          `client`.`client_id` as `client_id`,`first_name`,`last_name`,`patronymic` 
          FROM `client` INNER JOIN `tmp2`
          ON `client`.`client_id` = `tmp2`.`client_id`),

        -- берем статус 
        `tmp4` AS (SELECT `cs_id`, `shed_id`,`day`, `process_id`,`service_id`,
          `status`.`status_id` AS `status_id`,`name_st`,`comment`,
          `client_id`,`first_name`,`last_name`,`patronymic` 
          FROM `status` INNER JOIN `tmp3` ON `status`.`status_id` = `tmp3`.`status_id`),
        
        -- берем услугу 
          `tmp5` AS (SELECT `cs_id`, `shed_id`,`day`, `process_id`,`status_id`,`name_st`,`comment`,
          `name_serv`,
          `client_id`,`first_name`,`last_name`,`patronymic` 
          FROM `service` INNER JOIN `tmp4` ON `service`.`id` = `tmp4`.`service_id`)
        
        -- берем процесс
        SELECT `cs_id`, `shed_id`,`day`, `tmp5`.`process_id` AS `process_id`, `name_proc`,`status_id`,`name_st`,`comment`, `name_serv`,
          `client_id`,`first_name`,`last_name`,`patronymic` 

          FROM `process` INNER JOIN `tmp5` 
          ON `process`.`process_id` = `tmp5`.`process_id` 

          WHERE `name_st` LIKE '%$search%'
           OR `day` LIKE '%$search%'
          OR `name_serv` LIKE '%$search%'
          OR `name_proc` LIKE '%$search%'
          OR `comment` LIKE '%$search%'
          OR `first_name` LIKE '%$search%'
          OR `last_name` LIKE '%$search%'
          OR `patronymic` LIKE '%$search%'
          ORDER BY `day` DESC
        
    ";
    } 
    else
    {
        $query = 
        "WITH `tmp1` AS (SELECT `shed_id`, `day` 
          FROM `shed_empl` 
          WHERE `emp_id` = '$id'),

        -- берем процессы 
        `tmp2` AS ( SELECT `client_service`.`id` AS `cs_id`, `shed_id`,`day`,`client_id`,`process_id`,`service_id`,`status_id`,`comment`
          FROM `client_service` INNER JOIN `tmp1` 
          ON `client_service`.`shed_empl_id` = `tmp1`.`shed_id` ),
        
        -- берем ФИО 
        `tmp3` AS (SELECT `cs_id`, `shed_id`,`day`, `process_id`,`service_id`,`status_id`,`comment`,
          `client`.`client_id` as `client_id`,`first_name`,`last_name`,`patronymic` 
          FROM `client` INNER JOIN `tmp2`
          ON `client`.`client_id` = `tmp2`.`client_id`),

        -- берем статус 
        `tmp4` AS (SELECT `cs_id`, `shed_id`,`day`, `process_id`,`service_id`,
          `status`.`status_id` AS `status_id`,`name_st`,`comment`,
          `client_id`,`first_name`,`last_name`,`patronymic` 
          FROM `status` INNER JOIN `tmp3` ON `status`.`status_id` = `tmp3`.`status_id`),
        
        -- берем услугу 
          `tmp5` AS (SELECT `cs_id`, `shed_id`,`day`, `process_id`,`status_id`,`name_st`,`comment`,
          `name_serv`,
          `client_id`,`first_name`,`last_name`,`patronymic` 
          FROM `service` INNER JOIN `tmp4` ON `service`.`id` = `tmp4`.`service_id`)
        
        -- берем процесс
        SELECT `cs_id`, `shed_id`,`day`, `tmp5`.`process_id` AS `process_id`, `name_proc`,`status_id`,`name_st`,`comment`, `name_serv`,
          `client_id`,`first_name`,`last_name`,`patronymic` 

          FROM `process` INNER JOIN `tmp5` 
          ON `process`.`process_id` = `tmp5`.`process_id` ORDER BY `day` DESC;"
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
        <br>
        <h2><strong> Нотариальные процессы </strong></h2>
        <div class="table_serv">
        <table >
            <thead>
            <tr>
            <th> <center><strong>Дата</strong></center> </th> 
            <th> <center><strong>Клиент</strong></center> </th> 
            <th > <center><strong>Оказываемая услуга</strong></center> </th>         
            <th> <center><strong>Статус</strong></center> </th>
            <th colspan="2"> <center><strong>Действия</strong></center> </th>
            </tr> 
            </thead>
            <tbody>';


    while ( $row = mysqli_fetch_assoc($result) ) { 
                
    
                  $cs_id = $row['cs_id'];
                  $client_id = $row['client_id'];
                  $shed_id = $row['shed_id'];
                  $day = $row['day'];
                  $last_name = $row['last_name'];
                  $first_name = $row['first_name'];
                  $patronymic = $row['patronymic'];
                  $name_serv = $row['name_serv'];
                  $status_id = $row['status_id'];
                  $name_st = $row['name_st'];
                  $process_id = $row['process_id'];

                
                $output .= '<form action="vendor/change_status.php" method="GET">
                <tr class="top">             
                <td ><p><center>'.$day.'<input type="hidden" id="cs_id" name="cs_id" value="'.$cs_id.'"></center></p></td> 
                <td> ';             
                  $output .= $last_name." ".$first_name." ".$patronymic.'</td> ';
                $output .= 
                '<td >'.$name_serv.'</td>            
                <td> <input type="hidden" id="status_id" name="status_id" value="'.$status_id.'">'; 
                  //$name_st = $row['name_st'];
                  $Color = "black";
                  if ($name_st === 'Завершен') {
                    $Color = "green";
                  } else if ($name_st === 'Отменено') {
                    $Color = "red";
                  } 
                  $output .= '<div style="Color:'.$Color.'">'.$name_st.'</div>
                </td> 
                <td ><p><center>
                  <button type="submit" name="action" value="2" style="border: 0; background: transparent">
                    <img src="imgs/finish-button.png" width="25" height="25" alt="finish" />
                  </button>
                </center></p></td> 
                <td><p><center>
                  <button type="submit" name="action" value="3" style="border: 0; background: transparent">
                    <img src="imgs/cancel-button.png" width="25" height="25" alt="cancel" />
                  </button>
                </center></p></td> 
              </tr>
              <tr>
                <td colspan="2" bgcolor="#f7f7f7" align="center">Комментарий</td>            
                <td colspan="2"  bgcolor="#f7f7f7" align="center"> Процесс</td>  
                <td colspan="2"  bgcolor="#f7f7f7" align="center"> Документ</td>          
              </tr> 
              <tr>
                <td colspan="2"><p> '.$row['comment'].'<p></td>
                <td  colspan="2"><p> '.echo $process_id.' | '.$row['name_proc'].'<p></td>
                <td colspan="2"></td>
              </tr class="bottom">          
                </form>'
            };
            
        $output .= '</tbody>
        </table></div>';
        echo $output;
        
        
        
    } 
    else
    {
        echo 'Не найдено совпадений';
    }

?>


