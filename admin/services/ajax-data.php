<?php
require_once('../../config.php');
if(isset($_POST['type'])){
    $type = $conn->real_escape_string($_POST['type']);
    $value = $conn->real_escape_string($_POST['value']);
    if ($type == 'service'){
        $result = $conn->query("SELECT DISTINCT service_sub, `price` FROM `service_list` 
            where `service`='{$value}' AND delete_flag = 0 and `status` = 1 group by CONCAT(`service`,':',`service_sub`) order by `service_sub`");
        if ($result && $result->num_rows > 0){
                echo '<option value="Show All" >Show All</option>';
            while($row = $result->fetch_assoc()){
                echo '<option value="'.$row['service_sub'].'" data-price="'.$row['price'].'" >'.$row['service_sub'].'</option>';
            }
        }else
        echo '<option value="" ></option>';
    } 
}
?>