<?php
include_once "../db/env.php";

class collectorsDB{
   public $mysqli;

   function __construct(){
      $this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

      if ($this->mysqli->connect_error) {
         die("Connection failed: " . $this->mysqli->connect_error);
      }
   }

   function __destruct(){
      $this->mysqli->close();
   }

   function mysqlSafe($text){
      return $this->mysqli->real_escape_string($text);
   }

   function isNumericSafe($text){
      return (is_numeric($text)) ? ($this->mysqlSafe($text)) : -1;
   }

   function newCollector($id, $name,$tele){
      $time =  date("y-m-d H:i:s");
      $name = $this->mysqlSafe($name);
      $tele = $this->mysqlSafe($tele);

      $sql = "INSERT INTO `collector` (`collectorId`, `phoneNo`, `name`, `rateCount`, `rateScore`, `lastCollectionAttempt`) VALUES ($id, '$tele', '$name', '0', '5', '$time');";
      return $this->query($sql);
   }

   function exist($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collector` WHERE `collectorId` = '$id';";
      return $this->exists($sql);
   }

   function getCollectorData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collector` WHERE `collectorId` = '$id';";
      return $this->getDataRow($sql);
   }

   function setCollectorData($id, $field, $value){
      $id =  $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `collector` SET `$field` = '$value' WHERE `collectorId` = '$id';";
      return $this->query($sql);
   }

   function delete($id){
      $id =  $this->isNumericSafe($id);
      $sql = "DELETE FROM `collector` WHERE `collectorId` = '$id';";
      return $this->query($sql);
   }

   function list($f, $l){
      $f = $this->isNumericSafe($f);
      $l = $this->isNumericSafe($l);
      $sql = "SELECT collectorId,name,rateCount,phoneNo FROM `collector` WHERE 1 LIMIT $f,$l;";
      return $this->listWholeRows($sql);
   }
   function count(){
      return $this->count_rows('collector');
   }

   function getCollectorName($id){
      $data = $this->getCollectorData($id);
      return $data['name'];
   }

   //----------------------------------------------------
   //Function to list collectors working in a certain area

   function listCollectorsByArea($areaName){
      $areaName = $this->mysqlSafe($areaName);
      $sql = "SELECT collector.collectorId,name,rateCount,phoneNo FROM area,collector,collector_area WHERE (areaName = '$areaName') AND (area.areaId = collector_area.areaId) AND (collector_area.collectorId = collector.collectorId);";

      return $this->listWholeRows($sql);
   }
   //----------------------------------------------------

   //----------------------------------------------------
   //Function to list collectors who have incomplete or pending pickups

   function listCollectorsbyPickupState($state){
      $state = $this->mysqlSafe($state);
      $sql = "SELECT collector.collectorId,name,phoneNo,pickupId FROM pickups,collector WHERE (state = '$state') AND (pickups.collectorId = collector.collectorId);";
      return $this->listWholeRows($sql);

   }
   //----------------------------------------------------

   //----------------------------------------------------
   //Function to list collectors with pickup count in a given area

   function listCollectorswithPickupCount($areaName){
      $areaName = $this->mysqlSafe($areaName);
      $sql = "SELECT DISTINCT collector.collectorId,name,phoneNo,areaName,rateCount, (SELECT COUNT(*) FROM pickups WHERE pickups.collectorId = collector.collectorId)AS pickupCount FROM collector,pickups,area,collector_area WHERE (areaName = '$areaName') AND (collector_area.areaId = area.areaId) AND (collector.collectorId = collector_area.collectorId);";
      return $this->listWholeRows($sql);
   }


   function listPendingCollectors(){
      $sql = "SELECT id,tele,name FROM `telco_collectors` WHERE regStatus='PENDING_APPROVAL'";
      return $this->listWholeRows($sql);
   }

   function getPendingCollectorData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `telco_collectors` WHERE `id` = '$id';";
      return $this->getDataRow($sql);
   }

   function setPendingCollectorData($id, $field, $value){
      $id =  $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `telco_collectors` SET `$field` = '$value' WHERE `id` = '$id';";
      return $this->query($sql);
   }



   //----------------------------------------------------

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

   function count_rows($database){
      $sql = "SELECT COUNT(*) FROM `$database`;";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['COUNT(*)'];
   }

   // Query Functions -----------------------------------------------------------------------------------------------

   function q_Update($table, $key, $value, $field, $new){
      $sql = "UPDATE `$table` SET `$field` = '$new' WHERE `$key` = '$value';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function q_Select($table, $key, $value, $field){
      $sql = "SELECT * FROM `$table` WHERE `$key`.`id` = '$value';";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()[$field];
   }

   function q_Delete($table, $field, $value){
      $sql = "DELETE FROM `$table` WHERE `$field` = '$value';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function q_Exist($table, $field, $value){
      $sql = "SELECT * FROM `$table` WHERE `$field` LIKE '$value';";

      if ($result = $this->mysqli->query($sql)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   function q_List($table, $field, $option){
      $sql = "SELECT * FROM `$table` WHERE $option";
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
}
