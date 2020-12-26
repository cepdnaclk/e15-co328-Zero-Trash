<table class="w3-table w3-hoverable w3-striped w3-border">
    <tr>
        <th>Customer ID </th>
        <th>Region</th>
        <th>Placed on </th>
        <th>Collector</th>
    </tr>
    <?php

   $c = $pickups->listPickupsByState('PENDING',$f,$l);
    for ($i = 0; $i < sizeof($c); $i++) {

        $customer = "<a href='../customers/more.php?id=".$c[$i]['customerId']."'>".$c[$i]['customerId']."</a>";
        $region = $c[$i]['areaName'];
        $placedOn = $c[$i]['placedOn'];
        $collector =  "<a href='../collectors/more.php?id=".$c[$i]['collectorId']."'>".$collectors->getCollectorName($c[$i]['collectorId'])."</a>";

        print "<tr><td>$customer</td> <td>$region</td> <td>$placedOn</td><td>$collector</td> </tr>";
    }
    ?>
</table>

<br>

<div class="w3-container w3-center">
   <div class="w3-bar w3-border" style="width: 200px;">
      <?php
      $c = $pickups->countPickupsByState('PENDING');
      //echo $c;

      if ($f > 0) {
         $n = max(0,$f - $l);
         print "<a href='index.php?page=$page&f=$n&l=$l' class='w3-button w3-border-right w3-left'>&#10094;</a>";
      }
      $k = $f + $l;
      if ($c > $k) {
         $n = $f + $l;
         print "<a href='index.php?page=$page&f=$n&l=$l' class='w3-button w3-border-left w3-right'>&#10095;</a>";
      }
      ?>
   </div>
   <br><br>
</div>
