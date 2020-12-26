<?php

$pickup = new pickupDB();

$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);
$response = array('statusCode'=> '','error' => '');

$l = $pickup->list_byCustomerId($token['id'], 0, 10);

$enableNewPickup = 1;

for($i=0;$i<sizeof($l);$i++){
   $rating = $l[$i]['rating'];

   if($l[$i]['state']=="PENDING"){
      $enableNewPickup = 0;
   }
   
   $list[$i] = array(
      'id' => $l[$i]['pickupId'],
      'state' =>  $l[$i]['state'],
      'timeSlot' => $l[$i]['timeSlot'],
      'placedOn' =>  $l[$i]['placedOn'],
      'address' =>  $l[$i]['address'],
      'userPhone' =>  $l[$i]['userPhone'],
      'collectorId' =>  $l[$i]['collectorId'],
      'notes' =>  $l[$i]['notes'],
      'rating' => $rating
   );
}
$response['statusCode'] = "S2000";
$response['error'] = "";
$response['enableNewPickup'] = $enableNewPickup;
$response['data'] = (array)$list;

?>
