<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = $_POST;
    $fields = ['name', 'email', 'phone', 'birthday'];
    $errors = [];
    $_SESSION['clients-errors'] = '';
    foreach($fields as $key => $field) {
        if (!isset($_POST[$field]) || empty($_POST{$field})) {
            $errors[$field][] = 'Fiels is required';
        }
    }
    if(!empty($errors)) {
        $_SESSION['clients-errors'] = json_encode($errors);
        header('Location: ../../clients.php');
        exit;
    }
    echo json_encode($errors);
}
else {
    echo json_encode([
        "error" => 'Неверный запрос'
    ]);
}