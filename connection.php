<?php 
$config = require('./config.php');
$user = $config['user'];
$pass = $config['pass'];
$dbname = $config['dbname'];

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