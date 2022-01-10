<?php
  session_start();
?>
<style type="text/css">
        /*  body {
          display: grid;
          grid: [stack] 1fr/-webkit-min-content [stack] 1fr;
          grid: [stack] 1fr/min-content [stack] 1fr
        }
        */
        .side-button-1 .side-close {
            display: none;
        }
        #side-checkbox:checked + .side-panel + .side-button-1-wr .side-button-1 .side-open {
            display: none;
        }
        #side-checkbox:checked + .side-panel + .side-button-1-wr .side-button-1 .side-close {
            display: block;
        }
        #side-checkbox:checked + .side-panel {
            left: 0;
        }
        /* Оформление панели */
        #side-checkbox {
            display: none;
        }
        .side-panel {
            position: fixed;
            z-index: 999999;
            top: 0;
            left: -360px;
            background: #B78655;
            transition: all 0.5s;   
            width: 320px;
            height: 100vh;
            box-shadow: 5px 0 10px rgba(0,0,0,0.4);
            color: #FFF;
            padding: 40px 20px;
        }
        .side-panel a {
          /*padding: 6px 8px 6px 16px;*/
          text-decoration: none;
          /*font-size: 25px;
*/         color: white;
          display: block;
        }
        .side-panel a: hover {
          transform: scaleX(1.1);
        }
        .side-title {
            font-size: 20px;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #FFF;
        }
        /* Оформление кнопки на странице */
        .side-button-1-wr {
            text-align: center; /* Контейнер для кнопки, чтобы было удобнее ее разместить */
        }
        .side-button-1 {
            display: inline-block;
        }
        .side-button-1 .side-b {
            margin: 20px;
            /*margin-right:2px;*/
            /*text-decoration: none;*/
            position: relative;
            font-size: 15px;
            line-height: 20px;
            padding: 14px 20px;
            color: white;
            opacity: 0.9;
            float: right;
            /*font-weight: bold;
            text-transform: uppercase; */
            font-family: Arial, Helvetica, sans-serif;
            background-color: #926B44;
            cursor: pointer; 
            border-radius: 4px;
            border: 2px solid #d49c63;
        }
        
        .side-button-1 .side-b:hover,
        .side-button-1 .side-b:active,
        .side-button-1 .side-b:focus {
            color: #FFF;
        }
        /*.side-button-1 .side-b:after,
        .side-button-1 .side-b:before {
            position: absolute;
            height: 4px;
            left: 50%;
            bottom: -6px;
            content: "";
            transition: all 280ms ease-in-out;
            width: 0;
        }*/
        /*.side-button-1 .side-open:after,
        .side-button-1 .side-open:before {
            background: red;
        }  */      
        /*.side-button-1 .side-b:before {
            top: -6px;
        }*/
        /*.side-button-1 .side-b:hover:after,
        .side-button-1 .side-b:hover:before {
            width: 100%;
            left: 0;
        }*/
        .side-button-2 {
            font-size: 30px;
            border-radius: 20px;
            position: absolute;
            z-index: 1;
            top: 8px;
            right: 8px;
            cursor: pointer;
            transform: rotate(45deg);
            color: #white;    
            transition: all 280ms ease-in-out;    
        }
        .side-button-2:hover {
            transform: rotate(45deg) scale(1.1);    
            color: #FFF;
        }
        p .contacts: {
            vertical-align: bottom;
        }
</style>

<input type="checkbox" id="side-checkbox" />
    <div class="side-panel">
        <label class="side-button-2" for="side-checkbox">+</label>    
        <div class="side-title">Меню</div>
        <p><a href="index.php">Главная страница</a> </p>
        <p><a href="tariff.php">Тарифы</a> </p>
        <?php  if (isset($_COOKIE['client'])):?>
            <p><a href="appointment.php">Записаться на приём</a> </p>
        <?php endif; ?>
        <div class="contacts">
            <p><a href="contacts.php">Контакты</a> </p>
        </div>
        <!-- <p><a href="reg_form.php">Регистрация</a> </p> -->
</div>