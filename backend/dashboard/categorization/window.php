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
   include_once "../db/pickupDB.php";

   $db = new database();
   $collect = new collectingDB();
   $pickups = new pickupDB();

   // NOTE: To load this page, add a pickupId (which in the database) to the end of the URL as follows
   // Ex: index.php?id=1

   if(!isset($_GET['id'])){
      // Error
      echo "Incomplete Request";
      exit;
   }

   $pickupId = $_GET['id'];

   if($pickups->existPickup($pickupId)){
      $p = $pickups->getPickupData($pickupId);
   }else{
      echo "Pickup Not Exists";
      exit;
   }


   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-tag"></i> Pickup #<?php echo $pickupId ?></b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Pickup</li>
                  <li>#<?php echo $pickupId ?></li>
               </ul>
            </div>
         </div>


         <div class="w3-row">
            <div class="w3-col s12 m12 l6">
               <div class="w3-round" style="padding:10px 20px;margin:10px">
                  <br>
                  <form class="w3-container w3-card-4" action="./interface.php?act=new" method="POST">
                     <input type="hidden" name="pickupId" value="<?php echo $pickupId ?>">

                     <h2 class="w3-center">Categorization</h2>
                     <div class="w3-row w3-section">
                        <div class="w3-col" style="width:120px">
                           <label>Material</label>
                        </div>
                        <div class="w3-rest">
                           <select type="text" required class="w3-select" name="materialOption">
                              <?php
                              $m = $collect->listWasteNotInPickup($pickupId);

                              for ($i=0; $i < sizeof($m) ; $i++) {
                                 echo "<option value='".$m[$i]['materialId']."'>".$m[$i]['materialName']."</option>";
                              }
                              ?>

                           </select>

                        </div>
                     </div>
                     <div class="w3-row w3-section">
                        <div class="w3-col" style="width:120px">
                           <label>Quantity (kg)</label>
                        </div>
                        <div class="w3-rest">
                           <input class="w3-input" type="number" id="quantity" name="quantity" required step="0.001">
                        </div>
                     </div>
                     <div>
                        <input class="w3-button w3-green w3-round w3-right" type="submit" value="Add"/>
                        <br> <br> <br>
                     </div>
                  </form>
               </div>
            </div>

         </div>
         <div class="w3-row">
            <div class="w3-round" style="padding:10px 20px;margin:10px">
               <div class="w3-container w3-card-4">
                  <h2>Summary</h2>
                  <table class="w3-table w3-hoverable w3-border w3-striped">

                     <?php
                     $c = $collect->listWaste_inPickup($pickupId);
                     $sum = 0;

                     if(sizeof($c)==0){
                        echo "<h3 class='w3-center'>(Empty)</h3>";
                     }else{
                        echo "<tr>
                        <th>&nbsp;</th>
                        <th>Material</th>
                        <th>Quantity (kg)</th>
                        <th>Unit (Rs.)</th>
                        <th>Value (Rs.)</th>
                        <th>&nbsp;</th>
                        </tr>";

                        for ($i = 0; $i < sizeof($c); $i++) {
                           $id = $c[$i]['id'];
                           $material = $c[$i]['materialName'];
                           $quantity = $c[$i]['amount'];
                           $materialValue = $c[$i]['materialValue'];
                           $value = round($c[$i]['value'],2);
                           $sum += $value;
                           print "<tr><td>".($i+1)."</td><td>$material</td> <td>$quantity</td> <td>$materialValue</td> <td>$value</td>
                           <td> <a style='text-decoration: none;' href='./interface.php?act=remove&id=$id&pickupId=$pickupId'>x</a></td></tr>";
                        }

                        print "<tr style='border-top: 1px solid black;'><td>&nbsp;</td><td>&nbsp;</td> <td>&nbsp;</td>";
                        print "<td>Total</td> <td>$sum</td><td>&nbsp;</td></tr>";}
                        ?>
                     </table>
                     <br>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <br><br><br><br><br><br><br><br>
   </div>
</div>
</div>


</body>

</html>
