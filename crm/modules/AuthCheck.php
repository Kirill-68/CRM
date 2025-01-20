<?php
function AuthCheck($successPath = '', $errorPath = '') {
    require_once 'DB.php';
    $_SESSION['token'] = '1737338754';
    if(!isset($_SESSION['token']) && $errorPath){
        header("Location: $errorPath");
        return;
    }
    $token = $_SESSION['token'];
    $adminID = $db->query(
        "SELECT id FROM users WHERE token='$token'
        ")->fetchAll();
        echo json_encode($adminID);
        if(empty($adminID) && $errorPath){
            header("Location: $errorPath");
        }
        if(!empty($adminID) && $successPath){
            header("Location: $successPath");
        }
}
?>