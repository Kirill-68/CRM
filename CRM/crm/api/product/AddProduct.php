<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
    $fields = ['name', 'description', 'price', 'stock'];
    $errors = [];
    $_SESSION['product_errors'] = '';
    foreach($fields as $key => $field) {
        if (!isset($_POST[$field]) || empty($_POST{$field})) {
            $errors[$field][] = 'Fiels is required';
        }
    }

    if(!empty($errors)) {
        $e = '';
        foreach($errors as $key => $field){
            $e = $e . "<p>$key : Fiels is required</p>";
        }
        $_SESSION['product_errors'] = $e;
        header('Location: ../../products.php');
        exit;
    }
    require_once '../DB.php';
    $name = $formData['name'];
    $userID = $db->query("
    SELECT id FROM products WHERE name='$name'
    ")->fetchAll();

    echo json_encode($userID);
    if(!empty($userID)){
        $_SESSION['product_errors'] = 'Такой пользователь существует';
        header('Location: ../../products.php');
        exit;
    }
    $stmt = $db->prepare("insert into products(`name`, `description`, `price`, `stock`) values(?,?,?,?)");   
   $stmt->execute([
    $formData['name'],
         $formData['description'],
         $formData['price'],
         $formData['stock']
   ]);
}
else {
    echo json_encode([
        "error" => 'Неверный запрос'
    ]);
}