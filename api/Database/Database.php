<?php

class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    
    public function __construct() {
        $this->host="localhost";
        $this->user="root";
        $this->pass="";
        $this->dbname="threedice";
    }
    
    public function getConnection()
    {
        $conn=null;
        try
        {
            $conn=new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
        }
        catch(PDOException $ex)
        {
            echo "Connection error!";
        }
        
        return $conn;
    }
}
