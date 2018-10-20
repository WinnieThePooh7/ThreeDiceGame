<?php

class Bet {
    private $betID;
    private $clientID;
    private $date;
    private $status;
    private $stakeAmount;
    private $winAmount;
    private $result;
    

    public function __construct($cid,$s,$sa,$wa,$r,$d) 
    {
        $this->clientID=$cid;
        $this->status=$s;
        $this->stakeAmount=$sa;
        $this->winAmount=$wa;
        $this->result=$r;
        $this->date=$d;
    }
    
    public function getBetID()
    {
        return $this->betID;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getClientID()
    {
        return $this->clientID;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getStakeAmount()
    {
        return $this->stakeAmount;
    }

    public function getWinAmount()
    {
        return $this->winAmount;
    }

    public function getResult()
    {
        return $this->result;
    }

    
    
        
}


