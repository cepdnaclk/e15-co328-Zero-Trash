
<?php
include_once "../db/env.php";

class serviceDB
{
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

   /*---- Site Service ------------------------------------------------------------------------*/

   function add_service($code, $name, $url, $permission, $icon, $data){

      $code = $this->mysqlSafe($code);
      $name = $this->mysqlSafe($name);
      $url = $this->mysqlSafe($url);
      $permission = $this->mysqlSafe($permission);
      $icon = $this->mysqlSafe($icon);
      $data = $this->mysqlSafe($data);

      $sql = "INSERT INTO `dashboard_services` (`id`, `serviceCode`, `serviceName`, `serviceIcon`, `serviceURL`, `servicePermission`, `serviceData`)
      VALUES (NULL, '$code', '$name', '$icon', '$url', '$permission', '$data');";

      if ($this->mysqli->query($sql) == TRUE) {
         return true;
      } else {
         return false;
      }
   }

   function delete_service($id){
      $id = $this->isNumericSafe($id);
      $sql = "DELETE FROM `dashboard_services` WHERE `id` = '$id';";

      return ($this->mysqli->query($sql) == TRUE);
   }



   function update_service($id, $field, $value){

      $id = $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $value = $this->mysqlSafe($value);
      $sql = "UPDATE `dashboard_services` SET `$field` = '$value' WHERE `id` = '$id';";

      return ($this->mysqli->query($sql));
   }

   function list_services($field){
      $field = $this->mysqlSafe($field);
      $sql = "SELECT * FROM `dashboard_services` WHERE 1 ORDER BY `id` ASC";

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

   function get_serviceData($id, $field){
      $id = $this->isNumericSafe($id);
      $field = $this->mysqlSafe($field);
      $sql = "SELECT * FROM `dashboard_services` WHERE `id` = '$id';";

      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();

      $res = $row[$field];
      return $res;
   }

   function get_serviceData_byServiceCode($code, $field){
      $code = $this->mysqlSafe($code);
      $field = $this->mysqlSafe($field);
      $sql = "SELECT * FROM `dashboard_services` WHERE `serviceCode` = '$code';";

      $result = $this->mysqli->query($sql);
      $row = $result->fetch_assoc();

      $res = $row[$field];
      return $res;
   }

   /*---- User Services ------------------------------------------------------------------------*/

   function  add_userService($userId, $serviceCode, $enabledOn, $enabledBy){
      $userId = $this->isNumericSafe($userId);
      $serviceCode = $this->mysqlSafe($serviceCode);
      $enabledOn = $this->mysqlSafe($enabledOn);
      $enabledBy = $this->mysqlSafe($enabledBy);

      $sql = "INSERT INTO `dashboard_user_services` (`id`, `userId`, `serviceCode`, `enabledOn`, `enabledBy`)
      VALUES (NULL, '$userId', '$serviceCode', '$enabledOn', '$enabledBy');";

      return  ($this->mysqli->query($sql));
   }

   function  remove_userService($userId, $serviceCode){
      $userId = $this->mysqlSafe($userId);
      $serviceCode = $this->mysqlSafe($serviceCode);
      $sql = "DELETE FROM `dashboard_user_services`  WHERE ((`userId` = '$userId') AND (`serviceCode` LIKE '$serviceCode'));";

      return ($this->mysqli->query($sql));
   }

   function delete_serviceFromUsers($serviceCode){
      $serviceCode = $this->mysqlSafe($serviceCode);
      $sql = "DELETE FROM `dashboard_user_services`  WHERE (`serviceCode` LIKE '$serviceCode');";
      return ($this->mysqli->query($sql));
   }

   function list_userServices($userId, $field){

      $userId = $this->isNumericSafe($userId);
      $field = $this->mysqlSafe($field);

      $sql = "SELECT * FROM `dashboard_user_services` WHERE `userId` = '$userId'";
      if ($result = $this->mysqli->query($sql)) {
         $j = 0;
         $arAdd = array();

         while ($row = mysqli_fetch_array($result)) {
            $arAdd[$j] = $row[$field];
            $j++;
         }
         return $arAdd;
      } else {
         return array();
      }
   }

   function exist_userService($userId, $serviceCode){

      $userId = $this->mysqlSafe($userId);
      $serviceCode = $this->mysqlSafe($serviceCode);

      $sql = "SELECT * FROM `dashboard_user_services` WHERE ((`userId` LIKE '$userId') AND (`serviceCode` LIKE '$serviceCode')) ;";
      //echo $sql;
      if ($result = $this->mysqli->query($sql)) {
         if ($result->num_rows > 0) {
            return 1;
         } else {
            return 0;
         }
      } else {
         return 0;
      }
   }

   /*---- Super Methods ------------------------------------------------------------------------*/

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
      $sql = "SELECT * FROM `$table` WHERE `$field` LIKE '$value';";

      if ($result = $this->mysqli->query($sql)) {
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

   private function sqlSafe($text)
   {
      $text = str_replace("'", "\"", $text);
      $text = str_replace("`", "\"", $text);

      return $text;
   }
}
