<?php


class Transaction {
    private $transactionID;
    private $clientID;
    private $amount;
    private $amountDirection;
    private $date;

    public function __construct($cid,$sa,$ad,$d) 
    {
        $this->clientID=$cid;
        $this->amount=$sa;
        $this->amountDirection=$ad;
        $this->date=$d;
    }
    
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getClientID()
    {
        return $this->clientID;
    }

    public function getAmountDirection()
    {
        return $this->amountDirection;
    }
    
        
}


