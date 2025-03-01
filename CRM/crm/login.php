<?php
session_start();
require_once 'api/auth/AuthCheck.php';
AuthCheck('clients.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/settings.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form action="api/auth/AuthUser.php" method="POST" class="login">
            <label for="login" name="login" class="log">Логин</label>
            <input type="text" name="label">
            <p class="login_error">
                <?php
                if(isset($_SESSION['login-errors'])) {
                    $errors = $_SESSION['login-errors'];
                    echo isset($errors['login']) ? $errors['login'] : '';
                }
                ?>
            </p>
            <label for="password" name="password">Пароль</label>
            <input type="text" name="password">
            <p class="password_error">
                <?php
            if(isset($_SESSION['password-errors'])) {
                    $errors = $_SESSION['password-errors'];
                    echo isset($errors['password']) ? $errors['password'] : '';
                }
                ?>
                </p>
            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>