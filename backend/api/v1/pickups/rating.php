<?php

$pickup = new pickupDB();

$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);
$response = array('statusCode'=> '','error' => '');

$id = $in['pickupId'];
$rating = $in['rate'];

if($rating <0 || $rating >5 || is_numeric($id)==false){
   $response['statusCode'] = "E1001";
   $response['error'] = "Invalid input";

}else if($pickup->exists($id)==false){
   $response['statusCode'] = "E1002";
   $response['error'] = "Not exists";

}else if ($rating>=0 && $rating<=5){
   $resp = $pickup->update($id, "rating", $rating);

   if($resp==1){
      $response['statusCode'] = "S2000";
      $response['error'] = "";
   }else{
      $response['statusCode'] = "E1000";
      $response['error'] = "Database Error";
   }
}




?>
