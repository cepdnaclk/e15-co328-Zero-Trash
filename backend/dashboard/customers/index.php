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

   define("FOLDER_NAME", "customers");
   include_once "../data/accessControl.php";

   include_once "../db/database.php";
   include_once "../db/customerDB.php";

   $db = new database();
   $customer = new customerDB();
   $searchState = 0;
   include '../data/sidebar.php';

   $f = (isset($_GET['f'])) ? $_GET['f'] : 0;
   $l = (isset($_GET['l'])) ? $_GET['l'] : 20;

   ?>

   <div class="w3-main" style="margin-left:300px;margin-top:43px;">
      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-user"></i> Customers</b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round ">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Customers</a></li>
               </ul>
            </div>
         </div>
      </div>

      <div class="w3-container">
         <div class="w3-row">
            <form  action="#" method="get">
               <div class="w3-left">
                  <input type="text" name="search" placeholder="Enter area" style="border-radius:5px; height:35px" value="<?php echo $_GET['search'] ?>">
                  show Pickup Count <input type="checkbox" name="showPickUps" id="showPickUps" value="1"
                  <?php echo (isset($_GET['showPickUps']))? 'checked' : ""?> >
               </div>
               <div class="w3-right">
                  <input class="w3-button w3-green w3-round" type="submit" name="submit" value="search">
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

         <br>
         <div class="w3-responsive">
            <table class="w3-table w3-hoverable w3-border">

               <?php
               if($searchState == 0) {
                  $c = $customer->list($f, $l);
                  $count = $customer->count();

                  if(sizeof($c)==0){
                     echo "<div class='w3-center'>Empty Result</div>";
                  }else{
                     echo "<tr><th>Customer ID</th><th>Name</th><th>Email</th><th> </th></tr>";
                  }

                  for ($i = 0; $i < sizeof($c); $i++) {
                     $id = $c[$i]['customerId'];
                     $userName = $c[$i]['firstName']." ".$c[$i]['lastName'];
                     $email = $c[$i]['email'];
                     $role = $c[$i]['address1'];
                     $action = "<a class='' href='./more.php?id=$id'>More</>";
                     print "<tr><td>$id</td> <td>$userName</td> <td>$email</td> <td>$action</td> </tr>";
                  }
               }
               else if($searchState == 1) {
                  $c = $customer->listCustomersByArea($_GET['search'], $f, $l);
                  $count = $customer->countCustomersByArea($_GET['search']);

                  if(sizeof($c)==0){
                     echo "<div class='w3-center'>Empty Result</div>";
                  }else{
                     echo "<tr><th>Customer ID</th><th>Name</th><th>Email</th><th> </th></tr>";
                  }

                  for ($i = 0; $i < sizeof($c); $i++) {
                     $id = $c[$i]['customerId'];
                     $userName = $c[$i]['firstName']." ".$c[$i]['lastName'];
                     $email = $c[$i]['email'];
                     $role = $c[$i]['address1'];
                     $action = "<a class='' href='./more.php?id=$id'>More</>";
                     print "<tr><td>$id</td> <td>$userName</td> <td>$email</td> <td>$action</td> </tr>";
                  }
               }
               else if($searchState == 2) {
                  $c = $customer->listCustomersWithPickupCount($_GET['search'], $f, $l);
                  $count = $customer->countCustomersByArea($_GET['search']);

                  if(sizeof($c)==0){
                     echo "<div class='w3-center'>Empty Result</div>";
                  }else{
                     echo "<tr><th>Customer ID</th><th>Name</th><th>Email</th><th>Pickup Count</th> <th>&nbsp;</th></tr>";
                  }

                  for ($i = 0; $i < sizeof($c); $i++) {
                     $id = $c[$i]['customerId'];
                     $userName = $c[$i]['firstName']." ".$c[$i]['lastName'];
                     $email = $c[$i]['email'];
                     $pickupCount = $c[$i]['pickupCount'];
                     $action = "<a class='' href='./more.php?id=$id'>More</>";
                     print "<tr><td>$id</td> <td>$userName</td> <td>$email</td> <td>$pickupCount</td> <td>$action</td></tr>";
                  }
               }

               ?>
            </table>
            <br><br>
            <div class="w3-container w3-center">
               <?php
               //$c = $customer->count();
               if($count>0){
                  echo "<div class='w3-bar w3-border' style='width: 200px;'>";
                  $serach = isset($_GET['search']) ? 'search='.$_GET['search'] : '';

                  if ($f > 0) {
                     $n = max(0,$f - $l);
                     print "<a href='index.php?f=$n&l=$l&$serach' class='w3-button w3-border-right w3-left'>&#10094;</a>";
                  }
                  $k = $f + $l;
                  if ($count > $k) {
                     $n = $f + $l;
                     print "<a href='index.php?f=$n&l=$l&$serach' class='w3-button w3-border-left w3-right'>&#10095;</a>";
                  }
               }
               echo "</div>";
               ?>
               <br><br>
            </div>
         </div>
      </div>
   </div>
</body>

</html>
