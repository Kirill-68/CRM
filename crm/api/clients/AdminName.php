<?php
function AdminName($token, $db) {
    $user = $db->query("SELECT `name`, `surname` FROM users WHERE token='$token'")->fetchAll()[0];
    $name = $user['name'];
    $surname = $user['surname'];
    return "$name, $surname";
}
?>