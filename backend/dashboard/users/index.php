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

   define("FOLDER_NAME", "users");
   include_once "../data/accessControl.php";

   include_once "../db/database.php";
   $db = new database();

   $userRoles = json_decode(file_get_contents("../lists/roles.json"), true);
   ?>

   <?php include '../data/sidebar.php'; ?>

   <!-- !PAGE CONTENT! -->
   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">

            <ul class="breadcrumb w3-card-2 w3-container w3-margin-8">
               <li><a href="../home">Home</a></li>
               <li class="active">Users</a></li>
            </ul>
            <br>

            <div class="w3-bar w3-theme-l2" style="margin: 10px 16px;">
               <a href="#" class="w3-bar-item w3-button">Portal Users</a>
               <a href="./add.php" class="w3-bar-item w3-button w3-0right">Add New User</a>
            </div>

            <br>

            <div class="w3-container w3-margin-12">
               <div class="w3-responsive">
                  <table class="w3-table w3-bordered w3-striped w3-border w3-hoverable">
                     <tr>
                        <th>User ID</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Last Accessed Time</th>
                        <th>Actions</th>
                     </tr>
                     <?php

                     $ids = $db->listUsers("id");
                     $salutation = json_decode(file_get_contents("../lists/salutations.json"), true);

                     for ($i = 0; $i < sizeof($ids); $i++) {
                        $userName = $db->getName_byUserId($ids[$i]);
                        $email = $db->getUserData($ids[$i], "email");
                        $role = $userRoles[$db->getUserData($ids[$i], "role")];
                        $lastAccessed = $db->getUserData($ids[$i], "lastAccess");

                        print "<tr><td>$ids[$i]</td><td>$userName<br>($email)</td><td>$role</td><td>$lastAccessed</td>
                        <td><a href='edit.php?id=$ids[$i]'>Edit</a> | <a href='delete.php?id=$ids[$i]'>Delete</a></td></tr>";
                     }

                     ?>

                  </table>
               </div>
            </div>
         </div>
      </div>
      <br><br><br>
   </div>

</body>
</html>
