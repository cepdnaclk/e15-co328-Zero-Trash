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
   $c = $db->count_rows("dashboard_users");

   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-container">

               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8">
                  <li><a href="../home">Home</a></li>
                  <li><a href="../serviceManager/">Service Manager</a></li>
                  <li class="active">Users</a></li>
               </ul>

               <br>
               <div class="w3-bar w3-theme-l2">
                  <a href="#" class="w3-bar-item w3-button">Site Users</a>
                  <a href="#" class="tablink w3-bar-item w3-button filter-button" data-filter="all">All</a>
                  <a href="#" class="tablink w3-bar-item w3-button filter-button" data-filter="admin">Admins</a>
                  <a href="#" class="tablink w3-bar-item w3-button filter-button" data-filter="lecturer">Web Managers</a>

               </div>

               <br><br>

               <div class="w3-container">
                  <div class="w3-row w3-container w3-padding-4 w3-hide-small w3-grey">
                     <div class="w3-col s12 m4 l4">
                        User Name
                     </div>

                     <div class="w3-col s6 m2 l2">
                        Status
                     </div>

                     <div class="w3-col s6 m2 l2">
                        Account Type
                     </div>

                     <div class="w3-col s6 m4 l4">
                        Last Login
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
                        $salutation = json_decode(file_get_contents("../lists/salutations.json"), true);
                        $userRoles = json_decode(file_get_contents("../lists/roles.json"), true);

                        $id = $db->listUsers_asc("id", $f, $l);
                        $firstName = $db->listUsers_asc("firstName", $f, $l);
                        $lastName = $db->listUsers_asc("lastName", $f, $l);
                        $salutation = $db->listUsers_asc("honorific", $f, $l);

                        $role = $db->listUsers_asc("role", $f, $l);
                        $status = $db->listUsers_asc("userStatus", $f, $l);
                        $lastLogin = $db->listUsers_asc("lastAccess", $f, $l);
                        //$accType = $db->listUsers_asc("accType", $f, $l);

                        for ($i = 0; $i < sizeof($id); $i++) {
                           $filter = strtolower($userRoles[$role[$i]]);
                           $username = $sal[$salutation[$i]]." ".$firstName[$i]." ".$lastName[$i];
                           print "
                           <div class='w3-row w3-container w3-padding-4 w3-hover-opacity filter $filter w3-border-bottom w3-border-blue'>
                           <a href='view.php?id=$id[$i]'>
                           <div class='w3-col s12 m12 l4 w3-white'>$username</div>

                           <div class='w3-col s6 m4 l2 w3-text-teal'>
                           <span class='w3-hide -large'>Status: </span>
                           <span>$status[$i]</span> </div>

                           <div class='w3-col s6 m4 l2 w3-text-red'>
                           <span class='w3-hide -large'>Type: </span>
                           <span>".$userRoles[$role[$i]]."</span>
                           </div>

                           <div class='w3-col s12 m4 l4 w3-text-grey'>
                           <span>$lastLogin[$i]</span>
                           </div>
                           </a></div>";
                        }

                        ?>
                     </table>
                  </div>
               </div>

               <ul class="pager">
                  <?php

                  if ($f >= $l) {
                     $n = $f - $l;
                     print "<li class='previous'><a href='users.php?f=$n&l=$l'>Previous</a></li>";
                  }

                  $k = $f + $l;

                  if ($c > $k) {
                     $n = $f + $l;
                     print " <li class='next'><a href='users.php?f=$n&l=$l'>Next</a></li>";
                  }

                  ?>
               </ul>

            </div>
         </div>

         <script>
         $(document).ready(function () {

            $(".filter-button").click(function () {
               var value = $(this).attr('data-filter');

               if (value == "all") {
                  //$('.filter').removeClass('hidden');
                  $('.filter').show('1000');
               }
               else {
                  $(".filter").not('.' + value).hide('1000');
                  $('.filter').filter('.' + value).show('1000');

               }
            });

         });
         </script>
         <?php include_once '../data/footer.php' ?>

      </div>
   </body>
   </html>
