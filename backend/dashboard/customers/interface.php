<?php


include '../data/session.php';

define("FOLDER_NAME", "customers");
include_once "../data/accessControl.php";

include_once '../db/database.php';
$db = new database();

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

}


?>
