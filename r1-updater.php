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

echo "secret";
if (!isset($_POST['data'])) {
  die;
}
else echo "data !!\n";
var_dump($_POST['data']);

require("./connetion.php");
$stmt = $pdo->prepare('SELECT * FROM 123');
$stmt->execute();
var_dump($stmt);
?>