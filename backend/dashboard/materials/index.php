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
   define("FOLDER_NAME", "materials");
   include_once "../data/accessControl.php";

   include '../data/sidebar.php';
   include_once '../db/collectingDB.php';

   $collecting =  new collectingDB();


   ?>

   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">
            <div class="w3-container">

               <ul class="breadcrumb w3-card-2 w3-container w3-margin-8">
                  <li><a href="../home">Home</a></li>
                  <li class="active">Material Managere</a></li>
               </ul>
               <br>

               <div class="w3-bar w3-theme-l2">
                  <a href="#" class="w3-bar-item w3-button">Materials</a>
                  <a href="./add.php" class="w3-bar-item w3-button w3-right">Add New Material</a>
               </div>

               <br>

               <div class="w3-row w3-container">
                  <table class="w3-table w3-hoverable w3-border w3-striped">
                     <tr><th>Material</th><th>Unit Price (Rs.)</th><th>&nbsp;</th><th>&nbsp;</th></tr>
                     <?php

                     $c = $collecting->listMaterials();

                     for ($i = 0; $i < sizeof($c); $i++) {
                        $id = $c[$i]['materialId'];
                        $name = $c[$i]['materialName'];
                        $value = $c[$i]['materialValue'];
                        $desc = $c[$i]['materialDescription'];

                        $action = "<a class='' href='./edit.php?id=$id'>[Edit]</>  ";
                        $action .= "<a class='' href='./delete.php?id=$id'>[Delete]</>";
                        print "<tr><td>$name</td> <td>$value</td> <td>&nbsp;</td> <td>$action</td> </tr>";
                     }

                     ?>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



</body>

</html>
