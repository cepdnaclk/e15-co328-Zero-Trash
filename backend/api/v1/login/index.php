<?php
include '../vendor/autoload.php';

use \Firebase\JWT\JWT;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization");

ini_set('error_log', 'log.txt');
error_reporting(E_ERROR);
ini_set('display_errors', 0);
date_default_timezone_set('Asia/Colombo');

include_once '../constants.php';
include_once '../database.php';

$time = date("y-m-d H:i:s");
$jsonData = file_get_contents('php://input');
$db = new database();

// Reading data from php input, can do some validation here
$jsonData = file_get_contents('php://input');
$in = json_decode($jsonData, true);
$response = array('statusCode' => '', 'error' => '');

if (isset($in['password']) == false) {
    $response['statusCode'] = "E1000";
    $response['error'] = "Password can't be empty";

} else {

    $tele = $db->mysqlSafe($in['phoneNo']); //substr($db->mysqlSafe($in['phoneNo']), 2);
    $email = $db->mysqlSafe($in['email']);
    if ($tele == "null") {
        // Login by email
        $response['statusCode'] = 'E4002';
        $response['error'] = 'Incorrect Username or Password';

        if ($email != "null" && $db->existCustomer_byEmail($email) == false) {
            $response['statusCode'] = 'E4003';
            $response['error'] = 'Incorrect Username or Password';

        } else {
            $id = $db->getCustomerId_byEmail($email);
            $tele = $db->getCustomerData($id, "phoneNo");
            $address = array(
                "address1" => $db->getCustomerData($id, "address1"),
                "address2" => $db->getCustomerData($id, "address2"),
                "city" => $db->getCustomerData($id, "city"),
                /*"municipalCouncil"=>$db->getCustomerData($id, "municipalCouncil"),*/
            );
            $pw = sha1(md5($db->mysqlSafe($in['password'])) . $tele);

            $res = $db->verifyUser("email", $email, $pw);

            if ($res == 1) {
                $response['statusCode'] = 'S2000';
                $response['error'] = '';
                $response['authToken'] = getToken($id, $tele, $privateKey);
                $response['userId'] = $id;
                $response['email'] = $email;
                $response['phone'] = $tele;
                $response['address'] = $address;
            } else {
                $response['statusCode'] = 'E4005';
                $response['error'] = 'Incorrect Username or Password';
            }
        }

    } else if ($email == "null") {
        // Login by tele

        if ($tele != "null" && $db->existCustomer($tele) == false) {
            $response['statusCode'] = 'E4001';
            $response['error'] = 'Incorrect Username or Password';

        } else {

            $id = $db->getCustomerId_byTele($tele);
            $email = $db->getCustomerData($id, "email");
            $address = array(
                "address1" => $db->getCustomerData($id, "address1"),
                "address2" => $db->getCustomerData($id, "address2"),
                "city" => $db->getCustomerData($id, "city")
                /*"municipalCouncil" => $db->getCustomerData($id, "municipalCouncil"),*/
            );

            $pw = sha1(md5($db->mysqlSafe($in['password'])) . $tele);

            $res = $db->verifyUser("phone", $tele, $pw);

            if ($res == 1) {
                $response['statusCode'] = 'S2000';
                $response['error'] = '';
                $response['authToken'] = getToken($id, $tele, $privateKey);
                $response['userId'] = $id;
                $response['email'] = $email;
                $response['phone'] = $tele;
                $response['address'] = $address;

            } else {
                $response['statusCode'] = 'E4004';
                $response['error'] = 'Incorrect Username or Password';
            }
        }

    } else {
        $response['statusCode'] = 'E4006';
        $response['error'] = 'Incorrect Username or Password';
    }

}

$resp = json_encode($response);
echo $resp;

function getToken($id, $tele, $pvtKey)
{
    $payload = array("id" => $id, "tele" => $tele);
    $jwt = JWT::encode($payload, $pvtKey, 'RS256');
    //print($jwt);
    return $jwt;
}

function readToken($token, $pubKey)
{
    $decoded = JWT::decode($token, $pubKey, array('RS256'));
    //print_r((array) $decoded);
    return (array)$decoded;
}

?>
