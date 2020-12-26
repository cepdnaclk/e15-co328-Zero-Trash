<?php
include_once '../data/session.php';
include_once "../db/env.php";

include_once '../db/database.php';
include_once '../db/serviceDB.php';

define("FOLDER_NAME", "serviceManager");
include_once "../data/accessControl.php";

$db = new database();
$serviceDb = new serviceDB();

$act = $_GET['act'];

if ($act == "add") {

   // Array ( [serviceCode] => telco [serviceName] => Idea Pro [serviceURL] => /telco/ [servicePermission] => 1 [serviceIcon] => telco.png )

   $serviceCode = $_POST['serviceCode'];
   $serviceName = $_POST['serviceName'];
   $servicePermission = $_POST['servicePermission'];

   if ($serviceDb->add_service($serviceCode, $serviceName, "./", $servicePermission, "", "")) {
      //print "<script>alert('Success!')</script>";
      print "<script>history.go(-2)</script>";
      exit;

   } else {
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }

} else if ($act == "update") {
   // Array ( [serviceCode] => telco [serviceName] => Idea Pro [serviceURL] => /telco/ [servicePermission] => 1 [serviceIcon] => telco.png )

   $id = $_GET['id'];

   //$serviceCode = $_POST['serviceCode']; // Readonly
   $serviceName = $_POST['serviceName'];
   $servicePermission = $_POST['servicePermission'];

   $r = 0;
   $r += $serviceDb->update_service($id, "serviceName", $serviceName);
   //$r += $serviceDb->update_service($id, "serviceURL", "./");
   $r += $serviceDb->update_service($id, "servicePermission", $servicePermission);
   //$r += $serviceDb->update_service($id, "serviceIcon", $serviceIcon);

   if ($r == 2) {
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
   $derviceCode = $serviceDb->get_serviceData($id, 'serviceCode');

   if ($serviceDb->delete_service($id) && $serviceDb->delete_serviceFromUsers($derviceCode)) {
      print "<script>history.go(-2)</script>";
      exit;

   } else {
      print "<script>alert('Error!')</script>";
      print "<script>history.go(-1)</script>";
      exit;
   }

} else if ($act == "addService") {

   $serviceId = $_GET['serviceId'];
   $thisUserId = $_GET['userId'];

   $serviceCode = $serviceDb->get_serviceData($serviceId, "serviceCode");
   $servicePermission = $serviceDb->get_serviceData($serviceId, "servicePermission");
   $isAdmin = $serviceDb->exist_userService($userId, "sudo");

   if ($serviceCode != "admin") {
      if ($servicePermission == 0 || $servicePermission == 1 || ($servicePermission == 2 && $isAdmin)) {
         // users can add or admin user only can add

         if ($serviceDb->exist_userService($thisUserId, $serviceCode)) {
            // Already exist
            print "<script>history.go(-1)</script>";
         } else {
            if ($serviceDb->add_userService($thisUserId, $serviceCode, $date, $userId)) {
               print "<script>history.go(-1)</script>";
            } else {
               print "<script>alert('Error!')</script>";
               print "<script>history.go(-1)</script>";
            }
         }
      } else {
         print "<script>alert('You have not permission')</script>";
         print "<script>history.go(-1)</script>";
      }
   }else{
      // Add admin previllege
      if($isAdmin){
         if ($serviceDb->exist_userService($thisUserId, $serviceCode)) {
            // Already exist
            print "<script>history.go(-1)</script>";
         } else {
            if ($serviceDb->add_userService($thisUserId, $serviceCode, $date, $userId)) {
               print "<script>history.go(-1)</script>";
            } else {
               print "<script>alert('Error!')</script>";
               print "<script>history.go(-1)</script>";
            }
         }
      }else{
         print "<script>alert('Error! You haven't admin privillages')</script>";
         print "<script>history.go(-1)</script>";
      }
   }

} else if ($act == "removeService") {

   $thisUserId = $_GET['userId'];
   $serviceId = $_GET['serviceId'];

   $serviceCode = $serviceDb->get_serviceData($serviceId, "serviceCode");
   $servicePermission = $serviceDb->get_serviceData($serviceId, "servicePermission");
   $isAdmin = $serviceDb->exist_userService($userId, "admin");

   if (($serviceCode != "sudo")) {
      if ($servicePermission == 0 || $servicePermission == 1 || ($servicePermission == 2 && $isAdmin)) {
         // users can add or admin user only can remove
         if ($serviceDb->remove_userService($thisUserId, $serviceCode)) {
            print "<script>history.go(-1)</script>";
         } else {
            print "<script>alert('Error!')</script>";
            print "<script>history.go(-1)</script>";
         }
      }
   } else {
      print "<script>alert('Error! cannot remove Sudo Permission')</script>";
      print "<script>history.go(-1)</script>";
   }


}


function redirect($url)
{
   header("Location: $url");
}


?>
