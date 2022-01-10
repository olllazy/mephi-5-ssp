<?php
  session_start();

  if (!isset($_COOKIE['client'])) {

    $_SESSION['message'] = "Время сессии закончилось. \nПожалуйста, авторизуйтесь повторно.";
    header('Location: ../index.php'); 

  } else {

    $lifetime = 120;
    $id =  $_SESSION['client']['id'];
    setcookie('client', $id, time() + $lifetime, '/');

  }



  $_SESSION['page'] = 'client';

  if (isset($_SESSION['message'])) {

      echo "<script>alert('".$_SESSION['message']."');</script>";
      unset($_SESSION['message']);
  }
  

  include "vendor/connect.php";

 ?>


 <!DOCTYPE html>
 <html lang="en,ru" dir="ltr">
   <head>
     <meta charset="utf-8">     
     <link rel="stylesheet" href="css/user.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

     <title>Страница пользователя</title>
     
    </head>

   <body> 
     <?php require "blocks/header.php" ?>

     <div class='user_main'>
      <h3>Здравствуйте, <?php echo($_SESSION['client']['first_name']); ?>
      </h3>

      <div class="container">
         <br />
         <h2 align="center">Поиск встречи</h2><br />
         <div class="form-group">
          <div class="input-group">
           <span class="input-group-addon">Поиск</span>
           <input type="text" name="search_text" id="search_text" placeholder="Введите что-нибудь" class="form-control" />
          </div>
         </div>
         <br />
         <div id="result"></div>
        </div>

        <script>
        $(document).ready(function(){

         load_data();

         function load_data(query)
         {
          $.ajax({
           url:"vendor/get_service.php",
           method:"GET",
           data:{query:query},
           success:function(data)
           {
            $('#result').html(data);
           }
          });
         }
         $('#search_text').keyup(function(){
          var search = $(this).val();
          if(search != '')
          {
           load_data(search);
          }
          else
          {
           load_data();
          }
         });
        });
        </script>     

     <?php require 'blocks/footer.php'; ?> 


   </body>
 </html>
