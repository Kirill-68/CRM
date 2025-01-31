<?php
require_once '../DB.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
        $delete = $db->query("DELETE FROM `products` WHERE id='$id'")->fetchAll();
        header('Location: ../../products.php');
}
else{
    header('Location: ../../products.php');
}
?>