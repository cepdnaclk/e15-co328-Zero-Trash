

<!-- Top container -->
<div class="w3-bar w3-top w3-large w3-black" style="z-index:4; ">
   <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i> &nbsp;Menu</button>
   <span class="w3-bar-item w3-right">&nbsp;</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left-0 w3-black" style="z-index:3;width:300px;" id="mySidebar">
   <br>
   <div class="w3-container w3-row">
      <div class="w3-col s3">
         <i class="fa fa-user-circle w3-xxxlarge"></i>
      </div>
      <div class="w3-col s9 w3-bar">
         <span>Welcome,<br><strong><?php echo $_SESSION['userNameString'] ?></strong></span><br>
         <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
         <a href="../settings/" class="w3-bar-item w3-button <?php if(FOLDER_NAME=="settings") echo "w3-green" ?>"><i class="fa fa-cog"></i></a>

         <a href="../login/logout" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>

      </div>
   </div>
   <hr>
   <div class="w3-container">
      <h5>Dashboard</h5>
   </div>
   <div class="w3-bar-block">
      <a href="#" class="w3-bar-item w3-button w3-padding w3-nav-button-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu" style="margin-bottom: 20px!important;"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu></a>

      <a href="../home/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="home") echo "w3-green" ?>"><i class="fa fa-eye fa-fw"></i>&nbsp; Overview
      </a>

      <a href="../customers/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="customers") echo "w3-green" ?>"><i class="fa fa-suitcase fa-fw"></i>&nbsp; Customers
      </a>

      <a href="../collectors/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="collectors") echo "w3-green" ?>"><i class="fa fa-suitcase fa-fw"></i>&nbsp; Collectors
      </a>

      <a href="../pickups/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="pickups") echo "w3-green" ?>"><i class="fa fa-suitcase fa-fw"></i>&nbsp; Pickups
      </a>

      <!--<a href="../reports/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="reports") echo "w3-green" ?>"><i class="fa fa-list-alt  fa-fw"></i>&nbsp; Reports</a>-->

      <!--<a href="#" class="w3-bar-item w3-button w3-padding w3-nav-button"><i class="fa fa-history fa-fw"></i>&nbsp; History</a>-->

      <a href="../categorization/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="categorization") echo "w3-green" ?>"><i class="fa fa-tag fa-fw"></i>&nbsp; Categorization</a>

      <a href="../materials/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="materials") echo "w3-green" ?>"><i class="fa fa-outdent fa-fw"></i>&nbsp; Materials</a>

   </div>

   <div class="w3-container">
      <h5>Admin Tools</h5>
   </div>

   <div class="w3-bar-block">

      <?php
      if(isset($_SESSION['acc']['admin']) || isset($_SESSION['acc']['sudo'])){
         echo "<a href=\"../serviceManager/\" class=\"w3-bar-item w3-button w3-padding w3-nav-button ";
         if(FOLDER_NAME=="serviceManager") echo "w3-green";
         echo "\"><i class=\"fa fa-sticky-note fa-fw\"></i>&nbsp; Service Manager</a>";
      }

      if(isset($_SESSION['acc']['admin']) || isset($_SESSION['acc']['sudo'])){

         echo "<a href=\"../users/\" class=\"w3-bar-item w3-button w3-padding w3-nav-button ";
         if(FOLDER_NAME=="users") echo "w3-green";
         echo "\" ><i class=\"fa fa-sticky-note fa-fw\"></i>&nbsp; User Manager</a>";

      }
      ?>

   </div>

   <br>

   <div class="w3-bar-block">
      <a href="../contactus/" class="w3-bar-item w3-button w3-padding w3-nav-button <?php if(FOLDER_NAME=="contactus") echo "w3-green" ?>"><i class="fa fa-phone fa-fw"></i>&nbsp; Contact Us
      </a>
   </div>
   <br><br><br><br>

</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
