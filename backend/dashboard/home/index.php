
<?php
include_once '../data/session.php';
include_once '../db/env.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../data/meta.php'; ?>
   <?php include '../data/scripts.php'; ?>

   <!--<link href="../css/home.css" rel="stylesheet"/>-->
   <script src="js/jquery-1.9.0.min.js"></script>

   <title>Collector - Dashboard | Home Page</title>
</head>
<body>

   <?php
ini_set("display_errors", true);
error_reporting( E_ALL );
   define("FOLDER_NAME", "home");
   include_once "../data/accessControl.php";
   include_once "../db/database.php";
   include_once "../db/customerDB.php";
   include_once "../db/collectorsDB.php";
   include_once "../db/pickupDB.php";
   include_once "../db/areaDB.php";


   //$db = new database();
   $cust = new customerDB();
   $coll = new collectorsDB();
   $pickup = new pickupDB();
   $area = new areaDB();
   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <!-- Header -->
      <header class="w3-container" style="padding-top:22px">
         <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
      </header>

      <div class="w3-row-padding w3-margin-bottom">
         <div class="w3-quarter">
            <div class="w3-container w3-red w3-padding-16">
               <div class="w3-left"><i class="fa fa-map-marker w3-xxxlarge"></i></div>
               <div class="w3-right">
                  <h3><?php echo $area->countArea(); ?></h3>
               </div>
               <div class="w3-clear"></div>
               <h4>Regions</h4>
            </div>
         </div>
         <div class="w3-quarter">
            <div class="w3-container w3-blue w3-padding-16">
               <a class="txt-button" href="../collectors/">
                  <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                  <div class="w3-right">
                     <h3><?php echo $coll->count(); ?></h3>
                  </div>
                  <div class="w3-clear"></div>
                  <h4>Collectors</h4>
               </a>
            </div>
         </div>
         <div class="w3-quarter">
            <div class="w3-container w3-green w3-padding-16">
               <a class="txt-button" href="../customers/">
                  <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                  <div class="w3-right">
                     <h3><?php echo $cust->count(); ?></h3>
                  </div>
                  <div class="w3-clear"></div>
                  <h4>Customers</h4>
               </a>
            </div>
         </div>
         <div class="w3-quarter">
            <div class="w3-container w3-purple w3-text-white w3-padding-16">
               <a class="txt-button" href="../pickups/">
                  <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                  <div class="w3-right">
                     <h3><?php echo $pickup->countPending(); ?></h3>
                  </div>
                  <div class="w3-clear"></div>
                  <h4>Pending Pickups</h4>
               </a>
            </div>
         </div>
      </div>

   </div>

   <div id="id01" class="w3-modal">
      <div class="w3-modal-content w3-animate-top w3-card-8">
         <header class="w3-container w3-theme">
            <span onclick="document.getElementById('id01').style.display='none'"
            class="w3-closebtn">×</span>
            <h2>Ops :-(</h2>
         </header>
         <div class="w3-container">
            <br><br>
            <p>This feature is currently not available</p>
            <p>Please try again later</p>
            <br><br><br>
         </div>
         <footer class="w3-container w3-theme">

         </footer>
      </div>
   </div>

</body>
</html>

<?php

function printTile($title, $href, $img, $color){
   print "
   <div class='w3-col s6 m4 l3' style='padding: 4px!important;'>
   <a href='$href' class='w3-center' style='text-decoration: none;'>
   <div class='$color w3-center homeTile'>
   <img class='w3-animate-opacity' style='width: 45%; padding: 10px 0 10px 0; ' src='../img/iconsHome/$img'>
   <div class='w3-responsive homeTileName'>$title</div>
   </div>
   </a>
   </div>";
}

?>
