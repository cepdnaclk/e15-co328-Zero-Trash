<?php


include '../data/session.php';

define("FOLDER_NAME", "categorization");
include_once "../data/accessControl.php";

include_once "../db/database.php";
include_once "../db/collectorsDB.php";
include_once "../db/areaDB.php";
include_once "../db/pickupDB.php";
include_once "../db/collectingDB.php";

$db = new database();
$collector = new collectorsDB();
$area = new areaDB();
$collect = new collectingDB();
$pickups = new pickupDB();

$act = $_GET['act'];

if($act=="new"){
   $amount = $_POST['quantity'];
   $pickupId = $_POST['pickupId'];
   $materialId = $_POST['materialOption'];
   $dateTime = date("y-m-d H:i:s");
   $notes = "";

   if($collect->newWaste($materialId, $pickupId, $amount, $dateTime, $notes)){
      header("location: ./window.php?id=".$pickupId);
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
   }

} else if($act=="remove"){
   $id = $_GET['id'];
   $pickupId = $_GET['pickupId'];

   if($collect->deleteWaste($id)){
      header("location: ./window.php?id=".$pickupId);
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
   }
}


?>
