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

   define("FOLDER_NAME", "pickups");
   include_once "../data/accessControl.php";

   include_once "../db/database.php";
   include_once "../db/pickupDB.php";
   include_once "../db/collectorsDB.php";

   $db = new database();
   $pickups = new pickupDB();
   $collectors = new collectorsDB();

   $f = (isset($_GET['f'])) ? $_GET['f'] : 0;
   $l = (isset($_GET['l'])) ? $_GET['l'] : 20;

   if(isset($_GET['page'])){
      $page = $_GET['page'];
   }else{
      $page= "pending";
   }
   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-user"></i> Pickups</b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round ">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Pickups</a></li>
               </ul>
            </div>
            <br><br>
            <br><br><br>

            <div class="w3-container" style="padding:0px">
               <div class="w3-row">
                  <div class="w3-round" style="padding:10px 20px;margin:10px">
                     <div class="w3-row">
                        <a href="./?page=pending">
                           <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding <?php if($page=="pending") echo "w3-border-green" ?>">Pending</div>
                        </a>

                        <a href="./?page=completed">
                           <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding <?php if($page=="completed") echo "w3-border-green" ?>">Completed</div>
                        </a>

                        <a href="./?page=incompleted">
                           <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding <?php if($page=="incompleted") echo "w3-border-green" ?>">Incomplete / Cancel</div>
                        </a>
                     </div>
                     <br>

                     <div id="tableSection" class="pick">
                        <?php
                        $page = (isset($page)) ? $page : "pending";

                        switch($page){
                           case "pending":
                           include_once './pages/pending.php';
                           break;

                           case "completed":
                           include_once './pages/completed.php';
                           break;

                           case "incompleted":
                           include_once './pages/incompleted.php';
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
