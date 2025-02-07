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
           <!-- <button onclick="MicroModal.show('add-modal')"><img src="images/pn.png" class="im"></button> -->
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
            <main>
        <section class="filters">
            <div class="container">
                <form action="" class="main__form">

                    <label for="search">Поиск по названию</label>
                    <input type="text" id="search" name="search" placeholder="Введите название" >
                    <label for="search">Сортировка</label>
                    <select name="search_name" id="sort">
                        <option value="clients.name">По клиенту</option>
                        <option value="orders.id">По Ид</option>
                        <option value="orders.order_date">По дате</option>
                        <option value="orders.total">По сумме</option>
                        <option value="orders.status">По статусу</option>
                    </select>
                    <label for="search">Сортировать </label>
                    <select name="sort" id="sort">
                        <option value="">По умолчанию</option>
                        <option value="ASC">По возрастанию</option>
                        <option value="DESC">По убыванию</option>
                    </select>
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="checkbox" name="checkbox" <?php echo isset($_GET['checkbox']) ? 'checked' : ''; ?>>
                        <label for="checkbox">Показать неактивные заказы</label>
                    </div>
                    <button type="submit">Поиск</button>
                    <a class="search" href="?" >Сбросить</a>
                </form>
            </div>
        </section>  
        <section class="orders">
            <h2 class="orders_title">Список товаров</h2>
            <button onclick="MicroModal.show('add-modal')" class="orders_add"><img src="images/pn.png" class="im"><i class="fa fa-plus-square fa-2x"
                    aria-hidden="true"></i></button>
            <div class="container">
                <table>
                    <thead>
                        <th>ИД</th>
                        <th>ФИО клиента</th>
                        <th>Дата заказа</th>
                        <th>Цена</th>
                        <th>Инфор. о заказе</th>
                        <th>Статус</th>
                        <th>Редак.</th>
                        <th>Удалить</th>
                        <th>Ген. чека</th>
                        <th>Подр.</th>
                    </thead>
                    <tbody>
                    <?php
                        require 'api/DB.php';
                        require_once 'api/orders/OutputOrders.php';
                        require_once 'api/orders/OrdersSearch.php';
                        // $orders = $db->query(
                        //      "SELECT orders.id, clients.name, orders.order_date, orders.total, 
                        //         GROUP_CONCAT(CONCAT(products.name, ' : ', order_items.price, ' : ', order_items.quantity, ' кол.') SEPARATOR ', ') AS product_names
                        //         FROM orders 
                        //         JOIN clients ON orders.client_id = clients.id 
                        //         JOIN order_items ON orders.id = order_items.order_id 
                        //         JOIN products ON order_items.product_id = products.id 
                        //         GROUP BY  orders.id, clients.name, orders.order_date, orders.total
                        // ")->fetchAll();
                        $orders = OrdersSearch($_GET,$db);
                        OutputOrders($orders);

                        ?>
                        <!-- <tr>
                            <td>0</td>
                            <td>Футболка</td>
                            <td>2024-01-12 15:20:22</td>
                            <td>1000.00</td>
                            <td>Заказ №1</td>
                            <td>10</td>
                            <td>10000.00</td>
                            <td onclick="MicroModal.show('edit-modal')"><i class="fa fa-pencil" aria-hidden="true"></i>
                            </td>
                            <td onclick="MicroModal.show('delete-modal')"><i class="fa fa-trash" aria-hidden="true"></i>
                            </td>
                            <td><i class="fa fa-qrcode" aria-hidden="true"></i></td>
                            <td onclick="MicroModal.show('history-modal')"><i class="fa fa-info-circle" aria-hidden="true"></i></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>
<main>
<div class="modal micromodal-slide" id="edit-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">
                        Редактировать заказ
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                  
                    <form id="registration-form">
                        <label for="name">Название:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="data">Дата заказа:</label>
                        <input type="data" id="data" name="data" required>

                        <label for="price">Цена:</label>
                        <input type="price" id="price" name="price" required>

                        <label for="stock">Количество:</label>
                        <input type="stock" id="stock" name="stock" required>

                        <button class="create" type="submit">Редактировать</button>
                        <button onclick="MicroModal.close('edit-modal')" class="cancel" type="button">Отмена</button>
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
                        Вы уверены, что хотите удалить заказ?
                    </h2>
                    <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <form id="registration-form">
                        <button class="cancel" type="submit">Удалить</button>
                        <button onclick="MicroModal.close('delete-modal')" class="create" type="button">Отмена</button>
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
<!-- <div class="modal micromodal-slide" id="edit-modal" aria-hidden="true">
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
          </div> -->
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
                        <select class="main__select" name="products[]" id="products" multiple>
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