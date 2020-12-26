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

   //**** Pickups *******************************************

   function newPickup($timeslot, $date, $customer, $address, $tele){
      $sql = "INSERT INTO `pickups` (`pickupId`, `timeSlot`, `placedOn`, `state`, `rating`, `notes`, `customerId`, `collectorId`, `address`, `userPhone`, `geoLocation`) VALUES (NULL, '$timeslot', '$date', 'PENDING', NULL, NULL,'$customer', NULL, '$address', '$tele', 'NULL');";
      //echo $sql;
      return $this->mysqli->query($sql);
   }

   function delete($id){
      $sql = "DELETE FROM `pickups` WHERE `pickupId` = '$id';";
      return $this->mysqli->query($sql);
   }

   function update($id, $key, $value){
      $sql = "UPDATE `pickups` SET `$key` = '$value' WHERE `pickupId` = '$id';";
      //echo $sql;
      return $this->mysqli->query($sql);
   }

   function list_byCustomerId($customerId, $from, $limit){
      $query = "SELECT * FROM `pickups` WHERE `customerId`='$customerId'  ORDER BY `placedOn` DESC LIMIT $from,$limit;";
      //echo $query;

      if ($result = $this->mysqli->query($query)) {
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

   function exists($id){
      $query = "SELECT `pickupId` FROM `pickups` WHERE `pickupId` = '$id';";

      if ($result = $this->mysqli->query($query)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   //**** Super Class Functions ***********************************************

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
