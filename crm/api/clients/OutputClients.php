<?php
function OutputClients($clients) {
    require 'api/DB.php';
    $clients = $db->query("SELECT `id`, `name`, `email`, `phone`, `birthday`, `created_at` FROM clients")->fetchAll();
                  foreach($clients as $key => $value){
                    echo      "<tr>
                    <td>$value[id]</td>
                    <td>$value[name]</td>
                    <td>$value[email]</td>
                    <td>$value[phone]</td>
                    <td>$value[birthday]</td>
                    <td>$value[created_at]</td>
                </tr>";
                  }
}
?>