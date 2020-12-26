<?php
include_once '../data/session.php';
include_once "../db/env.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../data/meta.php'; ?>
   <?php include '../data/scripts.php'; ?>
</head>
<body>

   <a name="top"></a>
   <?php
   include_once "../db/database.php";
   include_once '../db/serviceDB.php';

   define("FOLDER_NAME", "serviceManager");
   include_once "../data/accessControl.php";

   $db = new database();
   $serviceDb = new serviceDB();

   ?>

   <?php

   if (!isset($_GET['id'])) {
      print "<script>history.go(-1)</script>";
   }

   $id = $_GET['id'];
   $salutation = json_decode(file_get_contents("../lists/salutations.json"), true);


   $email = $db->getUserData($id, "email");
   $lastLogin = $db->getUserData($id, "lastAccess");
   $role = $db->getUserData($id, "role");
   $status = $db->getUserData($id, "userStatus");

   $firstName = $db->getUserData($id, "firstName");
   $lastName = $db->getUserData($id, "lastName");
   $sal = $salutation[$db->getUserData($id, "honorific")];
   $thisUserName = "$sal $firstName $lastName";

   $email = $db->getUserData($id, "email");

   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-container">
               
               <ul class="breadcrumb">
                  <li><a href="../home">Home</a></li>
                  <li><a href="index.php">Service Manager</a></li>
                  <li><a href="users.php">Users</a></li>
                  <li class="active"><?php echo "$firstName $lastName" ?></li>
               </ul>
               <br>
               <h3><?php echo "$thisUserName ($email)"; ?></h3>
               <br>

               <div class="w3-row">
                  <div class="w3-col s12 m6 l6 w3-padding-8">
                     <h4>Services Enabled</h4>

                     <ul class="w3-ul w3-border w3-hoverable">
                        <?php

                        $serviceCode = $serviceDb->list_userServices($id, "serviceCode");

                        for ($i = 0; $i < sizeof($serviceCode); $i++) {
                           $serviceName = $serviceDb->get_serviceData_byServiceCode($serviceCode[$i], "serviceName");
                           $serviceId = $serviceDb->get_serviceData_byServiceCode($serviceCode[$i], "id");
                           $url = "action.php?act=removeService&userId=$id&serviceId=$serviceId";

                           if($serviceId == 1000){
                              print "<li>$serviceName<span class='w3-right'><a class='w3-disabled' href='#'><i class='fa fa-close'></i></a></span></li>";
                           }else{
                              print "<li>$serviceName<span class='w3-right'><a href='$url'><i class='fa fa-close'></i></a></span></li>";
                           }
                        }

                        ?>
                     </ul>

                  </div>
                  <div class="w3-col s12 m6 l6  w3-padding">
                     <h4>Services Not Enabled</h4>

                     <ul class="w3-ul w3-border w3-hoverable">
                        <?php

                        $services = $serviceDb->list_services("serviceCode");

                        for ($i = 0; $i < sizeof($services); $i++) {

                           if (!$serviceDb->exist_userService($id, $services[$i])) {
                              $serviceId = $serviceDb->get_serviceData_byServiceCode($services[$i], "id");
                              $serviceName = $serviceDb->get_serviceData_byServiceCode($services[$i], "serviceName");

                              $url = "action.php?act=addService&userId=$id&serviceId=$serviceId";


                              if($serviceId == 1000){
                                 print "<li>$serviceName<span class='w3-right'><a class='w3-disabled' href='$url'><i class='fa fa-arrow-left'></i></a></span></li>";
                              }else{
                                 print "<li>$serviceName<span class='w3-right'><a href='$url'><i class='fa fa-arrow-left'></i></a></span></li>";
                              }

                           }
                        }

                        ?>
                     </ul>

                  </div>
               </div>


               <br><br><br>

               <div class="row">

                  <table class="table">
                     <tr>
                        <td>User Name</td>
                        <td><?php echo $thisUserName ?></td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td><?php echo $status ?></td>
                     </tr>
                     <tr>
                        <td>Email</td>
                        <td><?php echo $email ?></td>
                     </tr>
                     <tr>
                        <td>Account Type</td>
                        <td><?php echo $role ?></td>
                     </tr>
                     <tr>
                        <td><br></td>
                        <td><br></td>
                     </tr>

                     <tr>
                        <td>Last login</td>
                        <td><?php echo $lastLogin ?></td>
                     </tr>
                     <tr>
                        <td><br></td>
                        <td><br></td>
                     </tr>

                  </table>

               </div>

            </div>
         </div>
         <br><br><br>
         <?php include_once '../data/footer.php' ?>

      </div>

   </body>
   </html>
