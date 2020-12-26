<?php

$pickup = new pickupDB();

$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);
$response = array('statusCode'=> '','error' => '');

$id = $in['pickupId'];

if(is_numeric($id)==false){
   $response['statusCode'] = "E1001";
   $response['error'] = "Invalid pickupId";

}else if($pickup->exists($id)==false){
   $response['statusCode'] = "E1002";
   $response['error'] = "Invalid pickupId";

}else{
   $resp = $pickup->delete($id);

   if($resp==1){
      $response['statusCode'] = "S2000";
      $response['error'] = "";
   }else{
      $response['statusCode'] = "E1000";
      $response['error'] = "Database Error";
   }
}








?>
