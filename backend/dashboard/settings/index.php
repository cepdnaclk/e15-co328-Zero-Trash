<?php include_once '../data/session.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../data/meta.php'; ?>
   <?php include '../data/scripts.php'; ?>

   <script>
   $(document).ready(function () {
      $("#er-close").click(function () {
         window.location = "index.php";
      });
   });
   </script>

   <style>
   .error {
      color: red;
      font-size: small;
   }

   .tabBody {
      display: none;
   }

   label {
      padding-top: 10px !important;
   }
   </style>
</head>
<body>

   <?php
   define("FOLDER_NAME", "settings");
   include_once "../data/accessControl.php";
   include_once "../db/database.php";
   $db = new database();
   ?>

   <?php

   $id = $_SESSION['userId'];

   $firstName = $db->getUserData($id,'firstName');
   $lastName = $db->getUserData($id,'lastName');
   $salutation = $db->getUserData($id,'honorific');

   ?>

   <?php include '../data/sidebar.php'; ?>

   <div class="w3-main" style="margin-left:300px;margin-top:43px;">

      <div class="w3-container">
         <div class="w3-row">

            <ul class="breadcrumb">
               <li><a href="../home">Home</a></li>
               <li class="active">Settings</a></li>
            </ul>
            <br>

            <ul class="w3-bar w3-theme-l2">
               <a href="#" class="w3-bar-item w3-button w3-green tablink" onclick="openTab(event, 'GeneralTab');">General</a>
               <a href="#" class="w3-bar-item w3-button tablink" onclick="openTab(event, 'Password');">Password</a>
            </ul>

            <div>
               <div id="GeneralTab" class="w3-container tabBody" style="display: block;">

                  <form name="newStudent" role="form" class="w3-container w3-card-4 w3-light-grey w3-padding-16 w3-margin-8"
                  method="post" action="./interface.php?act=update">

                  <h2>Edit User</h2>
                  <br>
                  <p><input name="userId" type="hidden" value="<?php echo $id; ?>"></p>

                  <p>
                     <label>Salutation</label>
                     <select class="w3-select w3-border w3-round" name="salutation" required>
                        <option value="" disabled>Select the Salutation</option>
                        <?php
                        $list = json_decode(file_get_contents("../lists/salutations.json"), true);

                        for ($i = 0; $i < sizeof($list); $i++) {
                           $sel = ($i == $salutation) ? "selected" : "";
                           echo "<option value='$i' $sel >$list[$i]</option>";
                        }
                        ?>
                     </select>
                  </p>
                  <p>
                     <label>First Name (with initials)</label>
                     <input class="w3-input w3-border w3-round" name="firstName" type="text" required
                     value="<?php echo $firstName; ?>"/>
                  </p>

                  <p>
                     <label>Last Name</label>
                     <input class="w3-input w3-border w3-round" name="lastName" type="text" required
                     value="<?php echo $lastName; ?>"/>
                  </p>

                  <p>
                     <button type="submit" class="w3-btn w3-theme w3-round">Update User</button>
                  </p>

               </form>

            </div>

            <div id="Password" class="w3-container tabBody">
               <form name="newPassword" role="form" class="w3-container w3-card-4 w3-light-grey w3-padding-16 w3-margin-8"
               method="post" action="./interface.php?act=login">

               <h2>Change Password</h2>
               <br>

               <p><input name="userId" type="hidden" value="<?php echo $id; ?>"></p>


               <p>
                  <label>Current Password</label>
                  <input class="w3-input w3-border w3-round" name="currentPassword" type="text" required>
               </p>

               <p>
                  <label>New Password</label>
                  <input class="w3-input w3-border w3-round" name="newPassword" type="text" required></p>

                  <p>
                     <label>Confirm New Password</label>
                     <input class="w3-input w3-border w3-round" name="confirmPassword" type="text" required>
                  </p>

                  <p>
                     <button type="submit" class="w3-btn w3-theme w3-round">Update Password</button>
                  </p>

               </form>
            </div>
         </div>

         <br><br><br><br>

      </div>
   </div>

</div>

<script>
function openTab(evt, name) {
   var i, x, tablinks;
   x = document.getElementsByClassName("tabBody");
   for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
   }
   tablinks = document.getElementsByClassName("tablink");
   for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-green", "");
   }
   document.getElementById(name).style.display = "block";
   evt.currentTarget.className += " w3-green";
}
</script>

</body>
</html>
