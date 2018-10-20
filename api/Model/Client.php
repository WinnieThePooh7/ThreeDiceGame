<?php


class Client {
    private $clientID;
    private $name;
    private $lastname;
    private $balance;

    public function __construct($nconn) 
    {
        $this->conn=$nconn;
    }

    function getClientID()
    {
        return $this->clientID;
    }

    function getName()
    {
        return $this->name;
    }

    function getLastname()
    {
        return $this->lastname;
    }

    function getBalance()
    {
        return $this->balance;
    }


    
        
}
