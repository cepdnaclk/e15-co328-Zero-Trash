<?php
include_once "../db/env.php";

class customerDB{
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


   function list($f, $l){
      $f = $this->isNumericSafe($f);
      $l = $this->isNumericSafe($l);
      $sql = "SELECT c.customerId,firstName,lastName,email FROM `customer` as c , `regular_customer` as r WHERE r.`customerId`= c.`customerId` LIMIT $f,$l ;";
      return $this->listWholeRows($sql);
   }

   function count(){
      return $this->count_rows('customer');
   }

   function newCustomer($tele, $email, $pass, $addrL1, $addrL2, $city, $municiple, $regDate, $type, $lang){

      $tele=$this->mysqlSafe($tele);
      $email=$this->mysqlSafe($email);
      $pass=$this->mysqlSafe($pass);
      $addrL1=$this->mysqlSafe($addrL1);
      $addrL2=$this->mysqlSafe($addrL2);
      $city=$this->mysqlSafe($city);

      $areaId=$this->getAreaId($municiple);

      $regDate=$this->mysqlSafe($regDate);
      $type=$this->mysqlSafe($type);
      $lang=$this->mysqlSafe($lang);

      $sql = "INSERT INTO `customer` (`customerId`, `phoneNo`, `email`, `address1`, `address2`, `city`, `municipalCouncil`, `regDate`, `regStatus`, `password`, `loyality`, `Type`, `language`)
      VALUES (NULL, '$tele', '$email', '$addrL1', '$addrL2', '$city', '$municiple', '$regDate', 'ACTIVE', '$pass', '0', '$type', '$lang');";

      return  ($this->mysqli->query($sql));

   }

   //---------------------------------------------------
   //Function to get areaId using area name
   function getAreaId($municiple){
      $municiple=$this->mysqlSafe($municiple);
      $sql = "SELECT areaId FROM `area` WHERE `areaName` LIKE '$municiple';";

      return  ($this->mysqli->query($sql));
   }
   //----------------------------------------------------
   //Function to list regular customers in a certain area

   function listCustomersByArea($areaName,$f, $l){
      $areaName = $this->mysqlSafe($areaName);
      $f = $this->isNumericSafe($f);
      $l = $this->isNumericSafe($l);
      $sql = "SELECT customer.customerId,firstName,lastName,email FROM area,customer,regular_customer WHERE (areaName LIKE '$areaName') AND (area.areaId = customer.areaId) AND (customer.customerId = regular_customer.customerId) LIMIT $f,$l;";
      return $this->listWholeRows($sql);
   }
   
   function countCustomersByArea($areaName){
      $areaName = $this->mysqlSafe($areaName);
      $sql = "SELECT customer.customerId FROM area,customer,regular_customer WHERE (areaName LIKE '$areaName') AND (area.areaId = customer.areaId) AND (customer.customerId = regular_customer.customerId);";
      return $this->count_query($sql);
   }
   //----------------------------------------------------

   //----------------------------------------------------
   //Function to list customers with pickup count in a given area


   function listCustomersWithPickupCount($areaName,$f, $l){
      $areaName = $this->mysqlSafe($areaName);
      $f = $this->isNumericSafe($f);
      $l = $this->isNumericSafe($l);
      $sql = "SELECT DISTINCT customer.customerId,firstName,lastName,phoneNo,email, (SELECT COUNT(*) FROM pickups WHERE pickups.customerId = customer.customerId) AS pickupCount FROM customer,regular_customer,area WHERE (areaName = '$areaName') AND (customer.areaId = area.areaId) AND (regular_customer.customerId = customer.customerId) LIMIT $f,$l;";

      return $this->listWholeRows($sql);
   }


   //----------------------------------------------------
   function existCustomer($tele){
      $tele =$this->mysqlSafe($tele);
      $sql = "SELECT `phoneNo` FROM `customer` WHERE `phoneNo` LIKE '$tele';";
      return ($this->exists($sql));
   }

   function existCustomer_byEmail($email){
      $email =$this->mysqlSafe($email);
      $sql = "SELECT `phoneNo` FROM `customer` WHERE `email` LIKE '$email';";
      return ($this->exists($sql));
   }

   function getCustomerId_byTele($tele){
      $tele =$this->mysqlSafe($tele);
      $sql = "SELECT `customerId` FROM `customer` WHERE  `phoneNo`='$tele';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['customerId'];
   }

   function getCustomerId_byEmail($email){
      $email =$this->mysqlSafe($email);
      $sql = "SELECT `customerId` FROM `customer` WHERE  `email`='$email';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['customerId'];
   }
   function getCustomerData($id, $field){
      $id =$this->isNumericSafe($id);
      $field =$this->mysqlSafe($field);
      if($field == 'municipalCouncil'){
         $field = 'areaName';
         $sql = "SELECT `areaName` FROM `customer`,`area` WHERE  `customerId`=$id AND (customer.areaId = area.areaId);";
      }
      else {
         $sql = "SELECT `$field` FROM `customer` WHERE  `customerId`='$id';";
      }

      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row[$field];
   }

   function newRegularCustomer($id, $fName, $lName){
      $id =$this->isNumericSafe($id);
      $fName =$this->mysqlSafe($fName);
      $lName =$this->mysqlSafe($lName);
      $sql = "INSERT INTO `regular_customer` (`customerId`, `firstName`, `lastName`)
      VALUES ('$id', '$fName', '$lName');";
      return  ($this->mysqli->query($sql));
   }

   function verifyUser($type, $value, $password){
      if($type=="phone"){
         $column = "phoneNo";
      }else{
         $column = "email";
      }
      $value =$this->mysqlSafe($value);
      $password =$this->mysqlSafe($password);

      $query = "SELECT `$column` FROM `customer` WHERE `$column` LIKE '$value' AND `password` = '$password';";

      if ($result = $this->mysqli->query($query)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   public function getCustomerName($id){
      $id =$this->isNumericSafe($id);
      $sql = "SELECT * FROM `regular_customer` WHERE `customerId` = $id";
      $data = $this->getDataRow($sql);
      return $data['firstName']." ".$data['lastName'];
   }

   public function getCustomerAddress($id){
      $id =$this->isNumericSafe($id);
      $sql = "SELECT * FROM `customer` WHERE `customerId` = $id";
      $data = $this->getDataRow($sql);
      return $data['address1'].", ".$data['address2'].", ".$data['city'];
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
   function count_query($sql){
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
