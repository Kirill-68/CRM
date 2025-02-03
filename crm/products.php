<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>CRM | Товары</title>
    <link rel="stylesheet" href="styles/modules/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/settings.css">
    <link rel="stylesheet" href="styles/pages/clients.css">
    <link rel="stylesheet" href="styles/modules/micromodal.css">
    <link rel="stylesheet" href="clients.css">
</head>
<body>
<header class="header">
<div class="container">
    <p>Фамилия Имя Отчество</p>
     <ul> 
        <li><a href="">Клиенты</a></li>
        <li><a href="">Товары</a></li>
        <li><a href="">Заказы</a></li>
     </ul>
     <a class="header_logout" href="">Выйти</a> 
</div>
</header>
<main>
    <section class="filters">
        <div class="container">
            <form action="">
                <label for="search">Поиск товара по названию</label>
                <input type="text" id="search" name="search" placeholder="Введите название" required>
                <label for="search">Сортировка по названию</label>
                <select name="sort" id="sort">
                    <option value="0">По возрастанию</option>
                    <option value="1">По убыванию</option>
                </select>
            </form>
        </div>
    </section>
    <section class="clients">
        <div class="container">
            <h2 class="clients_title">Список товаров</h2>
            <button onclick="MicroModal.show('add-modal')"><img src="images/pn.png" class="im"></button>
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </button>
            <table>
                <thead>
                    <th>ID</th>
                    <th>ФИО клиента</th>
                    <th>Дата заказа</th>
                    <th>Сумма</th>
                    <th>Состав заказа</th>
                    <th>Действия</th>
                </thead>
                <tbody>
                   <tr> <td>
                    <?php
                     require 'api/DB.php';
                     require_once('api/clients/OutputClients.php');
                     require_once 'api/clients/ClientsSearch.php';
                     $clients = ClientsSearch($_GET, $db);
                     $output = $db->query("SELECT `id`, `name` FROM clients")->fetchAll();
                     $orders = $db->query("SELECT `client_id`, `order_date`, `total` FROM orders")->fetchAll();
                     $products = $db->query("SELECT `id`, `name` FROM products")->fetchAll();
                  foreach($clients as $key => $value){
                    echo      "<tr>
                    <td>$value[id]</td>
                    <td>$value[name]</td>          
                ";
                foreach($orders as $key2 => $value2){
                if($value2['client_id'] === $value['id']){
                  echo      "
                  <td>$value2[order_date]</td>
                  <td>$value2[total]</td>
                  </tr>";
                }
              }
            }
                ?>
                    <td><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="MicroModal.show('edit-modal')"></i></td>
                    <td><i class="fa fa-trash-o" aria-hidden="true" onclick="MicroModal.show('delete-modal')"></i></td>
                    <td><i class="fa fa-qrcode" aria-hidden="true" onclick="MicroModal.show('qr-modal')"></i></td>
                  </tr>   
                </tbody>
            </table>
        </div>
    </section>
</main>

<div class="modal micromodal-slide" id="add-modal" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
      <header class="modal__header">
        <h2 class="modal__title" id="modal-1-title">
          Добавить товар
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
                  <!-- <p>
                    Try hitting the <code>tab</code> key and notice how the focus stays within the modal itself. Also, <code>esc</code> to close modal.
                  </p> -->
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
          <!-- <div class="form-group">
            <label for="full-name">Название</label>
            <input type="text" id="full-name" name="name" required placeholder="Введите название товара">
          </div>
          <div class="form-group">
            <label for="email">Описание</label>
            <input type="email" id="email" name="description" required placeholder="Введите описание товара">
          </div>
          <div class="form-group">
            <label for="phone">Цена</label>
            <input type="tel" id="phone" name="price" required placeholder="Введите цену товара">
          </div> -->
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

<!-- <div class="modal micromodal-slide" id="qr-modal" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-2-title">
      <header class="modal__header">
        <h2 class="modal__title" id="modal-2-title">
          Генерация QR-кода
        </h2>
        <small>Введите данные для QR-кода</small>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="modal-2-content">
        <form id="qr-form">
          <label for="qr-input">Данные для QR-кода:</label>
          <input type="text" id="qr-input" placeholder="Введите текст или URL" required>
          <button type="submit">Сгенерировать QR-код</button>
        </form>
        <div id="qr-code-container" style="margin-top: 20px;">
           Здесь будет отображаться сгенерированный QR-код 
        </div>
      </main>
    </div>
  </div>
</div> -->

<script defer 
   src="https://unpkg.com/micromodal/dist/micromodal.min.js">
  </script>

  <script defer src="initClientsModal.js"> </script>
  </main>
</body>
</html>