<?php
// api.radiology.link/library/?do= /
require_once("DBC.php");     
header('Access-Control-Allow-Origin:*');
$do = "";
if(isset($_GET["do"]))
    $do = $_GET["do"];
/*
 * RESTful service 控制器
 * URL 映射 Version 0.3
*/

switch($do){
 
    case "get":
        // 处理 Get /
        $DBC = new DBC();
        $DBC->get();
    break;

    case "upload":
        // 处理 upload /
        $user = $_GET["user"];
        $time = $_GET["time"];
        $price = $_GET["price"];
        $status = $_GET["status"];
        $auth = $_GET["auth"];
        $broker = $_GET["broker"];
        $DBC = new DBC();
        $DBC->upload($user,$time,$price,$status,$auth,$broker);
    break;
    
    case "landing":
        $user = $_GET["user"];
        $DBC = new DBC();
        $DBC->landing($user);
    break;
}
?>