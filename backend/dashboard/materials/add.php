
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

   define("FOLDER_NAME", "materials");
   include_once "../data/accessControl.php";
   include_once '../db/collectingDB.php';

   $collecting =  new collectingDB();

   ?>
   
   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-container">

               <ul class="breadcrumb">
                  <li><a href="../home">Home</a></li>
                  <li><a href="index.php">Material Manager</a></li>
                  <li class="active">Add</li>
               </ul>
               <div class="w3-container w3-inline">
                  <h3 class="w3-left">Add a Material</h3>
               </div>

               <br>

               <div class="w3-container">

                  <form action="./interface.php?act=add" class="form-horizontal" method="post">

                     <label for="MaterialName" class="w3-labelw3-text-theme0"><b>Material Name (for display)</b></label>
                     <input id="MaterialName" required value="" name="MaterialName" class="w3-input w3-border" type="text">
                     <br>
                     <label for="MaterialUnitPrice" class="w3-labelw3-text-theme0"><b>Unit Price (Rs.)</b></label>
                     <input id="MaterialUnitPrice" required value="" name="MaterialUnitPrice" class="w3-input w3-border" step="0.01" type="number">
                     <br>
                     <label for="MaterialDescription" class="w3-labelw3-text-theme0"><b>Description</b></label>
                     <textarea id="MaterialDescription" value="" name="MaterialDescription" class="w3-input w3-border" type="text" style="height:100px;"></textarea>
                     <br><br>
                     <div>
                        <button type="button" class="w3-button w3-btn w3-theme-button" onclick="history.go(-1)">Back</button>
                        <button type="submit" class="w3-button w3-btn w3-theme-button">Add</button>
                     </div>
                  </form>

               </div>
            </div>
         </div>

         <?php include_once '../data/footer.php' ?>

      </div>

   </body>
   </html>
