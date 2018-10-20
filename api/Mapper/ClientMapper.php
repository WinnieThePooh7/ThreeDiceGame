<?php

require_once '../Model/Client.php';

class ClientMapper {
    
    private $conn;

    public function __construct($nconn) 
    {
        $this->conn=$nconn;    
    }
    
    function getBalance($id)
    {
        $query = "Select Balance "
                . "from client "
                . "where ClientID = :cid";
        
        
        $command = $this->conn->prepare($query);
        $command->bindParam(':cid', $id, PDO::PARAM_INT);
        $command->execute();
        
        return $command->fetch(PDO::FETCH_ASSOC);
    }
    
    function update ($id, $amount)
    {
        $query = "update Client "
                . " set Balance = Balance + :amount "
                . " where ClientID = :cid";
        
        $command=$this->conn->prepare($query);
        $command->bindParam(':cid', $id, PDO::PARAM_INT);
        $command->bindParam(':amount', $amount, PDO::PARAM_STR);
        $command->execute();
    }

    
        
}
