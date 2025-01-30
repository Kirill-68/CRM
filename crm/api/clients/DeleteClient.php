<?php
require_once '../DB.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
        $delete = $db->query("DELETE FROM `clients` WHERE id='$id'")->fetchAll();
        header('Location: ../../clients.php');
}
else{
    header('Location: ../../clients.php');
}
?>