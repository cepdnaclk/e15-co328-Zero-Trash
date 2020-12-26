<?php

$pickup = new pickupDB();

$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);
$response = array('statusCode'=> '','error' => '');

$timeSlot =  $db->mysqlSafe($in['timeslot']);
//$dateTime =  $db->mysqlSafe($in['datetime']);
$customer =  $db->mysqlSafe($token['id']);
$address =  $db->mysqlSafe($in['address']);
$tele =  $db->mysqlSafe($in['userPhone']);

$resp = $pickup->newPickup($timeSlot, $time, $customer, $address, $tele);

$list = $pickup->list_byCustomerId($customer,0,10);
//print_r($list);

$response['id'] = $list[0]['pickupId'];

$response['statusCode'] = "S2000";
$response['error'] = "";






?>
