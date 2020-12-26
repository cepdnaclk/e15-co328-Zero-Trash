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

   define("FOLDER_NAME", "collectors");
   include_once "../data/accessControl.php";

   include_once "../db/database.php";
   include_once "../db/collectorsDB.php";

   $db = new database();
   $collector = new collectorsDB();
   $searchState = 0;

   $f = (isset($_GET['f'])) ? $_GET['f'] : 0;
   $l = (isset($_GET['l'])) ? $_GET['l'] : 20;

   $f = (isset($_GET['f'])) ? $_GET['f'] : 0;
   $l = (isset($_GET['l'])) ? $_GET['l'] : 20;

   include '../data/sidebar.php';
   ?>

   <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-user"></i> Collectors</b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round ">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Collectors</a></li>
               </ul>
            </div>
         </div>
      </div>
      <br>
      <div class="w3-container">
         <div class="w3-row">
            <h3>Collector Agents who needs Approval</h3>
         </div>
         <div class="w3-responsive">
            <table class="w3-table w3-hoverable w3-border w3-striped">
               <tr>
                  <th>Collector ID</th>
                  <th>Name</th>
                  <th>Phone No</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
               </tr>
               <?php

               $pending = $collector->listPendingCollectors();

               for($i=0;$i<sizeof($pending);$i++){

                  $p = $pending[$i];
                  echo "<tr>";
                  echo "<td>".$p['id']."</td>";
                  echo "<td>".$p['name']."</td>";
                  echo "<td>".$p['tele']."</td>";
                  echo "<td>&nbsp;</td>";
                  echo "<td><div class='w3-right'>
                  <a class='w3-button w3-green w3-round w3-small' href='./interface.php?act=approve&id=".$p['id']."'>Approve</a>
                  <a class='w3-button w3-orange w3-round w3-small' href='./interface.php?act=reject&id=".$p['id']."'>Reject</a>
                  </div></td>";
               }


               ?>





            </tr>
         </table>
      </div>
   </div>

   <hr>

   <div class="w3-container">
      <div class="w3-row">
         <h3>Active Collector Agents</h3>
      </div>

      <div class="w3-container">
         <div class="w3-row">
            <form class="w3-col s12 m6 l6 w3-right" action="#" method="get">
               <div class="w3-left">
                  <input type="text" name="search" placeholder="Enter area" style="border-radius:5px; height:35px"
                  value="<?php echo $_GET['search'] ?>">
                  show Pickup Count <input type="checkbox" name="showPickUps" id="showPickUps" value="1"
                  <?php echo (isset($_GET['showPickUps']))? 'checked' : ""?>>
               </div>
               <div class="w3-right">
                  <input class="w3-button w3-green w3-round" type="submit" name="submit" value="search">
               </div>

            </form>

            <?php
            if (strlen($_GET['search']) && $_GET['showPickUps'] == 1) {
               $searchState = 2;
            }
            elseif(strlen($_GET['search'])){
               $searchState = 1;
            }
            ?>
         </div>
      </div>
      <br/>

      <div class="w3-responsive">
         <table class="w3-table w3-hoverable w3-border w3-striped">
            <tr>
               <th>Collector ID</th>
               <th>Name</th>
               <th>Phone No</th>
               <th>Ratings</th>
               <?php  echo ($_GET['showPickUps']==1) ? "<th>Pickup Count</th>" : "<th>&nbsp;</th>" ?>
               <th>&nbsp;</th>
            </tr>

            <?php
            if($searchState == 0) {

               $c = $collector->list($f, $l);

               for ($i = 0; $i < sizeof($c); $i++) {
                  $id = $c[$i]['collectorId'];
                  $userName = $c[$i]['name'];
                  $rating = $c[$i]['rateCount'];
                  $tele = $c[$i]['phoneNo'];
                  $action = "<a class='' href='./more.php?id=$id'>More</>";

                  print "<tr><td>$id</td> <td>$userName</td> <td>$tele</td> <td>$rating</td> <td>$action</td> </tr>";
               }
            }
            else if($searchState == 1) {
               $c = $collector->listCollectorsByArea($_GET['search']);

               for ($i = 0; $i < sizeof($c); $i++) {
                  $id = $c[$i]['collectorId'];
                  $userName = $c[$i]['name'];
                  $rating = $c[$i]['rateCount'];
                  $tele = $c[$i]['phoneNo'];
                  $action = "<a class='' href='./more.php?id=$id'>More</>";

                  print "<tr><td>$id</td> <td>$userName</td> <td>$tele</td> <td>$rating</td> <td>$action</td> </tr>";
               }
            }
            else if($searchState == 2) {
               $c = $collector->listCollectorswithPickupCount($_GET['search']);

               for ($i = 0; $i < sizeof($c); $i++) {
                  $id = $c[$i]['collectorId'];
                  $userName = $c[$i]['name'];
                  $rating = $c[$i]['rateCount'];
                  $tele = $c[$i]['phoneNo'];
                  $pickupCount = $c[$i]['pickupCount'];
                  $action = "<a class='' href='./more.php?id=$id'>More</>";

                  print "<tr><td>$id</td> <td>$userName</td> <td>$tele</td> <td>$rating</td> <td>$pickupCount</td><td>$action</td> </tr>";
               }
            }
            ?>
         </table>
         <br><br>

         <div class="w3-container w3-center">
            <div class="w3-bar w3-border" style="width: 200px;">
               <?php
               $c = $collector->count();
               if ($f > 0) {
                  $n = max(0,$f - $l);
                  print "<a href='index.php?f=$n&l=$l' class='w3-button w3-border-right w3-left'>&#10094;</a>";
               }
               $k = $f + $l;
               if ($c > $k) {
                  $n = $f + $l;
                  print "<a href='index.php?f=$n&l=$l' class='w3-button w3-border-left w3-right'>&#10095;</a>";
               }
               ?>
            </div>
            <br><br>
         </div>
      </div>

   </div>
</div>

</div>

</body>

</html>
