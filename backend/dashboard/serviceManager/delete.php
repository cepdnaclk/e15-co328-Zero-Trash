
<?php
include_once '../data/session.php';
include_once "../db/env.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../data/meta.php'; ?>
   <?php include '../data/scripts.php'; ?>

   <style>
   .btn{min-width: 100px;}
   </style>
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

   $id = $_GET['id'];
   $serviceCode = $serviceDb->get_serviceData($id, "serviceCode");
   $serviceName = $serviceDb->get_serviceData($id, "serviceName");

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
                  <li class="active">Delete</li>
               </ul>

               <div class="w3-container w3-inline">
                  <h3 class="w3-left">Delete a Services</h3>
               </div>
               <br>
               <div class="w3-container w3-card-4 w3-light-grey w3-padding-16 w3-margin-8">

                  <p>Are you sure to delete following Service ?</p>
                  <br>
                  <?php
                  print "<div class='w3-container w3-padding-jumbo'><b>$serviceCode - $serviceName</b></div>";
                  ?>

                  <br><br>
                  <a onclick="history.go(-1);" href="#" class="w3-button w3-btn w3-theme-button">No</a>
                  <a href="action.php?act=delete&id=<?php echo $id ?>" class="w3-button w3-btn w3-theme-button">Yes</a>

                  <br><br><br>

               </div>

            </div>
         </div>

         <?php include_once '../data/footer.php' ?>
      </div>

   </body>
   </html>
