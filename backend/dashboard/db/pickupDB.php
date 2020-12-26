<?php
class pickupDB{

   private $mysqli;

   function __construct()
   {
      $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

      if ($this->mysqli->connect_error) {
         die("Connection failed: " . $this->mysqli->connect_error);
      }
   }
   function __destruct()
   {
      $this->mysqli->close();
   }

   function mysqlSafe($text){
      return $this->mysqli->real_escape_string($text);
   }

   function isNumericSafe($text){
      return (is_numeric($text)) ? ($this->mysqlSafe($text)) : -1;
   }

   //**** Pickups *******************************************

   function newPickup($timeslot, $date, $customer, $address, $tele){

      $timeslot = $this->mysqlSafe($timeslot);
      $date = $this->mysqlSafe($date);
      $customer = $this->mysqlSafe($customer);
      $address = $this->mysqlSafe($address);
      $tele = $this->mysqlSafe($tele);

      $sql = "INSERT INTO `pickups` (`pickupId`, `timeSlot`, `placedOn`, `state`, `rating`, `notes`, `customerId`, `collectorId`, `address`, `userPhone`, `geoLocation`) VALUES (NULL, '$timeslot', '$date', 'PENDING', NULL, NULL,'$customer', NULL, '$address', '$tele', 'NULL');";
      return $this->mysqli->query($sql);
   }

   function delete($id){
      $id = $this->isNumericSafe($id);
      $sql = "DELETE FROM `pickups` WHERE `pickupId` = '$id';";
      return $this->mysqli->query($sql);
   }

   function existPickup($id){
      $id = $this->isNumericSafe($id);
      $sql = "SELECT `pickupId` FROM `pickups` WHERE `pickupId` = '$id';";
      return $this->exists($sql);
   }

   function update($id, $key, $value){
      $id = $this->isNumericSafe($id);
      $key = $this->mysqlSafe($key);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `pickups` SET `$key` = '$value' WHERE `pickupId` = '$id';";
      return $this->mysqli->query($sql);
   }

   function list($filter){

      $sql = "SELECT * FROM `pickups` WHERE $filter;";
      return $this->listWholeRows($sql);
   }

   function list_byCustomerId($customerId, $from, $limit){
      $customerId = $this->isNumericSafe($customerId);
      $from = $this->mysqlSafe($from);
      $limit = $this->isNumericSafe($limit);

      $sql = "SELECT * FROM `pickups` WHERE `customerId`='$customerId'  ORDER BY `placedOn` DESC LIMIT $from,$limit;";
      return $this->listWholeRows($sql);
   }

   function list_byCollectorId($collectorId, $from, $limit){
      $collectorId = $this->isNumericSafe($collectorId);
      $from = $this->mysqlSafe($from);
      $limit = $this->isNumericSafe($limit);

      $sql = "SELECT * FROM `pickups` WHERE `collectorId`='$collectorId' ORDER BY `placedOn` DESC LIMIT $from,$limit;";
      return $this->listWholeRows($sql);
   }

   function countPending(){
      $sql = "SELECT COUNT(*) FROM `pickups` WHERE `state`='PENDING'";
      return $this->count($sql);
   }
   function countCompleted(){
      $sql = "SELECT COUNT(*) FROM `pickups` WHERE `state`='COMPLETED'";
      return $this->count($sql);
   }
   function countIncomplete(){
      $sql = "SELECT COUNT(*) FROM `pickups` WHERE `state`='INCOMPLETED'";
      return $this->count($sql);
   }

