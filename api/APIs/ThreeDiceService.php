<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
require_once '../Database/Database.php';
require_once '../Mapper/BetMapper.php';
require_once '../Mapper/ClientMapper.php';
require_once '../Mapper/TransactionMapper.php';

class ThreeDiceService {
    private $database;
    private $connection;
    private $clientMapper;
    private $betMapper;
    private $transactionMapper;
    
    public function __construct()
    {
        $this->database=new Database();
        $this->connection=$this->database->getConnection();
        $this->clientMapper = new ClientMapper($this->connection);
        $this->betMapper = new BetMapper($this->connection);
        $this->transactionMapper = new TransactionMapper($this->connection);
    }
    
    
    function respond()
    {
        
        $data=json_decode(file_get_contents("php://input"));

        if(empty($data->id) || empty($data->product) || empty($data->stake))
        {
            http_response_code(400);
            echo json_encode(array("message" => "Error - Missing parameters "));
            return;
        }

        else
        {
            if($this->checkProduct($data->product))
            {
                http_response_code(400);
                echo json_encode(array("message" => "Error - Product must be numeric value between 1 and 216 "));
                return;
            }
               
            else if($this->checkStake ($data->stake))
            {
                http_response_code(400);
                echo json_encode(array("message" => "Error - Stake must be numeric value "));
                return;
            }
            else if($this->checkID($data->id))
            {
                http_response_code(400);
                echo json_encode(array("message" => "Error - There is no client with that ID "));
                return;
            }
            else 
            {
                $balance = $this->clientMapper->getBalance($data->id);
                if($balance["Balance"]==null)
                {
                    http_response_code(400);
                    echo json_encode(array("message" => "Error - There is no client with that ID "));
                    return;
                }
                else
                {
                    if($data->stake > $balance["Balance"])
                    {
                        http_response_code(400);
                        echo json_encode(array("message" => "Error - Client does not have enough money "));
                        return; 
                    }
                    else
                    {
                        $this->doBet($data->id,$data->stake,$data->product);
                    }
                }
            }

            
        } 
    }

    private function doBet($cid,$cstake,$cproduct)
    {
        $client;
        $bet;
        $transaction;
        
        $direction = true;
        $odds = $this->returnOdds($cproduct);
        $win=-1;
        $wamount = $odds * $cstake;
        $totalAmountToAdd=-$cstake;
        $this->connection->beginTransaction();
        
        try
        {
            $transaction = new Transaction($cid,$cstake,$direction,date('Y-m-d H:i:s'));
            $this->transactionMapper->insert($transaction);
            
            $dice1 = rand(1,6);
            $dice2 = rand(1,6);
            $dice3 = rand(1,6);
    
            $finalProduct = $dice1*$dice2*$dice3;
            
            if($finalProduct===$cproduct)
            {
                $win=1;
            }
            $bet = new Bet($cid,$win,$cstake,$wamount,$finalProduct,date('Y-m-d H:i:s'));
            
            $this->betMapper->insert($bet);

            if($win===1)
            {
                $totalAmountToAdd=$wamount-$cstake;
                $transaction = new Transaction($cid,$wamount,!$direction,date('Y-m-d H:i:s'));
                $this->transactionMapper->insert($transaction);
            }
            $this->clientMapper->update($cid,$totalAmountToAdd);
            
            $balance = $this->clientMapper->getBalance($cid);
            $this->connection->commit();
            echo json_encode(array("dice1" => $dice1,"dice2"=>$dice2,"dice3"=>$dice3,"status"=>$win,"amount"=>$balance["Balance"]));
            return;
            
        }
        catch(Exception $e){
            
            $this->connection->rollBack();
            echo json_encode(array("message" => "Error - Your game could not be played "));
            return;
        }
    }
    private function checkProduct($product)
    {
        if(preg_match('/^0/', $product) === 1) return true;
        return (!(ctype_digit($product) || is_int($product)) || $product<1 || $product>216);
    }

    private function returnOdds($product)
    {
        if($product < 9 || $product>=120) return 2;
        return 5;
        
    }
    
    private function checkStake($stake)
    {
        if((preg_match('/^0/', $stake) === 1 && ctype_digit($stake)) || $stake<0)
        return true;
        if(is_numeric($stake)) return false;
        
        return true;
    }

    private function checkID($id)
    {
        if(preg_match('/^0/', $id) === 1 || !ctype_digit($id)) return true;
        return false;
    }
}
