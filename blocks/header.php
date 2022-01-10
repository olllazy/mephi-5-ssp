<?php
      session_start();
?>

<head>
      <!-- <link rel='stylesheet' href='css/index.css?v=<%= DateTime.Now.Ticks %'> -->
      <link rel='stylesheet' href='css/header.css?v=<%= DateTime.Now.Ticks %'>

</head>

<?php require "blocks/sidebar.php" ?>
<div class="header">
    <div class="side-button-1-wr">
        <label class="side-button-1" for="side-checkbox">
              <div class="side-b side-open">☰</div>
        </label>
    </div>
    
    <div class="header-title">

        <?php switch ($_SESSION['page']) {
            case 'index': 
                echo '<h1>Главная</h1>';
                break;
            case 'reg':
                echo '<h1>Регистрация</h1>';
                break;
            case 'auth': 
                echo '<h1>Авторизация</h1>';
                break;
            case 'client': 
                echo '<h1>Личный кабинет</h1>';
                break;
            case 'employee': 
                echo '<h1>Личный кабинет</h1>';
                break;           
            case 'tariff': 
                echo '<h1>Тарифы</h1>';
                break;           
            case 'сontacts': 
                '<h1>Контакты</h1>';
                break;
                
        }

        ?>

    </div>

    <div class="header-actions"> 

          <?php if (isset($_COOKIE['client']) || isset($_SESSION['employee'])): ?>

                <?php   if (isset($_COOKIE['client'])):?>
                    <div class="user_button">
                          <a href="user.php">
                                    <button style="user_button">Кабинет</button>
                          </a>
                    </div>
                <?php else: ?>
                    <div class="user_button">
                          <a href="employee.php">
                                    <button style="user_button">Кабинет</button>
                          </a>
                    </div>
                <?php endif; ?>

                <div class="exit_button">
                    <a href="vendor/exit.php">
                              <button style="auth_button">Выйти</button>
                    </a>
                </div>

          <?php else: ?>
                
                <div class="reg_button">
                    <a href="reg_form.php">
                              <button type="button">Регистрация</button>
                    </a>
                </div>       

                <div class="auth_button">
                    <a href="auth_form.php">
                              <button style="auth_button">Войти</button>
                    </a>
                </div>

          <?php endif; ?>
      </div>
</div>
