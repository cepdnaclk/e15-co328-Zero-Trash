<?php
include_once '../data/session.php';
include_once "../db/env.php";

include_once '../db/database.php';
include_once '../db/serviceDB.php';

define("FOLDER_NAME", "materials");

include_once "../data/accessControl.php";
include_once '../db/collectingDB.php';

$collecting =  new collectingDB();

$act = $_GET['act'];

if ($act == "add") {
   $notes = "Created by ".$_SESSION['userNameString'].", at ".date("Y-m-d H:i:s");
   
   if ($collecting->newMaterial($_POST['MaterialName'], $_POST['MaterialDescription'], $_POST['MaterialUnitPrice'], $notes)) {
      //print "<script>alert('Success!')</script>";
      print "<script>history.go(-2)</script>";
      exit;

   } else {
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }

} else if ($act == "edit") {

   $id = $_GET['id'];

   print_r($_POST);

   $r = 0;
   $r += $collecting->setMaterialData($id, "materialName", $_POST['MaterialName']);
   $r += $collecting->setMaterialData($id, "materialValue", $_POST['MaterialUnitPrice']);
   $r += $collecting->setMaterialData($id, "materialDescription", $_POST['MaterialDescription']);

   if ($r == 3) {
      //print "<script>alert('Success!')</script>";
      print "<script>history.go(-2)</script>";
      exit;

   } else {
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }

} else if ($act == "delete") {

   $id = $_GET['id'];

   if ($collecting->deleteMaterial($id)) {
      print "<script>history.go(-2)</script>";
      exit;

   } else {
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }

}

?>
