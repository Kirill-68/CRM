<?php
function OutputClients($clients) {
    require 'api/DB.php';
    $clients = $db->query("SELECT `id`, `name`, `email`, `phone`, `birthday`, `created_at` FROM clients")->fetchAll();
    function convertParams($arr){
      $params = [];
      foreach($arr as $key => $value){
        $copyParams = $_GET;
        $copyParams['send-email'] = $email;
        $queryParams = convertParams($copyParams);
        $params[] = "$key=$value";
      }
      return implode('&', $params);
    }
                  foreach($clients as $key => $value){
                    echo      "<tr>
                    <td>$id</td>
                    <td>$clients_name</td>
                    <td><a href='?$queryParams'>$email</td>
                    <td>$phone</td>
                    <td>$birthday</td>
                    <td>$created_at</td>
                </tr>";
                  }
}
?>