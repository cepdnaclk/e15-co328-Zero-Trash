<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

ini_set('error_log', 'log.txt');
error_reporting(E_ERROR);
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Colombo');

include_once '../constants.php';
include_once '../database.php';

$time = date("y-m-d H:i:s");
$jsonData = file_get_contents('php://input');
$db = new database();

/*** Error Map *********************

* S1000 -> Success
* E2001 -> Access Token can't be empty
* E2002 -> Invalid Access Token

************************************/

/*

POST: http://collector.ceykod.com/api/v1/verifyToken/
Content-Type: application/json

{
"accessToken": "f83bdbecf8f2596cfd837b11ab2aa1fb",
"userToken": "123458",
"userTele": "94778891312"
}

*/

// Reading data from php input, can do some validation here
$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);

$correctAccessToken = "f83bdbecf8f2596cfd837b11ab2aa1fbdzgknzlskg";

// Validation
if (!isset($in['accessToken'])) {
   $resp = array("statusCode" => "E2001", "statusDetail" => "Access Token can't be empty");

} else if (!isset($in['userToken'])) {
   $resp = array("statusCode" => "E3001", "statusDetail" => "User Token can't be empty");

} else if (!isset($in['userTele'])) {
   $resp = array("statusCode" => "E4001", "statusDetail" => "User telephone can't be empty");

} else if ($in['accessToken'] != $correctAccessToken){
   $resp = array("statusCode" => "E2002", "statusDetail" => "Invalid Access Token");

} else if($db->userId_Exist($in['userToken']) == false){
   $resp = array("statusCode" => "E3002", "statusDetail" => "Token not exists");

} else {
   // A valid user token
   $userToken = $in['userToken'];
   $userTele = $in['userTele'];
   $address = $db->get_Address_ById($userToken);
   $res = $db->set_UserTele($address, $userTele);

   if($res==1){
      // User's telephone updated success

      $resp = array("statusCode" => "S1000", "statusDetail" => "Success");
   }
}

// send response as json array


$resp = json_encode($resp);
echo $resp;

?>
