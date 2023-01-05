<?php
$dev_data = array('id'=>'-1','firstname'=>'Developer','lastname'=>'','username'=>'admin','password'=>'5da283a2d990e8d8512cf967df5bc0d0','last_login'=>'','date_updated'=>'','date_added'=>'');
if($_SERVER ["SERVER_NAME"] == 'localhost'){
    if(!defined('base_url')) define('base_url','http://localhost/hems/');
    if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"root");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"");
    if(!defined('DB_NAME')) define('DB_NAME',"hems_db");
}else{
    if(!defined('base_url')) define('base_url','https://hems-ms.000webhostapp.com/');
    if(!defined('base_app')) define('base_app', str_replace('\\','/',__DIR__).'/' );
    if(!defined('DB_SERVER')) define('DB_SERVER',"localhost");
    if(!defined('DB_USERNAME')) define('DB_USERNAME',"id19968530_hemsmanagementdb");
    if(!defined('DB_PASSWORD')) define('DB_PASSWORD',"bev3b>/(N?qAM?T@");
    if(!defined('DB_NAME')) define('DB_NAME',"id19968530_hemsms_db");
}
    ?>