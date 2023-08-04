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
        $item->edit_cust_name = $_POST['edit_cust_name'];
        $item->edit_cust_email = $_POST['edit_cust_email'];
        $item->edit_cust_fistname = $_POST['edit_cust_fistname'];
        $item->edit_cust_lastname = $_POST['edit_cust_lastname'];
        $item->edit_role = $_POST['edit_role'];
        $item->edit_mobile = $_POST['edit_mobile'];
      //  $item->edit_cust_profile_pic = $_POST['edit_cust_profile_pic'];
        $item->edit_cust_address = $_POST['edit_cust_address'];

        $sgPos = $item->editIotUsers();

        if($sgPos != null){
            echo json_encode(array("STATUS" => "Success" , "cust_id" => $sgPos));
        } else{

                http_response_code(401);
            echo json_encode(array("message" => "Iot Device Update failed"));
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
