<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET BUSCA ETIQUETA ZPL2 E PDF MERCADO LIVRE / TRAY 
// create by GUILHERME TAIRA  --> 04/01/2022 as 14:38

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_ML_ETIQUETA_TRAY", "https://testeblipchat.commercesuite.com.br/web_api/");

class GeradorMlEtiqueta{   

    private $access_token;
    private $order;
    private $type;

    public function __construct($access_token, array $order, $type)
    {
        $this->access_token = $access_token;
        $this->order = $order;
        $this->type = $type;
    }

    public function resource(){
        return $this->get('meli/tracking_labels?access_token='.$this->getAccess_token().'&order=1298975'.'&type='.$this->getType());
    }

    public function get($resource){
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_GET_ML_ETIQUETA_TRAY.$resource;
        echo $endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo "<pre>";
        print_r($response);
  
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
     * Get the value of order
     */ 
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @return  self
     */ 
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}


$Etiqueta = new GeradorMlEtiqueta($_SESSION['access_token_tray'],[179329],'zpl2');
print_r($Etiqueta->resource());

//SELECT * FROM `tb_devolucao` WHERE DATA BETWEEN '2021-12-01' and '2021-12-31'