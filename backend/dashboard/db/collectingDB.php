<?php
include_once "../db/env.php";

class collectingDB{
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

   //-- Materils ---------------------------------------------------------------

   function newMaterial($name, $description, $unitValue, $notes){
      $name = $this->mysqlSafe($name);
      $description = $this->mysqlSafe($description);
      $unitValue = $this->mysqlSafe($unitValue);
      $notes = $this->mysqlSafe($notes);

      $sql = "INSERT INTO `materials` (`materialId`, `materialName`, `materialDescription`, `materialValue`, `materialNotes`) VALUES (NULL, '$name', '$description', '$unitValue', '$notes');";
      return $this->query($sql);
   }

   function existsMaterial($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `materials` WHERE `materialId` = '$id';";
      return $this->exists($sql);
   }

   function listMaterials(){
      $sql = "SELECT * FROM `materials` WHERE 1;";
      return $this->listWholeRows($sql);
   }

   function getMaterialData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `materials` WHERE `materialId` = '$id';";
      return $this->getDataRow($sql);
   }

   function setMaterialData($id, $field, $value){
      $id =  $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `materials` SET `$field` = '$value' WHERE `materialId` = '$id';";
      return $this->query($sql);
   }

   function deleteMaterial($id){
      $id =  $this->isNumericSafe($id);
      $sql = "DELETE FROM `materials` WHERE `materialId` = '$id';";
      return $this->query($sql);
   }

   function getMaterialCount(){
      return $this->count_rows('materials');
   }

   function getMaterialSuggestions($filter){
      $filter = $this->mysqlSafe($filter);

      $sql = "SELECT `materialName` FROM `materials` WHERE `materialName` LIKE '$filter%';";
      $result = $this->listWholeRows($sql);
      if (sizeof($result) > 0) {

         $arAdd = array();
         for($i=0;$i<sizeof($result);$i++){
            $arAdd[$i] = $result[$i]['materialName'];
         }
         return array_unique(array_map('trim',$arAdd));

      } else {
         return array();
      }
      return ;
   }

   function listPickups(){
      $sql = "SELECT pickups.pickupId,name,state,placedOn FROM `pickups`,`collector` WHERE (pickups.collectorId = collector.collectorId);";
      return $this->listWholeRows($sql);
   }


   //-- Collected Waste --------------------------------------------------------

   function newWaste($materialId, $pickupId, $amount, $dateTime, $notes){

      $materialId =  $this->isNumericSafe($materialId);
      $pickupId =  $this->isNumericSafe($pickupId);
      $amount = $this->mysqlSafe($amount);
      $dateTime =  $this->mysqlSafe($dateTime);
      $notes =  $this->mysqlSafe($notes);

      $sql = "INSERT INTO `collected_materials` (`collectedOn`, `materialId`, `pickupId`, `amount`, `notes`)
      VALUES ('$dateTime', '$materialId', '$pickupId', '$amount', '$notes');";

      echo $sql;

      return $this->query($sql);
   }

   function existsWaste($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collected_materials` WHERE `id` = '$id';";
      return $this->exists($sql);
   }

   function getWasteData($id){
      $id =  $this->isNumericSafe($id);
      $sql = "SELECT * FROM `collected_materials` WHERE `id` = '$id';";
      return $this->getDataRow($sql);
   }

   function setWasteData($id, $field, $value){
      $id =  $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `collected_materials` SET `$field` = '$value' WHERE `id` = '$id';";
      return $this->query($sql);
   }

   function listWaste($from, $limit){

      $from =  $this->isNumericSafe($from);
      $limit =  $this->isNumericSafe($limit);
      $sql = "SELECT * FROM `collected_materials` WHERE 1 ORDER BY `collectedOn` DESC LIMIT $from,$limit;";
      return $this->listWholeRows($sql);
   }

   function listWaste_inPickup($pickupId){

      $pickupId = $this->isNumericSafe($pickupId);
      $sql = "SELECT `id`, `materialName`,`materialValue`, `amount`,(amount * materialValue) AS value FROM `materials`,`collected_materials` WHERE `pickupId`='$pickupId' AND (materials.materialId = collected_materials.materialId);";
      return $this->listWholeRows($sql);
   }

   function listWasteNotInPickup($pickupId){
      $pickupId =  $this->isNumericSafe($pickupId);
      $sql = "SELECT materialId, materialName FROM materials as m WHERE m.materialId NOT IN (SELECT `materialId` FROM collected_materials WHERE pickupId=$pickupId)";
      return $this->listWholeRows($sql);
   }

   function deleteWaste($id){
      $id =  $this->isNumericSafe($id);
      $sql = "DELETE FROM `collected_materials` WHERE `id` = '$id';";
      return $this->query($sql);
   }

   function getWasteCount(){
      return $this->count_rows('collected_materials');
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
