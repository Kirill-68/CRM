<?php session_start();
require_once '../DB.php';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $formData = $_POST;

    $fields = ['client','products'];
    $errors = [];

    $_SESSION['orders-errors']='';

    foreach($fields as $key => $field){
        if(!isset($_POST[$field]) || empty($_POST[$field])){
            $errors[$field][]= 'Field is required';
        }
    }

    if (!empty($errors)){
        $errorMessages = '<ul>';
        foreach ($errors as $key => $error) {
            $to_string = implode(',', $error);
            $errorMessages = $errorMessages . "<li>$key : $to_string </li>";
        }
        $errorMessages = $errorMessages . '</ul>';
        $_SESSION['orders-errors'] = $errorMessages;
        header('Location: ../../orders.php');
        exit;
    }
    $total =  $db->query("SELECT SUM(price) FROM products 
    WHERE id IN (" . implode(',', $formData['products']) . ")")->fetchColumn();

    $orders = [
        'id' => time(),
        'client_id' => $formData['client'],
        'total' => $total
    ];


    $db->prepare(
        "INSERT INTO `orders` (`id`, `client_id`, `total`) VALUES (?, ?, ?)"
    )->execute([
        $orders['id'],
        $orders['client_id'], 
        $orders['total']
    ]);
    // записать элементы заказа в orders_items order_id, product_id, quantity=1, price=цена продукта
    foreach ($formData['products'] as $key => $product) {
        $db->prepare(
            "INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) VALUES (?, ?, ?, ?)"
        )->execute([
            $orders['id'],
            $product,
            1,
            $db->query("SELECT price FROM products WHERE id = $product")->fetchColumn(),
        ]);
    }

    header('Location: ../../orders.php');

}else{
    echo json_encode(
        ["error"=> 'Неверный запрос']
    );
}

?>