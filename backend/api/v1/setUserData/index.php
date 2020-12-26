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
$in = json_decode($jsonData, true);

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

      if(isset($in['firstName'])==false){
         $response['statusCode'] = 'E1100';
         $response['error'] = 'firstName not found !';

      }else if(isset($in['lastName'])==false){
         $response['statusCode'] = 'E1100';
         $response['error'] = 'lastName not found !';

      }else if(isset($in['address1'])==false){
         $response['statusCode'] = 'E1100';
         $response['error'] = 'address1 not found !';

      }else if(isset($in['address2'])==false){
         $response['statusCode'] = 'E1100';
         $response['error'] = 'address2 not found !';

      }else if(isset($in['city'])==false){
         $response['statusCode'] = 'E1100';
         $response['error'] = 'city not found !';

      }else if(isset($in['municipalCouncil'])==false){
         $response['statusCode'] = 'E1100';
         $response['error'] = 'municipalCouncil not found !';

      //}else if(isset($in['language'])==false){
      //   $response['statusCode'] = 'E1100';
      //   $response['error'] = 'language not found !';

      }else{
         $fName = $db->mysqlSafe($in['firstName']);
         $lName = $db->mysqlSafe($in['lastName']);
         $addrL1 = $db->mysqlSafe($in['address1']);
         $addrL2 = $db->mysqlSafe($in['address2']);
         $city = $db->mysqlSafe($in['city']);
         $municiple = $db->mysqlSafe($in['municipalCouncil']);
         $lang = $db->mysqlSafe(strtolower($in['language']));

         if($db->updateCustomer($id, $addrL1, $addrL2, $city, $municiple, $lang) && $db->updateRegularCustomer($id, $fName, $lName)){
            $response['statusCode'] = 'S1000';
            $response['error'] = 'Success';
         }else{
            $response['statusCode'] = 'E1002';
            $response['error'] = 'Database Error !';
         }
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
