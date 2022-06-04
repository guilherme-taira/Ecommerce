<?php
include_once 'APPEMBALEME/AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET BUSCA CLIENTE TRAY 
// create by GUILHERME TAIRA  --> 12/01/2022 as 14:49

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_CUSTOMERS__TRAY", "https://www.embaleme.com.br/web_api");

class getCustomers {

    private $access_token;
    private $id;

    function __construct($access_token,$id)
    {
        $this->access_token = $access_token;
        $this->id = $id;
    }


    function resource(){
        return $this->get('customers/'.$this->getId().'?access_token='.$this->getAccess_token());
    }


    function get($resource){
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_GET_CUSTOMERS__TRAY . $resource;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //echo "<pre>";
        $decode = json_decode($response,false);
        return $decode;
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
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}