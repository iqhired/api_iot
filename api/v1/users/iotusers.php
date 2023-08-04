<?php
require "../../../vendor/autoload.php";
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

include_once '../../../config/database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../../classes/v1/IotUsers.php';

$jwt = $_SERVER['HTTP_ACCESS_TOKEN'];
if($jwt){
    try {

        $decoded = JWT::decode($jwt,  new Key($secretkey, 'HS256'));

        // Access is granted. Add code of the operation here

        $database = new Database();
        $db = $database->getConnection();

        $item = new IotUsers($db);

        $data = json_decode(file_get_contents("php://input"));
        $item->cust_id = $_POST['cust_id'];
        $item->cust_name = $_POST['cust_name'];
        $item->cust_email = $_POST['cust_email'];
        $item->cust_fistname = $_POST['cust_fistname'];
        $item->cust_lastname = $_POST['cust_lastname'];
        $item->mobile = $_POST['mobile'];
        $item->role = $_POST['role'];
        $item->cust_profile_pic = $_POST['cust_profile_pic'];
        $item->cust_address = $_POST['cust_address'];
        $item->created_at = $_POST['created_at'];

        $sgIotUsers = $item->getIotUsers();

        if($sgIotUsers != null){
            http_response_code(200);
            echo json_encode(array("STATUS" => "Success" , "cust_name" => $sgIotUsers));
        } else{
            http_response_code(401);
            echo json_encode(array("message" => "Iot Users failed"));
        }

    }catch (Exception $e){

        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }

}
?>
