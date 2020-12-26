<?php

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

/*** Error Map *********************

* S1000 -> Success
* E2001 -> Access Token can't be empty
* E2002 -> Invalid Access Token

************************************/

/*
{
"firstName": "Ndgsdg",
"lastName": "shsdhsdhsfh",
"phoneNo": "778945612",
"email": "nuwanjaliyagoda@gmail.com",
"address1": "198/8, Kesselwatta Road",
"address2": "Sinhapitiya",
"city": "",
"regDate": "2020-04-11",
"password": "zaq1@shsdh",
"customerType": "Regular Customer",
"language": "english"
}
*/


// Reading data from php input, can do some validation here
$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);
$response = array('statusCode'=> '','error' => '');

if(isset($in['password'])==false){
   $response['statusCode'] = "E1000";
   $response['error'] = "Password can't be empty";

}else{

   $fName = $db->mysqlSafe($in['firstName']);
   $lName = $db->mysqlSafe($in['lastName']);
   $tele = $db->mysqlSafe($in['phoneNo']);
   $pw =sha1(md5($db->mysqlSafe($in['password'])).$tele);

   $email = $db->mysqlSafe($in['email']);
   $addrL1 = $db->mysqlSafe($in['address1']);
   $addrL2 = $db->mysqlSafe($in['address2']);
   $city = $db->mysqlSafe($in['city']);
   $municiple = $db->mysqlSafe($in['municipalCouncil']);
   $regDate = $db->mysqlSafe($in['regDate']);
   $type = $db->mysqlSafe($in['customerType']);
   $lang = $db->mysqlSafe($in['language']);

   if($db->existCustomer($tele)==false){
      $areaId = $db->getAreaId($municiple);
      $res = $db->newCustomer($tele, $email, $pw, $addrL1, $addrL2, $city, $areaId, $regDate, $type, $lang);

      if($res==1){
         // User added
         $id = $db->getCustomerId_byTele($tele);
         $res = $db->newRegularCustomer($id, $fname, $lName);

         if($resp == 1){
            $response['statusCode'] = 'E5001';
            $response['error'] = 'Server error';
         }else{
            $response['statusCode'] = 'S2000';
            $response['error'] = 'User Successfuly Registered';
         }

      }else{
         $response['statusCode'] = 'E5000';
         $response['error'] = 'Server error';
      }

   }else{
      $response['statusCode'] = 'E4001';
      $response['error'] = 'User already registered';
   }

}

$resp = json_encode($response);
echo $resp;

?>
