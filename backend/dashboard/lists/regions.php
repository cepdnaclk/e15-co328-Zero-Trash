<?php

include_once '../data/session.php';

define("FOLDER_NAME", "public");
include_once "../data/accessControl.php";

include_once '../db/areaDB.php';

$db = new areaDB();

$post = json_decode(file_get_contents('php://input'), true); // array('term'=>"Jal");//
$filter = $post['query'];// "Jal";
$data = $db->getRegionSuggestions($filter);

$suggestions 	=  $db->getRegionSuggestions($filter);//['India', 'Pakistan', 'Nepal', 'UAE', 'Iran', 'Bangladesh'];
$data 			= [];
foreach($suggestions as $suggestion) {
   if(strpos(strtolower($suggestion), strtolower($post['term'])) !== false) {
      $data[] = $suggestion;
   }
}


header('Content-Type: application/json');
echo json_encode(['suggestions' => $data]);

/*

// Not tested, please let me know if there any issue with this

<link href="../css/amsify.suggestags.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery.amsify.suggestags.js"></script>

$('input[name="material"]').amsifySuggestags({
type : 'amsify',
suggestionsAction : {
url : '../lists/materials.php'
}
});



*/
