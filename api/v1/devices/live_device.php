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

include_once '../../../classes/v1/liveDevice.php';

$jwt = $_SERVER['HTTP_ACCESS_TOKEN'];
if($jwt){
    try {

        $decoded = JWT::decode($jwt,  new Key($secretkey, 'HS256'));

        // Access is granted. Add code of the operation here

        $database = new Database();
        $db = $database->getConnection();

        $item = new liveDevice($db);



        $data = json_decode(file_get_contents("php://input"));
        $item->dev_id = $_POST['dev_id'];
        $item->device_id = $_POST['device_id'];
        $item->temperature = $_POST['temperature'];
        $item->humidity = $_POST['humidity'];
        $item->pressure = $_POST['pressure'];
        $item->iaq = $_POST['iaq'];
        $item->voc = $_POST['voc'];
        $item->co2 = $_POST['co2'];
        $item->datetime = $_POST['datetime'];


        $sgDevice = $item->liveData();

        if($sgDevice != null){
            http_response_code(200);
            echo json_encode(array("STATUS" => "Success" , "device_id" => $sgDevice));
        } else{
            http_response_code(401);
            echo json_encode(array("message" => "Iot Device failed"));
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
