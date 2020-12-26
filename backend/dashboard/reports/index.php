<?php
include_once '../data/session.php';
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

   define("FOLDER_NAME", "reports");
   include_once "../data/accessControl.php";

   include_once "../db/database.php";
   include_once "../db/pickupDB.php";

   $db = new database();
   $pickups = new pickupDB();

   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-user"></i> Reports</b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round ">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Reports</a></li>
               </ul>
            </div>
            <br><br>
            <br><br><br>

            <div class="w3-container" style="padding:0px">
               <div class="w3-row">
                  <div class="w3-round" style="padding:10px 20px;margin:10px">
                     <div class="w3-row">
                        <a href="./?page=weekly">
                           <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding <?php if($_GET['page']=="weekly" || !isset($_GET['page'])) echo "w3-border-green" ?>">Weekly</div>
                        </a>

                        <a href="./?page=monthly">
                           <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding <?php if($_GET['page']=="monthly") echo "w3-border-green" ?>">Monthly</div>
                        </a>

                        <a href="./?page=allTime">
                           <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding <?php if($_GET['page']=="allTime") echo "w3-border-green" ?>">All time</div>
                        </a>

                     </div>
                     <br>

                     <div id="tableSection" class="pick">
                        <?php
                        $page = (isset($_GET['page'])) ? $_GET['page'] : "weekly";

                        switch($page){
                           case "weekly":
                           include_once './pages/weekly.php';
                           break;

                           case "monthly":
                           include_once './pages/monthly.php';
                           break;
                        }
                        ?>
                     </div>
                  </div>
               </div>
               <br><br><br>
            </div>
         </div>
      </div>

   </div>


</body>

</html>
