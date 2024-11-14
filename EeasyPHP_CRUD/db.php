<?php
$host = "localhost";
$db_name = "crud_api_db";
$user = "root";
$password = "0000";

try{
    $conn = new PDO("mysql:host=$host;dbname=$db_name",$user,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo"Connection failed: " . $e->getMessage();
}
?>