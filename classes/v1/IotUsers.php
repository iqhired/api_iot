<?php
class IotUsers{

    // Connection
    private $conn;

    // Table
    private $db_table = "iot_users";

    // Columns
    public $cust_id;
    public $cust_name;
    public $mobile;
    public $cust_email;
    public $cust_password;
    public $role;
    public $cust_profile_pic;
    public $created_at;
    public $updated_at;
    public $cust_fistname;
    public $cust_lastname;
    public $cust_address;
    public $is_deleted;
    public $delete_check;
    public $edit_cust_name;
    public $edit_cust_email;
    public $edit_cust_fistname;
    public $edit_cust_lastname;
    public $edit_role;
    public $edit_cust_address;
    public $edit_mobile;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getIotUsers()
    {

        $sqlQuery = "insert into " . $this->db_table . "(cust_name,cust_email,cust_fistname,cust_lastname,mobile,role,cust_profile_pic,cust_address,created_at) values (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->cust_name, $this->cust_email, $this->cust_fistname, $this->cust_lastname, $this->mobile, $this->role, $this->cust_profile_pic, $this->cust_address,$this->created_at]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".cust_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->cust_id = $dataRow['cust_id'];
            $this->cust_name = $dataRow['cust_name'];
            $this->cust_email = $dataRow['cust_email'];
            $this->cust_fistname = $dataRow['cust_fistname'];
            $this->cust_lastname = $dataRow['cust_lastname'];
            $this->mobile = $dataRow['mobile'];
            $this->role = $dataRow['role'];
            $this->cust_profile_pic = $dataRow['cust_profile_pic'];
            $this->cust_address = $dataRow['cust_address'];
            $this->created_at = $dataRow['created_at'];
            return $this;
        }

    }


    public function editIotUsers()
    {

        $sqlQuery = "update " . $this->db_table . " SET cust_name = ? ,cust_email = ? ,cust_fistname = ? ,cust_lastname = ?,mobile = ? ,role = ?  ,cust_address = ?   where cust_id = '$this->cust_id'";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->edit_cust_name,$this->edit_cust_email,$this->edit_cust_fistname,$this->edit_cust_lastname,$this->edit_mobile,$this->edit_role,$this->edit_cust_address]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".cust_id DESC LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->cust_id = $dataRow['cust_id'];
            $this->edit_cust_name = $dataRow['edit_cust_name'];
            $this->edit_cust_email = $dataRow['edit_cust_email'];
            $this->edit_cust_fistname = $dataRow['edit_cust_fistname'];
            $this->edit_cust_lastname = $dataRow['edit_cust_lastname'];
            $this->edit_mobile = $dataRow['edit_mobile'];
            $this->edit_role = $dataRow['edit_role'];
         //   $this->edit_cust_profile_pic = $dataRow['edit_cust_profile_pic'];
            $this->edit_cust_address = $dataRow['edit_cust_address'];
            return $this;
        }

    }
    public function getdeleteIotUser()
    {
        $sqlQuery = "update " . $this->db_table . " SET is_deleted = 1  where cust_id = ?";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->delete_check]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".cust_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->cust_id = $dataRow['cust_id'];
            return $this;
        }

    }
    public function getdelIotuser()
    {
        $sqlQuery = "update " . $this->db_table . " SET is_deleted = 1  where cust_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$this->cust_id]);

        $sqlQuery1 = "SELECT * FROM " . $this->db_table . " ORDER BY " . $this->db_table. ".cust_id desc limit 0,1";
        $stmt = $this->conn->prepare($sqlQuery1);
        $stmt->execute();
        $dataRow = $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dataRow == null || empty($dataRow)) {
            return null;
        } else {
            $this->cust_id = $dataRow['cust_id'];
            return $this;
        }

    }

}