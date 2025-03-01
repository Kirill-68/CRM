<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
    $fields = ['name', 'email', 'phone', 'birthday'];
    $errors = [];
    $_SESSION['clients_errors'] = '';
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
        $_SESSION['clients_errors'] = $e;
        header('Location: ../../clients.php');
        exit;
    }
    require_once '../DB.php';
    $phone = $formData['phone'];
    $userID = $db->query("
    SELECT id FROM clients WHERE phone='$phone'
    ")->fetchAll();

    echo json_encode($userID);
    if(!empty($userID)){
        $_SESSION['clients_errors'] = 'Такой пользователь существует';
        header('Location: ../../clients.php');
        exit;
    }
    $stmt = $db->prepare("insert into clients(`name`, `email`, `phone`, `birthday`) values(?,?,?,?)");   
   $stmt->execute([
    $formData['name'],
         $formData['email'],
         $formData['phone'],
         $formData['birthday']
   ]);
}
else {
    echo json_encode([
        "error" => 'Неверный запрос'
    ]);
}