<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require('./connection.php');
$phone = "375257370647";
$stmt = $pdo->prepare("SELECT * FROM users WHERE TelefoneCell like '%$phone' limit 1");
$stmt->execute();
$user=$stmt->fetchAll()[0];
$response="Пользователь".$user["Name"];
echo "$response";
?>