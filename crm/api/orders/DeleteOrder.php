<?php
require_once '../DB.php';

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
//нужно вместо удаления сделать смену статуса на 0 
    $db->query("UPDATE orders SET status='0' WHERE id='$id'")->fetchAll();

    header('Location: ../../orders.php');
}else{
    header('Location: ../../orders.php');
}

?>