<?php
// ---------- SESSÂO ABERTA --------------//
  
// Busca Dados do Pedido Através da seu Transaction Token Fornecido por Listagem de Transação.
// create by GUILHERME TAIRA  --> 26/11/2021 as 14:06

// METHOD GET

//https://api.intermediador.yapay.com.br/api/v3/transactions/get_by_token_brief?token_account=8e1e557f716763a&token_transaction=120eb08e659625e6fb6cd232265faea2
// URLBASE PARA AUTENTICAR
define("URL_BASE_BUSCA_ORDER_TRANSACTION_TOKEN_YAPAY","https://api.intermediador.yapay.com.br/");

class BuscaByOrderBytransactionToken{

    private $access_token;
    private $token_account;
    private $token_transaction;

    function __construct($access_token,$token_account,$token_transaction)
    {
        $this->access_token = $access_token;
        $this->token_account = $token_account;
        $this->token_transaction = $token_transaction;   
    }

    function resource(){
        // setando as variaveis privada
        $this->setAccess_token($this->access_token);
        $this->setToken_account($this->token_account);
        $this->setToken_transaction($this->token_transaction);

        return $this->get('api/v3/transactions/get_by_token_brief?token_account='.$this->getToken_account().'&token_transaction='.$this->getToken_transaction()); 
    }

    function get($resource){

        // endpoint para requisição
        $endpoint = URL_BASE_BUSCA_ORDER_TRANSACTION_TOKEN_YAPAY.$resource;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, ["Authorization: Token token={$this->getAccess_token()}, type=access_token"]);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $res = json_decode($response,false);
        // echo "<pre>";
        // print_r($res);
        $date = new DateTime();   
        $date2 = new DateTime();      
        $date->setTimestamp($res->data_response->transaction->payment->date_payment);
        $date2->setTimestamp($res->data_response->transaction->payment->date_approval);
        $data_pagamento = $date->format('Y-m-d');
        $data_aprovacao = $date2->modify('+15 days');
        $data_aprovacao = $date2->format('Y-m-d');
        
        if($data_aprovacao == new \DateTime('now')){
            if($data_pagamento == "1970-01-01" && !$data_aprovacao == "1970-01-01"){
                echo "<td>Aguardando</td>";
                echo "<td>$data_aprovacao</td>";
            }else if(!$date == "1970-01-01" && $date2 == "1970-01-01"){
                echo "<td>$data_aprovacao</td>";
                echo "<td>Aguardando..</td>";
            }else if($data_pagamento == "1970-01-01" && $data_aprovacao == "1970-01-16"){
                echo "<td>Aguardando..</td>";
                echo "<td>Aguardando..</td>";
            }
            else if(!$data_pagamento != "1970-01-01" && $data_aprovacao == "1970-01-01"){
                echo "<td>$data_pagamento</td>";
                echo "<td>Aguardando..</td>";
            }
            else{


                echo "<td><span class='badge bg-primary'>$data_pagamento</span></td>";
                echo "<td><span class='badge bg-success'>$data_aprovacao</span></td>";
            }
        }else{
            if($data_pagamento == "1970-01-01" && !$data_aprovacao == "1970-01-01"){
                echo "<td>Aguardando</td>";
                echo "<td>$data_aprovacao</td>";
            }else if(!$date == "1970-01-01" && $date2 == "1970-01-01"){
                echo "<td>$data_aprovacao</td>";
                echo "<td>Aguardando..</td>";
            }else if($data_pagamento == "1970-01-01" && $data_aprovacao == "1970-01-06"){
                echo "<td>Aguardando..</td>";
                echo "<td>Aguardando..</td>";
            }
            else if(!$data_pagamento != "1970-01-01" && $data_aprovacao == "1970-01-01"){
                echo "<td>$data_pagamento</td>";
                echo "<td>Aguardando..</td>";
            }
            else{
                echo "<td><span class='badge bg-primary'>$data_pagamento</span></td>";
                echo "<td><span class='badge bg-warning'>$data_aprovacao</span></td>";
            }
        }
           
    }
    
    public function UnixDate($data){
        $timestamp = strtotime($data);
            return $timestamp;
    }      
    /**
     * Get the value of access_token
     */ 
    public function getAccess_token()
    {
        return $this->access_token;
    }

    /**
     * Set the value of access_token
     *
     * @return  self
     */ 
    public function setAccess_token($access_token)
    {
        $this->access_token = $access_token;

        return $this;
    }

    /**
     * Get the value of token_account
     */ 
    public function getToken_account()
    {
        return $this->token_account;
    }

    /**
     * Set the value of token_account
     *
     * @return  self
     */ 
    public function setToken_account($token_account)
    {
        $this->token_account = $token_account;

        return $this;
    }

    /**
     * Get the value of token_transaction
     */ 
    public function getToken_transaction()
    {
        return $this->token_transaction;
    }

    /**
     * Set the value of token_transaction
     *
     * @return  self
     */ 
    public function setToken_transaction($token_transaction)
    {
        $this->token_transaction = $token_transaction;

        return $this;
    }
}

