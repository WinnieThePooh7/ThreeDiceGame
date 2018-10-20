<?php


require_once '../Model/Transaction.php';
class TransactionMapper {
    
    private $conn;

    public function __construct($nconn) 
    {
        $this->conn=$nconn;
    }
    
    function insert($transaction)
    {
        $query = "insert into transactions(ClientID,Date,Amount,AmountDirection) "
                 ." values (:cid,:date,:amount,:ad)";
    


        $date = $transaction->getDate();
        $cid = $transaction->getClientID();
        $am =$transaction->getAmount();
        $amd = $transaction->getAmountDirection();
        $command= $this->conn->prepare($query);
        $command->bindParam(':cid', $cid, PDO::PARAM_INT);
        $command->bindParam(':date', $date, PDO::PARAM_STR);
        $command->bindParam(':amount', $am, PDO::PARAM_STR);
        $command->bindParam(':ad', $amd, PDO::PARAM_INT);
        return $command->execute();
    }
    
    
        
}


