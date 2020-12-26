<?php

if (FOLDER_NAME == "public") {

} else if (FOLDER_NAME == "users") {
   if (!(isset($_SESSION['acc']['admin']) || isset($_SESSION['acc']['sudo']))) {
      deny();
   }
} else if (FOLDER_NAME == "settings") {
   // Anyone can access

} else if (FOLDER_NAME == "customers") {
   // Anyone can access
} else if (FOLDER_NAME == "collectors") {
   // Anyone can access
} else if (FOLDER_NAME == "pickups") {
   // Anyone can access
} else if (FOLDER_NAME == "reports") {
   // Anyone can access
} else if (FOLDER_NAME == "categorization") {
   // Anyone can access
} else if (FOLDER_NAME == "materials") {
   // Anyone can access
} else if (FOLDER_NAME == "home") {
   // allow
} else if (FOLDER_NAME == "arena") {
   // allow

} else if (FOLDER_NAME == "serviceManager"){
   // isset($_SESSION['acc']['admin']) ||
   if(!(isset($_SESSION['acc']['sudo']))){
      deny();
   }
} else {
   deny();
}

function deny(){
   include_once '../404.shtml';
   exit;
}
