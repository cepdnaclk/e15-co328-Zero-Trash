
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

   define("FOLDER_NAME", "materials");
   include_once "../data/accessControl.php";
   include_once '../db/collectingDB.php';

   $collecting =  new collectingDB();

   if(!isset($_GET['id'])){
      exit;
   }

   $id = $_GET['id'];
   
   if($collecting->existsMaterial($id)){
      $m = $collecting->getMaterialData($id);
      print_r($m);

      $mName = $m['materialName'];
      $mValue = $m['materialValue'];
      $mNotes = $m['materialNotes'];
      $mDesc = $m['materialDescription'];
   }else{
      echo "Not exists";
      exit;
   }

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
                  <li class="active">Delete</li>
               </ul>

               <div class="w3-container w3-inline">
                  <h3 class="w3-left">Delete a Material</h3>
               </div>
               <br>
               <div class="w3-container w3-card-4 w3-light-grey w3-padding-16 w3-margin-8">

                  <p>Are you sure to delete following Material ?</p>
                  <br>
                  <?php
                  print "<div class='w3-container w3-padding-jumbo'><b>$mName<br><small>$mDesc</small></b></div>";
                  ?>

                  <br><br>
                  <a onclick="history.go(-1);" href="#" class="w3-button w3-btn w3-theme-button">No</a>
                  <a href="./interface.php?act=delete&id=<?php echo $id ?>" class="w3-button w3-btn w3-theme-button">Yes</a>

                  <br><br><br>

               </div>

            </div>
         </div>

         <?php include_once '../data/footer.php' ?>
      </div>

   </body>
   </html>
