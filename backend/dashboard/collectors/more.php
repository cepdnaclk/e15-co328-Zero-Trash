<?php
include_once '../data/session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <?php include '../data/meta.php'; ?>
   <?php include '../data/scripts.php'; ?>

   <link href="../css/amsify.suggestags.css" rel="stylesheet" type="text/css">
   <script type="text/javascript" src="../js/jquery.amsify.suggestags.js"></script>
   <style>
   * {
      box-sizing: border-box;
   }

   .my-ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
   }

   .my-li {
      border: 1px solid #ddd;
      margin-top: -1px; /* Prevent double borders */
      background-color: #f6f6f6;
      padding: 10px;
      color: black;
      display: block;
      position: relative;
   }

   .my-li:hover {
      background-color: #eee;
   }

   .close {
      cursor: pointer;
      position: absolute;
      top: 50%;
      right: 0%;
      padding: 12px 16px;
      transform: translate(0%, -50%);
   }

   .close:hover {background: #bbb;}
   </style>


</head>

<body>
   <a name="top"></a>

   <?php
   define("FOLDER_NAME", "collectors");
   include_once "../data/accessControl.php";

   include '../data/sidebar.php';
   include_once "../db/database.php";
   include_once "../db/collectorsDB.php";
   include_once "../db/pickupDB.php";
   include_once "../db/areaDB.php";

   $db = new database();
   $collectors = new collectorsDB();
   $area = new areaDB();


   if(!isset($_GET['id'])){

   }
   $id = $_GET['id'];

   $name = $collectors->getCollectorData($id)['name'];
   $phoneNo = $collectors->getCollectorData($id)['phoneNo'];
   $ratings = $collectors->getCollectorData($id)['rateScore'];
   $ratingCount = $collectors->getCollectorData($id)['rateCount'];

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
                  <li><a href="./">Collectors</a></li>
                  <li class="active">More</a></li>
               </ul>
            </div>
         </div>
      </div>
      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s12 m12 l8">
               <div class="w3-round" style="padding:10px 20px;margin:10px">
                  <h4> Info</h4>
                  <div>
                     <table class="w3-table w3-hoverable">
                        <tr>
                           <td>Collector ID</td>
                           <td><?php echo $id; ?></td>
                        </tr>
                        <tr>
                           <td>Collector Name</td>
                           <td><?php echo $name ?></td>
                        </tr>
                        <tr>
                           <td>Telephone</td>
                           <td><?php echo $phoneNo ?></td>
                        </tr>

                        <tr>
                           <td>Ratings</td>
                           <td><?php echo $ratings." / ".$ratingCount  ?></td>
                        </tr>
                        <tr>
                           <td>Last Job </td>
                           <td><?php echo $collectors->getCollectorData($id)['lastCollectionAttempt'] ?? "N/A" ?>
                           </td>
                        </tr>
                     </table>
                  </div>
                  <br>

                  <h4> Registered regions</h4>

                  <form action="./interface.php?act=addRegion&id=<?php echo $id ?>" method="post">
                     <span class="w3-left">
                        <input type="text" name="area" placeholder="Regions" style="height:35px; width:350px; margin:0px 0px 0px 15px;">
                     </span>
                     <span>
                        <input class="w3-button w3-green w3-round" type="submit" name="submit" value="Add"
                        style="margin:0px 0px 0px 10px;">
                     </span>
                  </form>

                  <div class="w3-container">
                     <br>
                     <ul class="w3-ul my-ul">
                        <?php
                        $registered = $area->listCollectorArea_byCollector($id);

                        if(sizeof($registered)==0){
                           echo "<div class='w3-panel w3-yellow w3-small'>
                           <p>Please assign this collector into some regions !</p>
                           </div>";
                        }else{
                           for($i=0;$i<sizeof($registered);$i++){
                              echo "<li class='my-li'>".$area->getAreaData($registered[$i]['areaId'])['areaName'];
                              echo "<a href='./interface.php?act=removeRegion&id=".$registered[$i]['id']."'><span class='close'>&times;</span></a></li>";
                              //echo "<li>".;
                              //echo "<span class='close'>&times;</a></span><li>";
                           }}

                           ?>
                        </ul>
                     </div>

                  </div>
               </div>
               <div class="w3-col s12 m12 l4">
                  <div class="w3-round" style="padding:10px 20px;margin:10px">
                     <form method="POST" action="./interface.php?act=msg">
                        <h4> Message</h4>
                        <textarea name="msg" id="msg" class="w3-input" style="height:250px"></textarea>
                        <br>
                        <div style="text-align:right">
                           <input class="w3-button w3-green w3-round" type="submit" value="Send" />
                        </div>
                        <br>
                     </form>
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>

   <div class="w3-container w3-round" style="margin:0px 20px; padding:10px 20px;">
      <h4> Recent Pickups</h4>

      <?php
      $p = new pickupDB();
      $pickups = $p->list_byCollectorId($id,0,10);

      if(sizeof($pickups)>0){
         echo "<div class='w3-responsive'><table class='w3-table w3-hoverable'>";
         echo "<tr> <td>Place date</td> <td>Pickup Time</td> <td>Status</td> <td>Customer Id</td> <td>Rating</td> </tr>";

         for($i=0;$i<sizeof($pickups);$i++){
            $placedOn = $pickups[$i]['placedOn'];
            $pickupOn = $pickups[$i]['timeSlot'];
            $status = $pickups[$i]['state'];
            //$collector = $pickups[$i]['customerId'] ?? "N/A";
            $rating = $pickups[$i]['rating'] ?? "N/A" ;
            $collectorLink = ( $pickups[$i]['customerId']) ? ("<a href='../customers/more.php?id=".$pickups[$i]['customerId']."'>".$pickups[$i]['customerId']."</a>") : 'N/A';

            print "<tr> <td>$placedOn</td> <td>$pickupOn</td> <td>$status</td> <td>$collectorLink</td> <td>$rating</td></tr>";
         }
         echo "</table></div>";
      }else {
         print "<div class='w3-container w3-center'><i>No pickups completed by this collector</i></div>";
      }
      ?>
      <br>

   </div>
</div>

<script>
$(document).ready(function(){
   $('input[name="area"]').amsifySuggestags({
      tagLimit: 5,
      type : 'amsify',
      noSuggestionMsg: 'No suggestions',
      suggestionsAction : {
         url : '<?php echo $db->get_SiteData("baseURL") ?>lists/regions.php'
      }
   });
});

</script>

</body>

</html>
