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
    <link rel="stylesheet" href="login.css">
    <script defer 
   src="https://unpkg.com/micromodal/dist/micromodal.min.js">
  </script>

  <script defer src="initClientsModal.js"> </script>
</head>
<body>
    <header class="header">
        <h2 class="modal__title" id="modal-1-title">
            История заказов
        </h2>
        <button onclick="MicroModal.show('add-modal')"><img src="images/pn.png" class="im"></button>
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
            <h2>Список заказов</h2>
            <button class="clients__add">
                <i class="fa fa-plus-circle">
                    
                </i>
            </button>
            <table class="order__items">
                <tr>
                    <th>ИД</th>
                    <th>ФИО клиента</th>
                    <th>Дата заказа</th>
                    <th>Сумма</th>
                    <th>Состав заказа</th>
                    <th>Чек</th>
                    <th>Редактировать</th>
                    <input type="submit" value="Редактировать" class="redirect">
                    <th>Удалить</th>
                </tr>
                <tbody>
                  <td>
                  <?php
                  require 'api/DB.php';
                  require_once('api/clients/OutputClients.php');
                  require_once('api/clients/OutputClients.php');
                     require_once 'api/clients/ClientsSearch.php';
                    $orders= $db->query("
                    SELECT
                    orders.id,
                    clients.name,
                    orders.order_date,
                    orders.total,
                    GROUP_CONCAT(CONCAT(products.name,
                    ' ( ',order_items.quantity,'шт. : ',products.price,')'
                    ) SEPARATOR ', ') AS product_names
                     FROM
                     orders
                     JOIN
                     clients ON orders.client_id = clients.id
                     JOIN
                     order_items ON orders.id = order_items.order_id
                     JOIN
                     products ON order_items.product_id = products.id
                     GROUP BY
                     orders.id, clients.name, orders.order_date, orders.total;
                     ")->fetchAll();
                     foreach ($orders as $key => $order) {
                          $id = $order['id'];
                          $name = $order['name'];
                          $date = $order['order_date'];
                          $sum = $order['total'];
                          $details = $order['product_names'];
                      echo "
                      <tr>
                        <th>$id</th>
                        <th>$name</th>
                        <th>$date</th>
                        <th>$sum</th>
                        <th>$details</th>
                        <th><button type=submit style='height:50px; width:50px'> <img src=images/check.png style=width:50px alt=1></button></th>
                        <th><button type=submit style='height:50px; width:50px'> <img src=images/images.png style=width:50px alt=1></button></th>
                        <th><button type=submit style='height:50px; width:50px'> <img src=images/w.png style=width:50px alt=1></button></th>
                    </tr>";
                     }
                ?>
                </td>
                </tbody>
            </table>
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
        <form action="api/product/AddProduct.php" method="POST" id="client-form">
        <action class = "main_filters">
          <div class="form-group">
            <label for="full-name">Название</label>
            <input type="text" id="full-name" name="name" required placeholder="Введите название товара">
          </div>
          <div class="form-group">
            <label for="email">Описание</label>
            <input type="text" id="email" name="description" required placeholder="Введите описание товара">
          </div>
          <div class="form-group">
            <label for="price">Цена</label>
            <input type="text" id="price" name="price" required placeholder="Введите цену товара">
          </div>
          <div class="form-group">
            <label for="stock">Количество</label>
            <input type="text" id="stock" name="stock" required placeholder="Введите цену товара">
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-create">Добавить</button>
            <button type="button" class="btn-cancel" data-micromodal-close>Отменить</button>
          </div>
        </form>
      </main>
    </div>
  </div>
</div>
<div class="modal micromodal-slide" id="delete-modal" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
      <header class="modal__header">
        <h2 class="modal__title" id="modal-1-title">
          Удалить клиента
        </h2>
        <button onclick="MicroModal.show('add-modal')"><img src="images/pn.png" class="im"></button>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="modal-1-content">
        <button>Удалить</button>
        <button onclick="MicroModal.close('delete-modal');" > Отменить</button>
      </main>
    </div>
  </div>
</div>
<div class="modal micromodal-slide" id="edit-modal" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
      <header class="modal__header">
        <h2 class="modal__title" id="modal-1-title">
          Редактировать товар
        </h2>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
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
        <form class="modal_form">
        <action class = "main_filters">
                    <div class="container">
                    </div>
                  <form class="form">
                    <label for="FIO">ФИО</label>
                    <input type="text" name = "name">
                    <label for="email" class="mail">Почта</label>
                    <input type="text" name="email" class="te">
                    <label for="phone">Телефон</label>
                    <input type="text" name="phone">
                    <label for="birthday" class="bir">День рождения</label>
                    <input type="text" name="birthday" class="birth">
                    <button type="submit">Создать</button>
                    <button type="submit">Отменить</button>
                </form>
          <div class="form-actions">
            <button type="submit" class="btn-create">Редактировать</button>
            <button type="button" class="btn-cancel" data-micromodal-close>Отменить</button>
          </div>
        </form>
      </main>
      <footer class="modal__footer">
                </footer>
              </div>
            </div>
          </div>
          <div class="modal micromodal-slide <?php if(isset($_SESSION['product_errors']) && !empty($_SESSION['product_errors'])) {echo 'open';} ?>" id="error-modal" aria-hidden="true">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                  <h2 class="modal__title" id="modal-1-title">
                    Ошибка
                  </h2>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                  <?php
                  if(isset($_SESSION['product_errors']) && !empty($_SESSION['product_errors'])) {
                    echo $_SESSION['product_errors'];
                   //require_once 'api/clients/AddClients.php';
                 
                    $_SESSION['product_errors'] = '';
                  }
                  ?>
                </main>
    </div>
  </div>
</div>


  </main>
  <div class="modal micromodal-slide" id="add-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
          <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
              <h2 class="modal__title" id="modal-1-title">
                Создание заказа
              </h2>
              <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <form action="api/orders/AddOrders.php" method="POST" class="modal__form">
                    <div class="modal__form-group">
                        <label for="client">Клиент</label>
                        <select class="main__select" name="client" id="client">
                            <?php
                            $DB = new PDO(
                              'mysql:host=localhost;dbname=crm;charset=utf8', 
                              'root', 
                              null, 
                              [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ],
                          );
                          
                                $users = $DB->query("SELECT id, name FROM clients")->fetchAll();
                                foreach ($users as $key => $user) {
                                    $id = $user['id'];
                                    $name = $user['name'];
                                    echo "<option value='$id'>$name</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="modal__form-group">
                        <label for="products">Товар</label>
                        <select class="main__select" name="products" id="products" multiple>
                        <?php
                                $products = $DB->query("SELECT id, name, price, stock FROM products WHERE stock > 0")->fetchAll();
                                foreach ($products as $key => $product) {
                                    $id = $product['id'];
                                    $name = $product['name'];
                                    $price = $product['price'];
                                    $stock = $product['stock'];
                                    echo "<option value='$id'>$name - {$price}₽ - ({$stock} шт.)</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="modal__form-actions">
                        <button type="submit" class="modal__btn modal__btn-primary">Создать</button>
                        <button type="button" class="modal__btn modal__btn-secondary" data-micromodal-close>Отменить</button>
                    </div>
                </form>
            </main>
          </div>
        </div>
      </div>
      <div class="modal micromodal-slide
        <?php
        if (isset($_SESSION['orders_error']) && 
        !empty($_SESSION['orders_error'])) {
            echo 'open';
        }
        ?>
    " id="error-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                        Ошибка!
                    </h2>   
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                <?php
                if (isset($_SESSION['orders_error'])
                && !empty($_SESSION['orders_error'])) {
                    echo $_SESSION['orders_error'];

                    $_SESSION['orders_error'] = '';
                }
                ?>
                </main>
            </div>
        </div>
    </div>
</body>
</html>