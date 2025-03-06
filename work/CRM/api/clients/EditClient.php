<?php
require_once '../DB.php';
echo json_encode($_POST);
if(!empty($_POST['name']) || !empty($_POST['email']) || !empty($_POST['phone'])){
    $id = [
        'name'=>$_POST['fullname'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
    ];
                    $SE =  $DB->query("SELECT `id` FROM clients WHERE id='$id[name]' && id='$id[email]' && id='$id[phone]'")->fetchAll();
                    foreach($SE as $key3 => $value3){
                        $date = $DB->query("SELECT `name`, `email`, `phone` FROM clients WHERE id='$value3[id]'")->fetchAll();
    $up = $DB->query("SELECT `name`, `email`, `phone` FROM clients WHERE name!='$_POST[fullname]' || email!='$_POST[email]' || phone!='$_POST[phone] && id=$value3[id]'")->fetchAll();
    foreach($up as $key2 => $value2){
        $up2 = $DB->query("UPDATE clients SET `name`='$value2[name]', `email`='$value2[email]', `phone`='$value2[phone]'")->fetchAll();
        // if($value2['name'] !== $_POST['fullname'] && $value2['email'] !== $_POST['email'] && $value2['phone'] !== $_POST['phone']){
foreach($up2 as $key => $value){
    $name -> $value['name'];   
    $email -> $value['email'];
    $phone -> $value['phone'];
}
}
    }
}
// else{
//     $name ->$_POST['name']  ;
//     $email -> $_POST['email'];
//     $phone-> $_POST['phone'];
// }
//}
?>