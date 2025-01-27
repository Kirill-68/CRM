<?php
session_start();
if(isset($_GET['do']) && $_GET['do'] == 'logout') {
  require_once 'api/auth/LogoutUser.php';
  require_once 'api/DB.php';
  LogoutUser('login.php', $db, $_SESSION['token']);
}
require_once 'api/auth/AuthCheck.php';
AuthCheck('', 'login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/modules/micromodal.css">
</head>
<body>
    <header class="header">
        <h2 class="modal__title" id="modal-1-title">
            История заказов
        </h2>
        <button onclick="MicroModal.show('modal-1')"><img src="images/pn.png" class="im"></button>
        <small>Фамилия Имя Отчество</small>
        <button class="modal__close" aria-label="Close-modal" data-micromodal-></button>
        </header>
        <main class="modal__content" id="modal-1-content">
            <div class="order">
                <div class="order__info">
                    <h3 class="order__number">Заказ №1</h3>
                    <time class="order__date">Дата оформления : 2025-01-13 09:25</time>
                    <p clas="order__total">Общая сумма : 300.00</p>
                </div>
                <ul class="order__list"></ul>
            </div>
        <div class="container">
            <p class="header__admin">Фамилия Имя Отчество</p>
            <?php
            require 'api/DB.php';
            require_once 'api/clients/AdminName.php';
            echo AdminName($_SESSION['token'], $db);
            ?>
            <ul class="header__links">
                <li><a href="">Клиенты</a></li>
                <li><a href="">Товары</a></li>
                <li><a href="">Заказы</a></li>
                <li><a href="?do=logout" class="header_logout">Выйти</a></li>
            </ul>
            <h2>Список клиентов</h2>
            <button class="clients__add">
                <i class="fa fa-plus-circle">
                    
                </i>
            </button>
            <table class="order__items">
                <tr>
                    <th>ИД</th>
                    <th>ФИО клиента</th>
                    <th>дата заказа</th>
                    <th>цена</th>
                    <th>название</th>
                    <th>количество</th>
                    <th>цена</th>
                    <!-- <th>Редактировать</th> -->
                    <input type="submit" value="Редактировать" class="redirect">
                    <th>Удалить</th>
                </tr>
                <tbody>
                  <td>
                  <?php
                  require 'api/DB.php';
                  require_once('api/clients/OutputClients.php');
                     $output = $db->query("SELECT `id`, `client_id`, `order_date`, `total` FROM orders")->fetchAll();
                     $output_clients = $db->query("SELECT `id`, `name` FROM clients")->fetchAll();
                     $output_products = $db->query("SELECT `id`, `name`, `stock`, `price` FROM products")->fetchAll();
                  foreach($output as $key => $value){
                    echo      "
                    <tr>
                    <td>$value[id]</td>
                ";
            
                foreach($output_clients as $key2 => $value2) {
                  //if($value['client_id'] === $value2['id']) {
               if($value['client_id'] === $value2['id']) {
                echo      "            
                <td>$value2[name]</td>
                <td>$value[order_date]</td>
            ";
               }
                foreach($output_products as $key3 => $value3) {
                  if($value['client_id'] && $value2['id']) {
            echo      "
            <td>$value3[price]</td>
             </tr>
         ";
                  }
              }                             
                  }      
                }
                ?>
                </td>
                </tbody>
            </table>
                    <!-- <input type="submit" value="Редактировать"> -->
        </div>
        <div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                  <h2 class="modal__title" id="modal-1-title">
                    Micromodal
                  </h2>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                  <!-- <p>
                    Try hitting the <code>tab</code> key and notice how the focus stays within the modal itself. Also, <code>esc</code> to close modal.
                  </p> -->
                  <form class="form">
                    <label for="FIO">ФИО</label>
                    <input type="text">
                    <label for="email" class="mail">Почта</label>
                    <input type="text" class="te">
                    <label for="phone">Телефон</label>
                    <input type="text">
                    <label for="birthday" class="bir">День рождения</label>
                    <input type="text" class="birth">
                    <button type="submit">Создать</button>
                    <button type="submit">Отменить</button>
                </form>
                </main>
                <footer class="modal__footer">
                </footer>
              </div>
            </div>
          </div>
        <script defer
        src="https://unpkg.com/micromodal/dist/micromodal.min.js"
        ></script>
        <script defer src="initClientsModal.js"></script>
    </main>
</body>
</html>