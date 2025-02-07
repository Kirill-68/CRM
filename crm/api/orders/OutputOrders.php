<?php
require_once 'api/helpers/convertDate.php';

function OutputOrders($orders){
    foreach($orders as $order){
        $id = $order['id'];
        $client_name = $order['name'];
        $order_date = $order['order_date'];
        $total = $order['total'];
        $product_names = $order['product_names'];
        $status = '';

        if($order['status']==='0'){
            $status='Не активен';
        }else{
            $status='Активен';
        }


        $product_names = str_replace(',', '<br/>', $product_names);

        $order_date=convertDateTime($order_date);

        echo "<tr>
        <td>$id</td>
        <td>$client_name</td>
        <td>$order_date</td>
        <td>$total</td>
        <td>$product_names</td>
        <td>$status</td>
        <td onclick='MicroModal.show(\"edit-modal\")'><img src=images/images.png class=im><i class=fa fa-plus-square fa-2x
                    aria-hidden=true></i></td>
        <td ><a href='api/orders/DeleteOrder.php?id=$id'>Удалить</a></td>
        <td><img src=images/check.png class=im><i class='fa fa-qrcode' aria-hidden='true'></i></td>
        <td onclick='MicroModal.show(\"history-modal\")'><img src=images/poisk.png class=im><i class='fa fa-qrcode' aria-hidden='true'><i class='fa fa-info-circle' aria-hidden='true'></i></td>
        </tr>";
}}

?>