<?php
include '../vendor/autoload.php';
use \Firebase\JWT\JWT;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

ini_set('error_log', 'log.txt');
error_reporting(E_ERROR);
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Colombo');

include_once '../constants.php';
include_once '../database.php';

$time = date("y-m-d H:i:s");
$jsonData = file_get_contents('php://input');
$db = new database();

$response = array('statusCode'=> '','error' => '');
$token = null;

$headers = apache_request_headers();
if(isset($headers['Authorization'])){
   $matches = array();
   preg_match('/Bearer (.*)/', $headers['Authorization'], $matches);
   if(isset($matches[1])){
      $token = $matches[1];
   }
}

if($token != null){
   //echo $token;
   $data = readToken($token, $publicKey);

   $id = $data['id'];
   $tele = $data['tele'];

   $in = json_decode($jsonData, true);

   if(isset($in['old'])==false){
      $response['statusCode'] = 'E1100';
      $response['error'] = 'old password not found !';

   }else if(isset($in['new'])==false){
      $response['statusCode'] = 'E1100';
      $response['error'] = 'new password not found !';

   }else{

      $old = $db->mysqlSafe($in['old']);
      $new = $db->mysqlSafe($in['new']);

      $pwNew =sha1(md5($new).$tele);
      $pwOld =sha1(md5($old).$tele);
      //$original = $db->getCustomerData($id, "password");

      $isOldMatch = $db->verifyUser("phone", $tele,  $pwOld);

      if($isOldMatch==1){
         // Apply new password

         if($db->updatePassword($id, $pwNew)){
            $response['statusCode'] = 'S1000';
         }else{
            $response['statusCode'] = 'E4010';
            $response['error'] = 'Database Error';
         }
      }else{
         $response['statusCode'] = 'E4011';
         $response['error'] = 'Previous password is Invalid !';
      }
   }
}else{
   // No auth header
   $response['statusCode'] = 'E1000';
   $response['error'] = 'No authentication header found';
}



/*$tele = $db->mysqlSafe($in['phoneNo']); //substr($db->mysqlSafe($in['phoneNo']), 2);
$email =  $db->mysqlSafe($in['email']);

if($tele=="null"){
// Login by email
$response['statusCode'] = 'E4002';
$response['error'] = 'Incorrect Username or Password';

if ($email!="null" &&  $db->existCustomer_byEmail($email)==false){
$response['statusCode'] = 'E4003';
$response['error'] = 'Incorrect Username or Password';

}else{
$id = $db->getCustomerId_byEmail($email);
$tele = $db->getCustomerData($id, "phoneNo");
$address = array(
"address1"=>$db->getCustomerData($id, "address1"),
"address2"=>$db->getCustomerData($id, "address2"),
"city"=>$db->getCustomerData($id, "city"),
"municipalCouncil"=>$db->getCustomerData($id, "municipalCouncil"),
);
$pw =sha1(md5($db->mysqlSafe($in['password'])).$tele);

$res = $db->verifyUser("email", $email,  $pw);

if($res==1){
$response['statusCode'] = 'S2000';
$response['error'] = '';
$response['authToken'] = getToken($id, $tele,$privateKey);
$response['userId'] = $id;
$response['email'] = $email;
$response['phone'] = $tele;
$response['address'] = $address;
}else{
$response['statusCode'] = 'E4005';
$response['error'] = 'Incorrect Username or Password';
}
}

}else if($email=="null"){
// Login by tele
if($tele!="null" && $db->existCustomer($tele)==false){
$response['statusCode'] = 'E4001';
$response['error'] = 'Incorrect Username or Password';

}else{

$id = $db->getCustomerId_byTele($tele);
$email = $db->getCustomerData($id, "email");
$address = array(
"address1"=>$db->getCustomerData($id, "address1"),
"address2"=>$db->getCustomerData($id, "address2"),
"city"=>$db->getCustomerData($id, "city"),
"municipalCouncil"=>$db->getCustomerData($id, "municipalCouncil"),
);
$pw =sha1(md5($db->mysqlSafe($in['password'])).$tele);

$res = $db->verifyUser("phone", $tele,  $pw);

if($res==1){
$response['statusCode'] = 'S2000';
$response['error'] = '';
$response['authToken'] = getToken($id, $tele,$privateKey);
$response['userId'] = $id;
$response['email'] = $email;
$response['phone'] = $tele;
$response['address'] = $address;

}else{
$response['statusCode'] = 'E4004';
$response['error'] = 'Incorrect Username or Password';
}
}

}else{
$response['statusCode'] = 'E4006';
$response['error'] = 'Incorrect Username or Password';
}
}
*/


$resp = json_encode($response);
echo $resp;

function getToken($id,$tele, $pvtKey){
   $payload = array("id" => $id,"tele" => $tele);
   $jwt = JWT::encode($payload, $pvtKey, 'RS256');
   //print($jwt);
   return $jwt;
}

function readToken($token, $pubKey){
   $decoded = JWT::decode($token, $pubKey, array('RS256'));
   //print_r((array) $decoded);
   return (array) $decoded;
}
?>
