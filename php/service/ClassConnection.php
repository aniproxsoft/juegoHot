<?php
header("Cache-Control: no-cache");
class connectionDB extends mysqli
{
    private $DB_HOST = 'localhost';
    //private $DB_HOST = '';
    private $DB_USER = 'root';
    //private $DB_USER = 'id21027310_root';
    private  $DB_PASS = '';
    //private $DB_PASS = 'hotGame132*';
    private $DB_NAME = 'id21027310_dbhotgame';
    private $conn;

    public function __construct()
    {
        
        try{
  
            $this->conn = new PDO("mysql:host=$this->DB_HOST;charset=UTF8;dbname=$this->DB_NAME",$this->DB_USER,$this->DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        }catch(PDOException $ex){
  
            die($ex->getMessage());
        }
    }

    public function get_connection()
    {
        
        return $this->conn;
    }
}
