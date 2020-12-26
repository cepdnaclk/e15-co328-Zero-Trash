<?php

include '../vendor/autoload.php';
use \Firebase\JWT\JWT;

include_once '../constants.php';
include_once '../database.php';
include_once './pickupDB.php';

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
$db = new database();
$response = array('statusCode'=> '','error' => '');

$token = getToken($publicKey);

if($token==0){
   // Invalid token
   $response['statusCode'] = "E1000";
   $response['error'] = "Invalid Token";

}else if(isset($_GET['page'])){
   $page = str_replace("/", "", $_GET['page']);

   if($page=="new"){
      include 'new.php';

   }else if($page=="delete"){
      include 'delete.php';

   }else if($page=="list"){
      include 'list.php';

   }else if($page=="rate"){
      include 'rating.php';

   }else{
      //echo "else";
   }

}else{

}

$resp = json_encode($response);
echo $resp;


function getToken($pubKey){

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
   if($token==null){
      return 0;
   }
   //print($token);
   $data = readToken($token, $pubKey);
   //print_r($data);

   return $data;
}


function readToken($token, $pubKey){

   $decoded = JWT::decode($token, $pubKey, array('RS256'));
   //print_r((array) $decoded);
   return (array)$decoded;
}

?>
