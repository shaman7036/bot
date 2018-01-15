<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'on');
function require_auth() {
  $AUTH_USER = 'admin';
  $AUTH_PASS = 'qwe123';
  header('Cache-Control: no-cache, must-revalidate, max-age=0');
  $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
  $is_not_authenticated = (
    !$has_supplied_credentials ||
    $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
    $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
  );
  if ($is_not_authenticated) {
    header('HTTP/1.1 401 Authorization Required');
    header('WWW-Authenticate: Basic realm="Access denied"');
    echo "no access";
    
    exit;
  }
}
require_auth();
if (!isset($_POST['data'])) {
  die;
}
else echo "data !!\n";
var_dump($_POST['data']);

//id|visits_left|deposit_account|last_visit|phone_number
//OID = id
//??? = visits_left
//??? = deposit_account
//LastVisitDateTime = last_visit
//TelefoneCell = phone_number

$received_data = $_POST['data'];
$arr = [];
foreach(preg_split("/((\r?\n)|(\r\n?))/", $received_data) as $line){
  $arr[] = split("\|", $line);
} 
 var_dump($arr);

// require("./connection.php");
// $stmt = $pdo->prepare("INSERT INTO  `user_data` (phone_number) VALUES (:phone_number)");
// $stmt->bindParam(':phone_number', $_POST['data']);
// $stmt->execute();
// var_dump($stmt);
?>