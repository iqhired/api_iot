<?php
class liveDevice{

    // Connection
    private $conn;

    // Table
    private $db_table = "live_data";

    // Columns
    public $dev_id;
    public $device_id;
    public $temperature;
    public $humidity;
    public $pressure;
    public $iaq;
    public $voc;
    public $co2;
    public $datetime;


    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function liveData()
    {

        $sqlQuery = "insert into " . $this->db_table . "(device_id,temperature,humidity,pressure,iaq,voc,co2,datetime) values (?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->device_id, $this->temperature, $this->humidity, $this->pressure, $this->iaq,$this->voc, $this->co2, $this->datetime]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".dev_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->dev_id = $dataRow['dev_id'];
            $this->device_id = $dataRow['device_id'];
            $this->temperature = $dataRow['temperature'];
            $this->humidity = $dataRow['humidity'];
            $this->pressure = $dataRow['pressure'];
            $this->iaq = $dataRow['iaq'];
            $this->voc = $dataRow['voc'];
            $this->co2 = $dataRow['co2'];
            $this->datetime = $dataRow['datetime'];
            return $this;
        }

    }




}