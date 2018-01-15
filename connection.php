<?php 
$config = require('./config.php');
$user = $config['dbname'];
$pass = $config['username'];
$dbname = $config['pass'];

var_dump($user);
var_dump($pass);
var_dump($dbname);
try {
    $dbh = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    die(json_encode(array('outcome' => true)));
}
catch(PDOException $ex){
  var_dump($ex);
  die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}
?>