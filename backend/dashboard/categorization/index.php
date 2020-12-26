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

   define("FOLDER_NAME", "categorization");
   include_once "../data/accessControl.php";

   include_once "../db/database.php";
   include_once "../db/collectingDB.php";

   $db = new database();
   $collect = new collectingDB();

   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-tag"></i> Categorization</b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Categorization</a></li>
               </ul>
            </div>
            <br><br>
            <br><br><br>
            <div class="w3-row">
               <h3>Recent Pickups</h3>
            </div>
            <table class="w3-table w3-hoverable w3-border w3-striped">
               <tr><th>Pickup ID</th><th>Date</th><th>Collector</th><th>State</th><th> </th></tr>
               <?php

               $c = $collect->listPickups();

               for ($i = 0; $i < sizeof($c); $i++) {
                  $id = $c[$i]['pickupId'];
                  $name = $c[$i]['name'];
                  $date = $c[$i]['placedOn'];
                  $state = $c[$i]['state'];
                  if ($state=="COMPLETED"){
                     $action = "<a class='' href='./window.php?id=$id'>Process</>";
                  }else{
                     $action = '-';
                  }
                  print "<tr><td>$id</td> <td>$date</td> <td>$name</td> <td>$state</td> <td>$action</td> </tr>";
               }

               ?>
            </table>
         </div>
         <br><br><br><br><br><br><br><br>
      </div>
   </div>
</div>

</body>
</html>
