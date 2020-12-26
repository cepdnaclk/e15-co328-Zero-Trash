<?php


include '../data/session.php';

define("FOLDER_NAME", "collectors");
include_once "../data/accessControl.php";

include_once "../db/database.php";
include_once "../db/collectorsDB.php";
include_once "../db/areaDB.php";

$db = new database();
$collector = new collectorsDB();
$area = new areaDB();

$act = $_GET['act'];

if ($act == "msg") {
   $msg = $_POST['msg'];
   echo $msg;

   if(1){
      print "<script>alert('Success !')</script>";
      //print "<script>history.go(-1)</script>";
      exit;
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }

} else if($act=="approve"){

   $id = $_GET['id'];
   $data = $collector->getPendingCollectorData($id);

   if($collector->newCollector($data['id'], $data['name'], $data['tele'])){
      echo $collector->setPendingCollectorData($id, 'regStatus', 'REGISTERED');
      header("location: ./more.php?new&id=".$id );

      exit;
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }
   //print_r($data);

} else if($act=='reject'){

   $id = $_GET['id'];
   $data = $collector->getPendingCollectorData($id);

   if ($collector->setPendingCollectorData($id, 'regStatus', 'REJECTED')){

      // TODO: Need to send an SMS and unreg the user from the application

      print "<script>alert('Success !')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }
} else if($act=="addRegion"){

   $id = $_GET['id'];   // id = collector.id
   $areas = explode(',', $_POST['area']);
   //print_r($areas);

   $res = 0;

   for($i=0;$i<sizeof($areas);$i++){

      if($area->existArea_byName($areas[$i])){
         $areaId = $area->getAreaId($areas[$i]);

         if($area->existsCollectorArea($areaId, $id)){
            $res++;
         }else {
            $res +=  $area->newCollectorArea($areaId , $id);
         }
      }else{
         $res++;
      }
   }

   if($res==sizeof($areas)){
      //print "<script>alert('Success !')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }



} else if($act=="removeRegion"){

   $id = $_GET['id'];   // id = collector_area.id

   if($area->deleteCollectorArea($id)){
      //print "<script>alert('Success !')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }else{
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }
}


?>
