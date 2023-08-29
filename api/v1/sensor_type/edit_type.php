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

include_once '../../../classes/v1/sensorType.php';

$jwt = $_SERVER['HTTP_ACCESS_TOKEN'];
if($jwt){
    try {

        $decoded = JWT::decode($jwt,  new Key($secretkey, 'HS256'));

        // Access is granted. Add code of the operation here

        $database = new Database();
        $db = $database->getConnection();

        $item = new sensorType($db);

        $data = json_decode(file_get_contents("php://input"));

        $item->type_id = $_POST['type_id'];
        $item->edit_stype_name = $_POST['edit_stype_name'];
        $item->updated_at = $_POST['updated_at'];

        $sgDevice = $item->editType();

        if($sgDevice != null){
            http_response_code(200);
            echo json_encode(array("status" => "SUCCESS" , "type_id" => $sgDevice));
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
