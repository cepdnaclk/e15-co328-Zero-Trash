<?php
class database{

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

   function get_Data($key){
      $sql = "SELECT * FROM `telco_data` WHERE `cKey` LIKE '$key'";

      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();

      $value = $row["cVal"];
      return $value;
   }

   function set_Data($key, $value){
      $sql = "UPDATE `telco_data` SET `cVal`='$value' WHERE `cKey`='$key';";
      $this->mysqli->query($sql);
   }

   //**** Customers *******************************************

   function newCustomer($tele, $email, $pass, $addrL1, $addrL2, $city, $areaId, $regDate, $type, $lang){

      $sql = "INSERT INTO `customer` (`customerId`, `phoneNo`, `email`, `address1`, `address2`, `city`, `areaId`, `regDate`, `regStatus`, `password`, `loyality`, `customerType`, `language`)
      VALUES (NULL, '$tele', '$email', '$addrL1', '$addrL2', '$city', '$areaId', '$regDate', 'ACTIVE', '$pass', '0', '$type', '$lang');";

      return  ($this->mysqli->query($sql));

   }
   // ###############################################################
   function getAreaId($municiple){
      $sql = "SELECT `areaId` FROM `area` WHERE `areaName` LIKE '$municiple';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['areaId'];
   }
   // ###############################################################
   function updatePassword($id, $password){
      $sql = "UPDATE `customer` SET `password`='$password'  WHERE `customerId` = $id;";
      //echo $sql;
      return  ($this->mysqli->query($sql));
   }

   function updateCustomer($id, $addrL1, $addrL2, $city, $municiple, $lang){

      $sql = "UPDATE `customer` SET `address1`='$addrL1', `address2`='$addrL2', `city`='$city', `municipalCouncil`='$municiple', `language`='$lang' WHERE `customerId` = $id;";
      //echo $sql;
      return  ($this->mysqli->query($sql));
   }


