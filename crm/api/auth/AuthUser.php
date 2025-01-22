<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once '../DB.php';
    $login = isset($_POST['label']) ? $_POST['label'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $_SESSION['login-errors'] = [];
    $_SESSION['password-errors'] = [];
    if(!$login){
        $_SESSION['login-errors']['login'] = 'Field is required';
    }

    if(!$password){
        $_SESSION['password-errors']['password'] = 'Field is required';
    }

    if(!$login || !$password) {
        header('Location: ../../login.php');
        exit;
    }
    //$login = $_SESSION['label'];
    $loginID = $db->query(
        "SELECT id FROM users WHERE `login`='$login'
        ")->fetchAll();
        echo json_encode($loginID);
        if(empty($loginID)){
            $_SESSION['login-errors']['login'] = 'User not found';
            header('Location: ../../login.php');
            exit;
        }

        $passwordID = $db->query(
            "SELECT id FROM users WHERE `login`='$login' AND `password`='$password'
            ")->fetchAll();
            echo json_encode($passwordID);
            if(empty($passwordID)){
                $_SESSION['password-errors']['password'] = 'Wrong password';
                header('Location: ../../login.php');
                exit;
            }
            $uniquerString = time();
            $token = base64_encode("$login&password=$password&unique=$uniquerString");
            echo $token;
            $_SESSION['token'] = $token;
            $db->query("
            UPDATE users SET token = '$token'
            WHERE login = '$login' AND password = '$password'
            ")->fetchAll();
                header('Location: ../../clients.php');

echo json_encode($result);
    function clearData($input) {
        $cleaned = strip_tags($input);
        $cleaned = trim($cleaned);
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);
        return $cleaned;
        // $logi= str_replace([' '], '', $_POST['label']);
        // $p = str_replace([' '], '', $_POST['password']);
        // echo json_encode($logi, $p);
    }
    $login = clearData($login);
    $password = clearData($password);
    echo "Rabotaet";
}
else{
    echo json_encode([
        "error" => 'Неверный запрос',
    ]);
}
?>