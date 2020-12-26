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
   <?php
   include_once "../db/database.php";
   include_once '../db/serviceDB.php';

   define("FOLDER_NAME", "serviceManager");
   include_once "../data/accessControl.php";

   $db = new database();
   $serviceDb = new serviceDB();

   ?>
   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-container">

               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Service Manager</a></li>
               </ul>
               <br>

               <div class="w3-bar w3-theme-l2" style="margin: 10px 16px;">
                  <a href="#" class="w3-bar-item w3-button">Services</a>
                  <a href="add.php" class="w3-bar-item w3-button">Add Service</a>
                  <a href="users.php" class="w3-bar-item w3-button">Manage Users</a>
               </div>

               <br>

               <div class="w3-container">
                  <div class="w3-row w3-container w3-padding-4 w3-hide-small w3-grey">
                     <div class="w3-col s12 m12 l4">
                        Service Name (Service Code)
                     </div>

                     <div class="w3-col s6 m6 l4">
                        &nbsp;
                     </div>

                     <div class="w3-col s6 m6 l4">
                        Permission Type
                     </div>
                  </div>


                  <div class="xtable-responsive">
                     <table class="table" width="100%">

                        <?php

                        if (isset($_GET['f'])) {
                           $f = $_GET['f'];
                        } else {
                           $f = 0;
                        }

                        if (isset($_GET['l'])) {
                           $l = $_GET['l'];
                        } else {
                           $l = 30;
                        }

                        $id = $serviceDb->list_services("id");
                        $serviceCode = $serviceDb->list_services("serviceCode");
                        $serviceName = $serviceDb->list_services("serviceName");
                        $serviceIcon = $serviceDb->list_services("serviceIcon");
                        $serviceURL = $serviceDb->list_services("serviceURL");
                        $servicePermission = $serviceDb->list_services("servicePermission");

                        $c = sizeof($id);

                        for ($i = 0; $i < $c; $i++) {

                           print "
                           <div class='w3-row w3-container w3-hover-opacity w3-border-bottom w3-border-blue' style='padding: 8px;'>
                           <a href='edit.php?id=$id[$i]' class='w3-padding-8'>
                           <div class='w3-col s12 m12 l4 w3-padding-8'>
                           $serviceName[$i] ($serviceCode[$i])
                           </div>

                           <div class='w3-col s6 m6 l4'>
                           $serviceURL[$i]
                           </div>

                           <div class='w3-col s5 m5 l3'>
                           $servicePermission[$i]
                           </div>
                           </a>
                           <a href='delete.php?id=$id[$i]'>
                           <div class='w3-col s1 m1 l1'>
                           <i class='fa fa-trash'></i>
                           </div>
                           </a>
                           </div>";
                        }

                        ?>
                     </table>
                  </div>

                  <ul class="pager">
                     <?php

                     if ($f >= $l) {
                        $n = $f - $l;
                        print "<li class='previous'><a href='index.php?f=$n&l=$l'>Previous</a></li>";
                     }

                     $k = $f + $l;

                     if ($c > $k) {
                        $n = $f + $l;
                        print " <li class='next'><a href='index.php?f=$n&l=$l'>Next</a></li>";
                     }

                     ?>
                  </ul>
               </div>
            </div>
         </div>
      </div>

         <?php include_once '../data/footer.php' ?>


   </body>
</html>