   function existCustomer($tele){
      $query = "SELECT `phoneNo` FROM `customer` WHERE `phoneNo` LIKE '$tele';";

      if ($result = $this->mysqli->query($query)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }
   function existCustomer_byEmail($email){
      $query = "SELECT `phoneNo` FROM `customer` WHERE `email` LIKE '$email';";

      if ($result = $this->mysqli->query($query)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   function getCustomerId_byTele($tele){
      $sql = "SELECT `customerId` FROM `customer` WHERE  `phoneNo`='$tele';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['customerId'];
   }

   function getCustomerId_byEmail($email){
      $sql = "SELECT `customerId` FROM `customer` WHERE  `email`='$email';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['customerId'];
   }
   function getCustomerData($id, $field){
      $sql = "SELECT `$field` FROM `customer` WHERE  `customerId`='$id';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row[$field];
   }


   function getRegularCustomerData($id, $field){
      $sql = "SELECT `$field` FROM `regular_customer` WHERE  `customerId`='$id';";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row[$field];
   }

   function newRegularCustomer($id, $fName, $lName){
      $sql = "INSERT INTO `regular_customer` (`customerId`, `firstName`, `lastName`)
      VALUES ('$id', '$fName', '$lName');";
      return  ($this->mysqli->query($sql));
   }

   function updateRegularCustomer($id, $fName, $lName){
      $sql = "UPDATE `regular_customer` SET `firstName` = '$fName', `lastName` = '$lName' WHERE `customerId`=$id ;";
      //echo $sql;
      return  ($this->mysqli->query($sql));
   }

   function verifyUser($type, $value, $password){
      if($type=="phone"){
         $column = "phoneNo";
      }else{
         $column = "email";
      }
      $query = "SELECT `$column` FROM `customer` WHERE `$column` LIKE '$value' AND `password` = '$password';";

      if ($result = $this->mysqli->query($query)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   //**** Pickups *******************************************




   //**** User data *******************************************

   function new_User($id, $address, $time, $operator, $plan){
      $sql = "INSERT INTO `telco_users` (`id`, `address`, `regStatus`, `dateRegistered`, `lastUsed`, `operator`, `chargingPlan`)
      VALUES ('$id', '$address', 'PENDING', '$time', '$time', '$operator', '$plan');";

      return $this->mysqli->query($sql);
   }

   function get_RegState_ByAddress($address){
      $sql = "SELECT `regStatus` FROM `telco_users` WHERE `address` = '$address';";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()['regStatus'];
   }

   function get_RegState_ById($id){
      $sql = "SELECT  `regStatus` FROM `telco_users` WHERE `id` = '$id';";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()['regStatus'];
   }

   function get_RegDate_ById($id){
      $sql = "SELECT `regDate` FROM `telco_users` WHERE `id` = '$id';";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()['regDate'];
   }

   function get_LastUsed_ById($id){
      $sql = "SELECT `lastUsed` FROM `telco_users` WHERE `telco_users`.`id` = '$id';";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()['lastUsed'];
   }

   function get_UserId_ByAddress($address){
      $sql = "SELECT `id` FROM `telco_users` WHERE `address` LIKE '$address'";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()['id'];
   }

   function get_Address_ById($id){
      $sql = "SELECT `address` FROM `telco_users` WHERE `id` LIKE '$id'";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()['address'];
   }

   function set_RegState($address, $state){
      $sql = "UPDATE `telco_users` SET `regStatus` = '$state' WHERE `telco_users`.`address` = '$address';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function set_UserName($address, $userName){
      $sql = "UPDATE `telco_users` SET `userName` = '$userName' WHERE`address` = '$address';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function set_UserTele($address, $userTele){
      $sql = "UPDATE `telco_users` SET `tele` = '$userTele' WHERE`address` = '$address';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function get_UserList($key){
      $query = "SELECT * FROM `telco_users` WHERE `regStatus` LIKE 'REGISTERED'";
      if ($result = $this->mysqli->query($query)) {
         $j = 0;
         $arAdd = array();

         while ($row = mysqli_fetch_array($result)) {
            $arAdd[$j] = $row[$key];
            $j++;
         }
         return $arAdd; // As array
      } else {
         return 0;
      }
   }

   function get_userCount(){
      $sql = "SELECT COUNT(*) FROM `telco_users` WHERE `regStatus` LIKE 'REGISTERED';";
      $result = $this->mysqli->query($sql);
      $result = $result->fetch_assoc();
      return $result['COUNT(*)'];
   }

   function delete_User_ByAddress($address){
      $sql = "DELETE FROM `telco_users` WHERE `address` = '$address';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function delete_User_ById($id){
      $sql = "DELETE FROM `telco_users` WHERE `id` = '$id';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function userAddress_Exist($address){
      $query = "SELECT `address` FROM `telco_users` WHERE `address` LIKE '$address';";
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
   function  userId_Exist($id){

      $query = "SELECT `id` FROM `telco_users` WHERE `id` LIKE '$id';";
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

   //**** App usage history ***********************************************

   function set_LastUsed_ById($userId, $time){
      $sql = "UPDATE `telco_users` SET `lastUsed` = '$time' WHERE `id` = $userId;";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function get_History($key)
   {
      $query = "SELECT `$key` FROM `app_history` WHERE 1 ORDER BY `dateHis` DESC";
      if ($result = $this->mysqli->query($query)) {
         $j = 0;
         $arAdd = array();

         while ($row = mysqli_fetch_array($result)) {
            $arAdd[$j] = $row[$key];
            $j++;
         }
         return $arAdd; // As array
      } else {
         return 0;
      }
   }

   function delete_History($days){
      $sql = "DELETE FROM `app_history` WHERE `dateHis` < '$days';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function sqlSafe($text)
   {
      $text = str_replace("'", "\"", $text);
      $text = str_replace("`", "\"", $text);

      return $text;
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
