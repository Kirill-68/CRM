<?php
session_start();
require_once 'modules/AuthCheck.php';
AuthCheck('clients.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/settings.css">
    <link rel="stylesheet" href="styles/modules/pages/login.css">
</head>
<body>
    <div class="container">
        <form class="login">
            <label for="login" name="login" class="log">Логин</label>
            <input type="text" name="label">
            <label for="password" name="password">Пароль</label>
            <input type="text" name="password">
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>