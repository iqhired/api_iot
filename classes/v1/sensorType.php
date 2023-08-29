<?php
class sensorType
{
    private $conn;
    private $db_table = "sensor_type";


    public $type_id;

    public $stype_name;

    public $created_at;
    public $updated_at;

    public $delete_check;

    public function __construct($db)
    {

        $this->conn = $db;
    }

    public function createType()
    {

        $sqlQuery = "insert into " . $this->db_table . "(stype_name,created_at) values (?,?)";

        $stmt = $this->conn->prepare($sqlQuery);
        $resp = $stmt->execute([$this->stype_name, $this->created_at]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".type_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->stype_name = $dataRow['stype_name'];
            $this->created_at = $dataRow['created_at'];
            return $this;
        }

    }
    public function editType()
    {

        $sqlQuery = "update " . $this->db_table . " SET stype_name  = ?   where type_id = '$this->type_id'";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->stype_name]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".type_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->type_id = $dataRow['type_id'];
            $this->stype_name = $dataRow['stype_name'];
            return $this;
        }

    }
    public function deleteType()
    {
        $sqlQuery = "update " . $this->db_table . " SET is_deleted = 1  where type_id = ?";
        // $sqlQuery = "delete from " . $this->db_table . " where device_id = ?";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->delete_check]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".type_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->type_id = $dataRow['type_id'];
            return $this;
        }

    }
    public function delType()
    {
        $sqlQuery = "update " . $this->db_table . " SET is_deleted = 1  where type_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->type_id]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".type_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->type_id = $dataRow['type_id'];
            return $this;
        }

    }

}





