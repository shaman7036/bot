<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'on');

$config = require('./../botconfig.php');
$user = $config['updater_user'];
$pass = $config['updater_pass'];

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
require('./connection.php');
//id|visits_left|deposit_account|last_visit|phone_number
//OID = id
//??? = visits_left
//??? = deposit_account
//LastVisitDateTime = last_visit
//TelefoneCell = phone_number

$received_data = trim($_POST['data']);
$arr = [];
foreach(preg_split("/((\r?\n)|(\r\n?))/", $received_data) as $line){
  $temparr = explode("|", $line);
  $arr[] = array(
    'OID' => $temparr[0],
    'Name' => $temparr[1],
    'LastName' => $temparr[2],
    'MiddleName' => $temparr[3],
    'LastVisitDateTime' => $temparr[4],
    'TelefoneCell' => $temparr[5]
    'Summ' => $temparr[6]
    'visits_left' => $temparr[7]
  );
} 
pdoMultiInsert('user', $arr, $pdo);
echo "done.";
// $stmt = $pdo->prepare("SELECT * FROM user_data WHERE phone_number= )");
// $stmt->execute();
// var_dump($stmt->fetchAll());


function pdoMultiInsert($tableName, $data, $pdoObject){
    
    //Will contain SQL snippets.
    $rowsSQL = array();
 
    //Will contain the values that we need to bind.
    $toBind = array();
    
    //Get a list of column names to use in the SQL statement.
    $columnNames = array_keys($data[0]);
 
    //Loop through our $data array.
    foreach($data as $arrayIndex => $row){
        $params = array();
        foreach($row as $columnName => $columnValue){
            $param = ":" . $columnName . $arrayIndex;
            $params[] = $param;
            $toBind[$param] = $columnValue; 
        }
        $rowsSQL[] = "(" . implode(", ", $params) . ")";
    }
 
    //Construct our SQL statement
    $sql = "REPLACE INTO `$tableName` (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
 
    //Prepare our PDO statement.
    $pdoStatement = $pdoObject->prepare($sql);
 
    //Bind our values.
    foreach($toBind as $param => $val){
        $pdoStatement->bindValue($param, $val);
    }
    
    //Execute our statement (i.e. insert the data).
    return $pdoStatement->execute();
}
?>