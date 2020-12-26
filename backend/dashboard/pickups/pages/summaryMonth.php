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
