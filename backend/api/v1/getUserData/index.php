<?php
include '../vendor/autoload.php';
use \Firebase\JWT\JWT;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

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
   }else{
   }
}

if($token != null){
   //echo $token;

   $data = readToken($token, $publicKey);

   $id = $data['id'];
   $tele = $data['tele'];

   if($db->getCustomerId_byTele($tele) == $id){

      $email = $db->getCustomerData($id, "email");
      $address = array(
         "address1"=>$db->getCustomerData($id, "address1"),
         "address2"=>$db->getCustomerData($id, "address2"),
         "city"=>$db->getCustomerData($id, "city"),
         /*"municipalCouncil"=>$db->getCustomerData($id, "municipalCouncil"),*/
      );

      $response['statusCode'] = 'S2000';
      $response['userId'] = $id;
      $response['email'] = $email;
      $response['phone'] = $tele;
      $response['address'] = $address;
      $response['language'] = ucfirst($db->getCustomerData($id, "language"));

      if($db->getCustomerData($id, "customerType")=="Regular Customer"){
         $response['firstName'] = $db->getRegularCustomerData($id, "firstName");
         $response['lastName'] = $db->getRegularCustomerData($id, "lastName");
      }

   }else{
      // Invalid token
      $response['statusCode'] = 'E1001';
      $response['error'] = 'Invalid access token';
   }
}else{
   // No auth header
   $response['statusCode'] = 'E1000';
   $response['error'] = 'No authentication header found';
}

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
   return (array)$decoded;
}
?>
