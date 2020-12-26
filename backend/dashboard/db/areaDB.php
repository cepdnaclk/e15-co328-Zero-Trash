<?php
include_once "../db/env.php";

class areaDB{
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

   //-- Area ---------------------------------------------------------------

   function getAreaId($municiple){
      $sql = "SELECT `areaId` FROM `area` WHERE `areaName` LIKE '$municiple';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['areaId'];
   }

   function newArea($areaName, $collectingPoint, $notes){
      $areaName = $this->mysqlSafe($areaName);
      $collectingPoint = $this->isNumericSafe($collectingPoint);
      $notes = $this->mysqlSafe($notes);

      $sql = "INSERT INTO `area` (`areaId`, `areaName`, `collectingPointId`, `notes`)
      VALUES (NULL, '$areaName', '$collectingPoint', '$notes');";
      return $this->query($sql);
   }

   function existArea($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `area` WHERE `areaId` = '$id';";
      return $this->exists($sql);
   }
   function existArea_byName($name){
      $name = $this->mysqlSafe($name);
      $sql = "SELECT * FROM `area` WHERE `areaName` = '$name';";
      //echo $sql;
      return $this->exists($sql);
   }

   function listArea(){
      $sql = "SELECT * FROM `area` WHERE 1;";
      return $this->listWholeRows($sql);
   }

   function getAreaData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `area` WHERE `areaId` = '$id';";
      return $this->getDataRow($sql);
   }

   function setAreaData($id, $field, $value){
      $id =  $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `area` SET `$field` = '$value' WHERE `areaId` = '$id';";
      return $this->query($sql);
   }

   function deleteArea($id){
      $id =  $this->isNumericSafe($id);
      $sql = "DELETE FROM `area` WHERE `areaId` = '$id';";
      return $this->query($sql);
   }

   function countArea(){
      return $this->count_rows('area');
   }

   //-- Collector Area ---------------------------------------------------------------


   function newCollectorArea($areaId, $collectorId){
      $areaId =  $this->isNumericSafe($areaId);
      $collectorId =  $this->isNumericSafe($collectorId);

      $sql = "INSERT INTO `collector_area` (`collectorId`, `areaId`, `experienceScore`, `availibility`)
      VALUES ('$collectorId','$areaId', '0', 'AVAILABLE');";

      //echo $sql;
      return $this->query($sql);
   }

   function existCollectorArea($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collector_area` WHERE `id` = '$id';";
      return $this->exists($sql);
   }

   function listCollectorArea(){
      $sql = "SELECT * FROM `collector_area` WHERE 1;";
      return $this->listWholeRows($sql);
   }

   function listCollectorArea_byCollector($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collector_area` WHERE `collectorId` = $id;";
      return $this->listWholeRows($sql);
   }

   function getCollectorAreaData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collector_area` WHERE `id` = '$id';";
      return $this->getDataRow($sql);
   }

   function existsCollectorArea($areaId,$collectorId){
      $areaId =  $this->isNumericSafe($areaId);
      $collectorId =  $this->isNumericSafe($collectorId);
      $sql = "SELECT * FROM `collector_area` WHERE `collectorId` = '$collectorId' AND `areaId` = '$areaId';";
      return $this->exists($sql);
   }

   function setCollectorAreaData($id, $field, $value){
      $id =  $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `collector_area` SET `$field` = '$value' WHERE `id` = '$id';";
      return $this->query($sql);
   }

   function deleteCollectorArea($id){
      $id =  $this->isNumericSafe($id);
      $sql = "DELETE FROM `collector_area` WHERE `id` = '$id';";
      return $this->query($sql);
   }

   function getCollectorAreaCount(){
      return $this->count_rows('collector_area');
   }

   function getRegionSuggestions($filter){
      $filter = $this->mysqlSafe($filter);

      $sql = "SELECT `areaId`, `areaName` FROM `area` WHERE `areaName` LIKE '$filter%';";
      $result = $this->listWholeRows($sql);
      if (sizeof($result) > 0) {

         $arAdd = array();
         for($i=0;$i<sizeof($result);$i++){
            $arAdd[$i] = $result[$i]['areaName'];
         }
         return array_unique(array_map('trim',$arAdd));

      } else {
         return array();
      }
      return ;
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
