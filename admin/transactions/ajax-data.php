<?php
require_once('../../config.php');
if(isset($_POST['type'])){
    $type = $conn->real_escape_string($_POST['type']);
    $value = $conn->real_escape_string($_POST['value']);
    if ($type == 'service'){
        $result = $conn->query("SELECT DISTINCT CONCAT(`service`,':',`service_sub`) as code, service_sub, `price` FROM `service_list` 
            where `service`='{$value}' AND delete_flag = 0 and `status` = 1 group by CONCAT(`service`,':',`service_sub`) order by `service_sub`");
        if ($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<option value="'.$row['code'].'" data-price="'.$row['price'].'" >'.$row['service_sub'].'</option>';
            }
        }else
        echo '<option value="" ></option>';
    } else if ($type == 'service_sub'){
        $result = $conn->query("SELECT id, `cylinder`, `price` FROM `service_list` 
            where CONCAT(`service`,':',`service_sub`)='{$value}' AND delete_flag = 0 and `status` = 1 group by `id` order by `cylinder`");
        if ($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<option value="'.$row['id'].'" data-price="'.$row['price'].'" >'.$row['cylinder'].'</option>';
            }
        }else
        echo '<option value="" ></option>';
    } else if ($type == 'engine_model'){
        $id = $conn->real_escape_string($_POST['id']);
        $result = $conn->query("SELECT id, name, price
            , coalesce((SELECT COALESCE(SUM(i.quantity),0)- COALESCE(SUM(d.quantity),0) FROM `inventory_list` i LEFT JOIN `inventory_damaged` d ON d.product_id=i.product_id AND i.id=d.inventory_id where i.product_id = product_list.id),0) available
            , coalesce((SELECT SUM(tp.qty) FROM `transaction_products` tp 
                            inner join `transaction_list` tl on tp.transaction_id = tl.id 
                            where tp.product_id = product_list.id and tl.status != 3),0) used
            FROM `product_list` where engine_model='{$value}' AND delete_flag = 0 and `status` = 1 GROUP BY name HAVING available-used > 0 order by `engine_model`");
        if ($result && $result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<option value="'.$row['id'].'" data-price="'.$row['price'].'" >'.$row['name'].' @ ₱'.number_format($row['price'], 2).'</option>';
            }
        }else
        echo '<option value="" ></option>';
    }
}
?>