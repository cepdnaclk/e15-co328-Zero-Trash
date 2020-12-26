<?php
include_once "../db/env.php";

class database{
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

   function get_SiteData($key){
      $key = $this->mysqlSafe($key);
      $sql = "SELECT * FROM `dashboard_data` WHERE `dKey` LIKE '$key'";

      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $row['dValue'];
   }

   function set_SiteData($key, $dVal){
      $key = $this->mysqlSafe($key);
      $dVal = $this->mysqlSafe($dVal);
      $sql = "UPDATE `dashboard_data` SET `dValue` = '$dVal' WHERE `dashboard_data`.`dKey` LIKE '$key';";
      return $this->mysqli->query($sql);
   }

   // Login Related Functions -----------------------------------------------------------------------------------------

   function existsEmail($email){
      $email = mysqli_real_escape_string($this->mysqli, $email);
      $sql = "SELECT `email` FROM `dashboard_users` WHERE `email` LIKE '$email'";

      if ($result = $this->mysqli->query($sql)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   function existsUser($email, $password){
      $email = mysqli_real_escape_string($this->mysqli, $email);
      $pwdmd5 =sha1(md5($this->mysqlSafe($password)).$email);

      $sql = "SELECT `email` FROM `dashboard_users` WHERE `email` LIKE '$email' AND `password` LIKE '$pwdmd5';";

      if ($result = $this->mysqli->query($sql)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   function generatePassword($pw, $email){
      return  sha1(md5($this->mysqlSafe($np)).$this->mysqlSafe($email));

   }
   function existsUserId($userId){
      $userId = $this->isNumericSafe($userId);
      $sql = "SELECT `id` FROM `dashboard_users` WHERE `id` LIKE '$userId';";

      if ($result = $this->mysqli->query($sql)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   // User Related Functions ------------------------------------------------------------------------------------------

   function newUser($firstName, $lastName, $honorific, $email, $password, $role, $loginType, $imgURL){
      $firstName = $this->mysqlSafe($firstName);
      $lastName = $this->mysqlSafe($lastName);
      $email = $this->mysqlSafe($email);
      $lastAccess = date("y-m-d H:i:s");

      $sql = "INSERT INTO `dashboard_users` (`id`, `email`, `password`, `honorific`, `firstName`, `lastName`, `role`, `loginType`, `lastAccess`, `imageURL`)
      VALUES (NULL, '$email', '$password', '$honorific', '$firstName ', '$lastName', '$role', '$loginType', '$lastAccess', '$imgURL');";

      return $this->mysqli->query($sql);
   }

   function getUserId_byEmail($email){
      $email = $this->mysqlSafe($email);
      $sql = "SELECT `id` FROM `dashboard_users` WHERE `email` LIKE '$email'";
      $row = $this->mysqli->query($sql)->fetch_assoc();
      return $row['id'];
   }

   function getUserData($userId, $field){

      $userId = $this->isNumericSafe($userId);
      $field = $this->mysqlSafe($field);

      $sql = "SELECT `$field` FROM `dashboard_users` WHERE `id` LIKE $userId";
      $row = $this->mysqli->query($sql)->fetch_assoc();
      return $row[$field];
   }

   function setUserData($userId, $field, $value){
      $userId = $this->isNumericSafe($userId);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);

      $sql = "UPDATE `dashboard_users` SET `$field` = '$value' WHERE `id` = '$userId';";
      return $this->mysqli->query($sql);
   }

   function listUsers($field){
      $sql = "SELECT `$field` FROM `dashboard_users` WHERE 1";
      return $this->listRows($sql, $field);
   }

   function listUsers_asc($field, $from, $limit){
      $field = $this->mysqlSafe($field);
      $from = $this->isNumericSafe($from);
      $limit = $this->isNumericSafe($limit);
      $sql = "SELECT `$field` FROM `dashboard_users` WHERE 1 ORDER BY `id` ASC LIMIT $from,$limit ";
      return $this->listRows($sql, $field);
   }

   function deleteUser($userId){
      $userId = $this->isNumericSafe($userId);
      $sql = "DELETE FROM `dashboard_users` WHERE `id` LIKE '$userId';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function getName_byUserId($userId){
      $userId = $this->isNumericSafe($userId);
      $salutation = json_decode(file_get_contents("../lists/salutations.json"), true);

      $sql = "SELECT `honorific`, `firstName`, `lastName` FROM `dashboard_users` WHERE `id` LIKE $userId";
      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();
      return $salutation[$row['honorific']] . " " . $row['firstName'] . " " . $row['lastName'];
   }

   // Utility Functions -----------------------------------------------------------------------------------------------

   private function sqlSafe($text){
      $text = str_replace("'", "\"", $text);
      $text = str_replace("`", "\"", $text);

      return $text;
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

   function q_Select($table, $key, $value, $field)
   {
      $sql = "SELECT * FROM `$table` WHERE `$key`.`id` = '$value';";
      $result = $this->mysqli->query($sql);
      return $result->fetch_assoc()[$field];
   }

   function q_Delete($table, $field, $value)
   {
      $sql = "DELETE FROM `$table` WHERE `$field` = '$value';";
      return ($this->mysqli->query($sql) == TRUE);
   }

   function q_Exist($table, $field, $value)
   {
      $sql = "SELECT * FROM `$table` WHERE `$field` LIKE '$value';";

      if ($result = $this->mysqli->query($sql)) {
         return ($result->num_rows > 0);
      } else {
         return 0;
      }
   }

   function q_List($table, $field, $option)
   {
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
