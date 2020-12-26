<?php

include_once '../data/session.php';
include_once '../db/database.php';

$db = new database();

$userId = $_SESSION['userId'];
$userName = $_SESSION['user'];

$action = 0;

$act = $_GET['act'];

if ($act == "update") {
   $salutation = $_POST['salutation'];
   $firstName = $_POST['firstName'];
   $lastName = $_POST['lastName'];

   $res += $db->setUserData($userId, "honorific", $salutation);
   $res += $db->setUserData($userId, "firstName", $firstName);
   $res += $db->setUserData($userId, "lastname", $lastName);

   if ($res == 3) {
      redirect("index.php?resp=1000");
      exit;
   } else {
      print "<br><br>Sorry, unknown error occurred.<br><br><a href='index.php'>Back</a>";
   }

} else if ($act == "login") {
   $email = $db->getUserData($userId, "email");
   $cp = $db->generatePassword($_POST['cp'], $email);
   $np = $db->generatePassword($_POST['np'], $email);
   $rp = $db->generatePassword($_POST['rp'], $email);

   if (md5($cp) != $db->getUserData($userId, "password")) {
      //redirect("index.php?resp=2001");

   } else if ($np != $rp) {
      //redirect("index.php?resp=2002");
   } else {

      if ($db->setUserData($userId, "password", $np)) {
         // success
         //redirect("index.php?resp=2000");
      } else {
         // error
         //redirect("index.php?resp=2003");
      }

   }

}

function redirect($url)
{
   header("Location: $url");
}


?>
