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

   $id = $_GET['id'];

   $serviceCode = $serviceDb->get_serviceData($id, "serviceCode");
   $serviceName = $serviceDb->get_serviceData($id, "serviceName");
   $serviceURL = $serviceDb->get_serviceData($id, "serviceURL");
   $servicePermission = $serviceDb->get_serviceData($id, "servicePermission");
   $serviceIcon = $serviceDb->get_serviceData($id, "serviceIcon");

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
                  <li>Edit</li>
               </ul>

               <div class="w3-container w3-inline">
                  <h3 class="w3-left">Edit a Services</h3>
               </div>

               <br>

               <div class="w3-container">

                  <form action="action.php?act=update&id=<?php echo $id; ?>" class="form-horizontal" method="post">

                     <label for="serviceCode" class="w3-label w3-text-theme"><b>Code</b></label>
                     <input id="serviceCode" readonly value="<?php echo $serviceCode ?>" name="serviceCode" class="w3-input w3-border" type="text">
                     <br>
                     <label for="serviceName" class="w3-label w3-text-theme"><b>Service Name (for display)</b></label>
                     <input id="serviceName" value="<?php echo $serviceName ?>" name="serviceName" class="w3-input w3-border" type="text">

                     <br>
                     <label for="servicePermission" class="w3-label w3-text-theme"><b>Permission</b></label>

                     <select name="servicePermission" id="servicePermission" class="w3-select w3-border">
                        <option <?php if ($servicePermission == 0) echo "selected" ?> value="0">Default</option>
                        <option <?php if ($servicePermission == 1) echo "selected" ?> value="1">Self Enable</option>
                        <option <?php if ($servicePermission == 2) echo "selected" ?> value="2">Admin Enable</option>
                     </select>

                     <br><br>
                     <div>
                        <button type="button" class="w3-button w3-btn w3-theme-button" onclick="history.go(-1)">Back</button>
                        <button type="submit" class="w3-button w3-btn w3-theme-button">Update</button>
                     </div>
                  </form>

               </div>
            </div>
         </div>

         <?php include_once '../data/footer.php' ?>

      </div>
   </body>
   </html>
