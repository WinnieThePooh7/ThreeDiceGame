<?php

require_once '../Model/Bet.php';


class BetMapper {
    private $conn;

    public function __construct($nconn) {
        $this->conn=$nconn;
        
    }
    
    function insert($bet)
    {
        $query = "insert into bets(ClientID,Date,Result,StakeAmount,Status,WinAmount) "
                  ."values (:cid,:date,:res,:sam,:st,:wam)";
    

        $cid =$bet->getClientID();
        $date =$bet->getDate();
        $res = $bet->getResult();
        $sam = $bet->getStakeAmount();
        $wam =$bet->getWinAmount();
        $st = $bet->getStatus();
        $command= $this->conn->prepare($query);
        $command->bindParam(':cid',$cid , PDO::PARAM_INT);
        $command->bindParam(':date', $date, PDO::PARAM_STR);
        $command->bindParam(':res', $res, PDO::PARAM_INT);
        $command->bindParam(':sam', $sam, PDO::PARAM_STR);
        $command->bindParam(':wam', $wam, PDO::PARAM_STR);
        $command->bindParam(':st', $st, PDO::PARAM_INT);
        return $command->execute();
          
    }
    
        
}


