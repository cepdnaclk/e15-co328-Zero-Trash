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

   $db = new database();
   $pickups = new pickupDB();

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
                  <div class="w3-col s12 m12 l7">
                     <div class="w3-round" style="padding:10px 20px;margin:10px">
                        <div class="w3-row">
                           <a href="javascript:void(0)" onclick="pickupcat(event, 'Pending');">
                              <div
                              class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding w3-border-green">
                              Pending</div>
                           </a>
                           <a href="javascript:void(0)" onclick="pickupcat(event, 'Complete');">
                              <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding">
                                 Complete</div>
                              </a>
                              <a href="javascript:void(0)" onclick="pickupcat(event, 'Incomplete');">
                                 <div class="w3-third tablink1 w3-bottombar w3-hover-light-grey w3-padding">
                                    Incomplete</div>
                                 </a>
                              </div>
                              <br>

                              <div id="Pending" class="pick">
                                 <table class="w3-table w3-hoverable w3-striped w3-border">
                                    <tr>
                                       <th>Customer ID </th>
                                       <th>Municipal Council </th>
                                       <th>Address </th>
                                    </tr>
                                    <?php
                                    $c = $pickups->listPickupsByState('PENDING');

                                    for ($i = 0; $i < sizeof($c); $i++) {
                                       $customer = $c[$i]['customerId'];
                                       $municipal = $c[$i]['areaName'];
                                       $address = $c[$i]['address'];
                                       print "<tr><td>$customer</td> <td>$municipal</td> <td>$address</td> </tr>";
                                    }
                                    ?>
                                 </table>
                              </div>

                              <div id="Complete" class="pick" style="display:none">
                                 <table class="w3-table w3-hoverable w3-striped w3-border">
                                    <tr>
                                       <th>Collector ID </th>
                                       <th>Customer ID </th>
                                       <th>Municipal Council </th>
                                       <th>Address </th>
                                    </tr>
                                    <?php
                                    $c = $pickups->listPickupsByState('COMPLETED');

                                    for ($i = 0; $i < sizeof($c); $i++) {
                                       $collector = $c[$i]['collectorId'];
                                       $customer = $c[$i]['customerId'];
                                       $municipal = $c[$i]['areaName'];
                                       $address = $c[$i]['address'];
                                       print "<tr><td>$collector</td> <td>$customer</td> <td>$municipal</td> <td>$address</td> </tr>";
                                    }
                                    ?>
                                 </table>
                              </div>

                              <div id="Incomplete" class="pick" style="display:none">
                                 <table class="w3-table w3-hoverable w3-striped w3-border">
                                    <tr>
                                       <th>Collector ID </th>
                                       <th>Customer ID </th>
                                       <th>Municipal Council </th>
                                       <th>Address </th>
                                       <?php
                                       $c = $pickups->listPickupsByState('INCOMPLETED');

                                       for ($i = 0; $i < sizeof($c); $i++) {
                                          $collector = $c[$i]['collectorId'];
                                          $customer = $c[$i]['customerId'];
                                          $municipal = $c[$i]['areaName'];
                                          $address = $c[$i]['address'];
                                          print "<tr><td>$collector</td> <td>$customer</td> <td>$municipal</td> <td>$address</td> </tr>";
                                       }
                                       ?>
                                 </table>
                              </div>
                              <br>
                           </div>
                        </div>
                        <div class="w3-col s12 m12 l5">
                           <div class="w3-round " style="padding:10px 20px;margin:10px">
                              <div class="w3-row">
                                 <div class="w3-col s6 m6 l6">
                                    <h4> Summary</h4>
                                 </div>

                                 <div class="w3-col s6 m6 l6">
                                    <a href="javascript:void(0)" onclick="summary(event, 'Weekly');">
                                       <div
                                       class="w3-half tablink2 w3-bottombar w3-hover-light-grey w3-padding w3-border-green">
                                       Weekly</div>
                                    </a>
                                    <a href="javascript:void(0)" onclick="summary(event, 'Monthly');">
                                       <div class="w3-half tablink2 w3-bottombar w3-hover-light-grey w3-padding">
                                          Monthly</div>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="w3-row">
                                    <div id="Weekly" class="sum">
                                       <div class="w3-third">
                                          <div class="w3-container w3-red w3-text-white" style="margin:10px">
                                             <h4>Plastic</h4>
                                             <div class="w3-right">
                                             <?php
                                                   $c = $pickups->getMaterialCountByWeek('Plastic');
                                                   $amount = $c[0]['amount'];
                                                   $amount = number_format((float)$amount, 2, '.', '');
                                                   print "<h3>$amount</h3>";
                                                ?>
                                             </div>
                                             <div class="w3-clear"></div>

                                          </div>
                                       </div>
                                       <div class="w3-third">
                                          <div class="w3-container w3-blue w3-text-white" style="margin:10px">
                                             <h4>Metal</h4>
                                             <div class="w3-right">
                                                <?php
                                                   $c = $pickups->getMaterialCountByWeek('Metal');
                                                   $amount = $c[0]['amount'];
                                                   $amount = number_format((float)$amount, 2, '.', '');
                                                   print "<h3>$amount</h3>";
                                                ?>
                                             </div>
                                             <div class="w3-clear"></div>
                                          </div>
                                       </div>
                                       <div class="w3-third">
                                          <div class="w3-container w3-purple w3-text-white" style="margin:10px">
                                             <h4>Paper</h4>
                                             <div class="w3-right">
                                             <?php
                                                   $c = $pickups->getMaterialCountByWeek('Paper');
                                                   $amount = $c[0]['amount'];
                                                   $amount = number_format((float)$amount, 2, '.', '');
                                                   print "<h3>$amount</h3>";
                                                ?>
                                             </div>
                                             <div class="w3-clear"></div>
                                          </div>
                                       </div>
                                    </div>

                                    <div id="Monthly" class="sum" style="display:none">
                                       <div class="w3-third">
                                          <div class="w3-container w3-red w3-text-white" style="margin:10px">
                                             <h4>Plastic</h4>
                                             <div class="w3-right">
                                             <?php
                                                   $c = $pickups->getMaterialCountByMonth('Plastic');
                                                   $amount = $c[0]['amount'];
                                                   $amount = number_format((float)$amount, 2, '.', '');
                                                   print "<h3>$amount</h3>";
                                                ?>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="w3-third">
                                          <div class="w3-container w3-blue w3-text-white" style="margin:10px">
                                             <h4>Metal</h4>
                                             <div class="w3-right">
                                             <?php
                                                   $c = $pickups->getMaterialCountByMonth('Metal');
                                                   $amount = $c[0]['amount'];
                                                   $amount = number_format((float)$amount, 2, '.', '');
                                                   print "<h3>$amount</h3>";
                                                ?>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="w3-third">
                                          <div class="w3-container w3-purple w3-text-white" style="margin:10px">
                                             <h4>Paper</h4>
                                             <div class="w3-right">
                                             <?php
                                                   $c = $pickups->getMaterialCountByMonth('Paper');
                                                   $amount = $c[0]['amount'];
                                                   $amount = number_format((float)$amount, 2, '.', '');
                                                   print "<h3>$amount</h3>";
                                                ?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <br><br><br>
                     </div>
                  </div>
               </div>

            </div>


            <script>
            function pickupcat(evt, pickupname) {
               var i, x, tablinks1;
               x = document.getElementsByClassName("pick");
               for (i = 0; i < x.length; i++) {
                  x[i].style.display = "none";
               }
               tablinks1 = document.getElementsByClassName("tablink1");
               for (i = 0; i < x.length; i++) {
                  tablinks1[i].className = tablinks1[i].className.replace(" w3-border-green", "");
               }
               document.getElementById(pickupname).style.display = "block";
               evt.currentTarget.firstElementChild.className += " w3-border-green";
            }

            function summary(evt2, sumname) {
               var i, x2, tablinks2;
               x2 = document.getElementsByClassName("sum");
               for (i = 0; i < x2.length; i++) {
                  x2[i].style.display = "none";
               }
               tablinks2 = document.getElementsByClassName("tablink2");
               for (i = 0; i < x2.length; i++) {
                  tablinks2[i].className = tablinks2[i].className.replace(" w3-border-green", "");
               }
               document.getElementById(sumname).style.display = "block";
               evt2.currentTarget.firstElementChild.className += " w3-border-green";
            }
            </script>
         </body>

         </html>
