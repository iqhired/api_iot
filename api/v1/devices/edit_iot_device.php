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

include_once '../../../classes/v1/IotDevice.php';

$jwt = $_SERVER['HTTP_ACCESS_TOKEN'];
if($jwt){
    try {

        $decoded = JWT::decode($jwt,  new Key($secretkey, 'HS256'));

        // Access is granted. Add code of the operation here

        $database = new Database();
        $db = $database->getConnection();

        $item = new IotDevice($db);

        $data = json_decode(file_get_contents("php://input"));

        $item->device_id = $_POST['device_id'];
        $item->c_id = empty($_POST["c_id"])?null:$_POST["c_id"];;
        $item->device_description = $_POST['device_description'];
        $item->type_id =  empty($_POST["type_id"])?null:$_POST["type_id"];
        $item->device_location = $_POST['device_location'];
        $item->modified_by = $_POST['modified_by'];
        $item->modified_on = $_POST['modified_on'];

        $sgDevice = $item->updateIotDevice();

        if($sgDevice != null){
            http_response_code(200);
            echo json_encode(array("status" => "SUCCESS" , "device_id" => $sgDevice));
        } else{
            http_response_code(401);
            echo json_encode(array("message" => "Iot Device failed"));
        }
    }catch (Exception $e){
        http_response_code(401);
        $mess = '';
        if($e->errorInfo[0] == '23000'){
            $eD = explode('for key' , $e->errorInfo[2]);
            $mess = $eD[0] . '.' . 'Check ' . str_replace( '_',' ', $eD[1] );
        }
        echo json_encode(array(
            "status" => "ERROR",
            "message" => $mess
        ));
    }

}
?>
