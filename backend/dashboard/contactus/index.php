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
   include_once "../db/customersDB.php";


   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-col s4 m6 l6" style="padding:30px 20px">
               <h5><b><i class="fa fa-phone"></i> Contact Us</b></h5>
            </div>

            <div class="w3-col s8 m6 l6" style="padding:10px">
               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8 w3-round">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Contact Us</a></li>
               </ul>
            </div>
            <br><br>
            <br><br><br>


            <div class="w3-container">
                <div class="w3-col m2 l3">&nbsp;</div>
                <div class="w3-col s12 m8 l6 w3-round">
                    <br>
                    <form class="w3-container w3-card-4">
                        <h2 class="w3-center">Contact Us</h2>
                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:100px">
                                <label>E-mail</label>
                            </div>
                            <div class="w3-rest">
                                <input class="w3-input" name="email" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:100px">
                                <label>Subject</label>
                            </div>
                            <div class="w3-rest">
                                <input class="w3-input" name="subject" placeholder="Subject">
                            </div>
                        </div>
                        <div class="w3-row w3-section">
                            <div class="w3-col" style="width:100px">
                                <label>Message</label>
                            </div>
                            <div class="w3-rest">
                                <input class="w3-input" name="message" style="height:130px">
                            </div>
                        </div>

                        <div>
                            <input class="w3-button w3-green w3-round w3-right" type="button" value="Send" />
                            <br> <br>  <br>
                        </div>

                    </form>
                </div>
                <div class="w3-col m2 l3">&nbsp;</div>
            </div>

         </div>
         <br><br><br><br> <br>  <br>
      </div>
   </div>

</body>
</html>
