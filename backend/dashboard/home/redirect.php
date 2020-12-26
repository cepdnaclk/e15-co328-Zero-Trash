<?php

include_once '../data/session.php';
include_once '../db/env.php';

include_once '../db/database.php';
include_once '../db/serviceDB.php';

$db = new database();
$serviceDb = new serviceDB();

$userStatus = $db->getUserData($userId, "userStatus");
$accType = $db->getUserData($userId, "role");

if ($userStatus == "ACTIVE") {
   $serviceList = $serviceDb->list_userServices($userId, "serviceCode");
   accessGrant($serviceList);
   redirect("index.php");

} else if($userStatus=="WELCOME"){
   $serviceDb->add_userService($userId, "viewer", $date, "0");
   $serviceList = $serviceDb->list_userServices($userId, "serviceCode"); //$db->get_userPermissionList($userId);
   accessGrant($serviceList);
   redirect("./welcome.php");

} else if($userStatus=="PENDING"){
   // Activate the account at first login
   $db->setUserData($userId, "userStatus", "ACTIVE");

   redirect("../index.php");

} else if($userStatus=="REJECTED"){
   //redirect("../index.php");

} else {redirect("../index.php");
   //redirect("../index.php");
}

function accessGrant($list)
{
   // Grant access for each module
   foreach ($list as $module) {
      //$_SESSION["access-" . $module] = 1;
      $_SESSION['acc'][$module] = 1;
   }
}

function redirect($url)
{
   header("Location: $url");
   exit;
}

?>