   function getPickupData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `pickups` WHERE `pickupId` = '$id';";
      return $this->getDataRow($sql);
   }

   function listPickupsByState($state, $f, $l){
      $state = $this->mysqlSafe($state);
      $f = $this->isNumericSafe($f);
      $l = $this->isNumericSafe($l);

      // SELECT * FROM `pickups` as p, `area` as a, `customer`as c WHERE a.areaId = c.areaId AND  c.customerId = p.customerId


      // ,`area`,`customer`
      $sql = "SELECT c.customerId, a.areaName, p.collectorId, p.placedOn, p.rating FROM `pickups` as p, `area` as a, `customer`as c WHERE a.areaId = c.areaId AND  c.customerId = p.customerId AND `state`='$state' LIMIT $f,$l;";

      return $this->listWholeRows($sql);
      }

      function countPickupsByState($state){
      $state = $this->mysqlSafe($state);
      $sql = "SELECT COUNT(*) FROM pickups WHERE state='$state' ";
      return $this->count($sql);
   }

   function getMaterialCountByWeek($material){
      $material = $this->mysqlSafe($material);
      if($material == "Plastic"){
         $material = 101;
      }
      elseif($material == "Paper"){
         $material = 102;
      }
      elseif($material == "Metal"){
         $material = 103;
      }
      else{
         return null;
      }
      $sql = "SELECT materialId,SUM(quantity) AS `amount` FROM pickups,collection  WHERE  YEARWEEK(`placedon`, 1) = YEARWEEK(CURDATE(), 1) AND (state = 'COMPLETED') AND (pickups.pickupId = collection.pickupId) AND (materialId = $material) GROUP BY materialId;";
      return $this->listWholeRows($sql);
   }

   function getMaterialCountByMonth($material){
      $material = $this->mysqlSafe($material);
      if($material == "Plastic"){
         $material = 101;
      }
      elseif($material == "Paper"){
         $material = 102;
      }
      elseif($material == "Metal"){
         $material = 103;
      }
      else{
         return null;
      }
      $sql = "SELECT materialId,SUM(quantity) AS `amount` FROM pickups,collection  WHERE  MONTH(placedon) = MONTH(CURRENT_DATE()) AND YEAR(placedon) = YEAR(CURRENT_DATE()) AND (state = 'COMPLETED') AND (pickups.pickupId = collection.pickupId) AND (materialId = $material) GROUP BY materialId;";
      return $this->listWholeRows($sql);
   }

   // Super Functions -----------------------------------------------------------------------------------------------

   public function query($sql){
      return $this->mysqli->query($sql);
   }

   function exists($sql){
      if ($result = $this->mysqli->query($sql)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   function getData($sql, $field){
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()[$field];
   }

   function getDataRow($sql){
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc();
   }

   function listRows($sql, $field){
      if ($result = $this->mysqli->query($sql)) {
         $j = 0;
         $arAdd = array();

         while ($row = mysqli_fetch_array($result)) {
            $arAdd[$j] = $row[$field];
            $j++;
         }
         return $arAdd;
      } else {
         return 0;
      }
   }

   function listWholeRows($sql){
      if ($result = $this->mysqli->query($sql)) {
         $j = 0;
         $arAdd = array();

         while ($row = mysqli_fetch_array($result)) {
            $arAdd[$j] = $row;
            $j++;
         }
         return $arAdd;
      } else {
         return 0;
      }
   }

   function deleteRow($sql){
      return ($this->mysqli->query($sql) == TRUE);
   }

   function count($sql){
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['COUNT(*)'];
   }

   function count_rows($database){
      $sql = "SELECT COUNT(*) FROM `$database`;";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['COUNT(*)'];
   }


   function q_Update($table, $key, $value, $field, $new)
   {
      $sql = "UPDATE `$table` SET `$field` = '$new' WHERE `$key` = '$value';";
      if ($this->mysqli->query($sql) == TRUE) {
         return true;
      } else {
         return false;
      }
   }

   function q_Select($table, $key, $value, $field)
   {
      $sql = "SELECT * FROM `$table` WHERE `$key`.`id` = '$value';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();

      $res = $row[$field];
      return $res;
   }

   function q_Delete($table, $field, $value)
   {
      $sql = "DELETE FROM `$table` WHERE `$field` = '$value';";
      if ($this->mysqli->query($sql) == TRUE) {
         return true;
      } else {
         return false;
      }
   }

   function q_Exist($table, $field, $value)
   {
      $query = "SELECT * FROM `$table` WHERE `$field` LIKE '$value';";

      if ($result = $this->mysqli->query($query)) {
         if ($result->num_rows > 0) {
            return 1;
         } else {
            return 0;
         }
      } else {
         return 0;
      }
   }

   function q_List($table, $field, $option)
   {

      $query = "SELECT * FROM `$table` WHERE $option";
      if ($result = $this->mysqli->query($query)) {
         $j = 0;
         $arAdd = array();

         while ($row = mysqli_fetch_array($result)) {
            $arAdd[$j] = $row[$field];
            $j++;
         }
         return $arAdd;
      } else {
         return 0;
      }
   }
}
