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
