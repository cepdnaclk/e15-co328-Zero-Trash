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

   include '../data/sidebar.php';
   include_once "../db/database.php";
   include_once "../db/customerDB.php";
   include_once "../db/pickupDB.php";

   $db = new database();
   $customer = new customerDB();

   if(!isset($_GET['id'])){
      exit;
   }
   $id = $_GET['id'];

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
                  <li><a href="./">Customers</a></li>
                  <li class="active">More</a></li>
               </ul>
            </div>
         </div>
      </div>

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-container" style="padding:0px">
               <div class="w3-row">
                  <div class="w3-col s12 m12 l8">
                     <div class="w3-round" style="padding:10px 20px;margin:10px">
                        <h4> Info</h4>
                        <table class="w3-table w3-hoverable">
                           <tr>
                              <td>Customer ID</td>
                              <td><?php echo $id; ?></td>
                           </tr>
                           <tr>
                              <td>Customer Name</td>
                              <td><?php echo $customer->getCustomerName($id) ?></td>
                           </tr>
                           <tr>
                              <td>Telephone</td>
                              <td><?php echo $customer->getCustomerData($id, 'phoneNo') ?></td>
                           </tr>
                           <tr>
                              <td>Email</td>
                              <td><?php echo $customer->getCustomerData($id, 'email') ?></td>
                           </tr>
                           <tr>
                              <td>Municipal Council</td>
                              <td><?php echo $customer->getCustomerData($id, 'municipalCouncil') ?></td>
                           </tr>
                           <tr>
                              <td>Address</td>
                              <td><?php echo $customer->getCustomerAddress($id) ?></td>
                           </tr>
                        </table>
                        <br>
                     </div>
                  </div>
                  <div class="w3-col s12 m12 l4">
                     <div class="w3-round" style="padding:10px 20px;margin:10px">
                        <form method="POST" action="./interface.php?act=msg">
                           <h4> Message</h4>
                           <textarea name="msg" id="msg" class="w3-input" style="height:130px"></textarea>
                           <br>
                           <div style="text-align:right">
                              <input class="w3-button w3-green w3-round" type="submit" value="Send"/>
                           </div>
                           <br>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

            <div class="w3-container w3-round" style="margin:10px">
               <h4> Recent Pickups</h4>
               <div class="w3-responsive">
                  <table class="w3-table w3-hoverable">
                     <tr>
                        <td>Place date</td>
                        <td>Pickup Time</td>
                        <td>Status</td>
                        <td>Collector Id</td>
                        <td>Rating</td>
                     </tr>
                     <?php
                     $p = new pickupDB();
                     $pickups = $p->list_byCustomerId($id,0,10);

                     $times = array(
                        8 => '8:00-10:00 am',
                        10=> '10:00-12:00 pm',
                        12=> '12:00-2:00 pm',
                        14=> '2:00-4:00 pm',
                        16=> '4:00-6:00 pm',
                        18=> '6:00-8:00 pm'
                     );

                     for($i=0;$i<sizeof($pickups);$i++){
                        $placedOn = $pickups[$i]['placedOn'];
                        $pickupOn = $pickups[$i]['timeSlot'];
                        $status = $pickups[$i]['state'];
                        $collector = ($pickups[$i]['collectorId']) ? ('<a href=\'../collectors/more.php?id='.$pickups[$i]['collectorId'].'\'>'.$pickups[$i]['collectorId']."</a>") : "N/A";
                        $rating = $pickups[$i]['rating'] ?? "N/A" ;

                        print "<tr> <td>$placedOn</td> <td>".$times[$pickupOn]."</td> <td>$status</td> <td>$collector</td> <td>$rating</td></tr>";
                     }
                     ?>
                  </table>
                  <br>
               </div>
            </div>

         </div>
         <br>
      </div>
   </div>

</body>
</html>
