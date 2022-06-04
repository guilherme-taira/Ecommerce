<?php
include_once 'APPEMBALEME/AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET PEDIDOS TRAY 
// create by GUILHERME TAIRA  --> 10/12/2021 as 09:44

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_PEDIDOS_TRAY_COMPLETE", "https://www.embaleme.com.br/web_api");

class GetPedidosComplete{

    private $access_token;
    private $page;
    private $dataInicial;
    private $dataFinal;
    private $id;

    function __construct($access_token,$id)
    {
        $this->access_token = $access_token;
        $this->id = $id;
    }

    function resource(){
        $this->setAccess_token($this->access_token);
        $this->setPage($this->page);
        $this->setDataInicial($this->dataInicial);
        $this->setDataFinal($this->dataFinal);
        return $this->get('/orders/'.$this->getId().'/complete/?access_token='.$this->getAccess_token());
    }

    function get($resource){
        // ENDPOINT PARA REQUISCAO
        $endpoint = URL_BASE_GET_PEDIDOS_TRAY_COMPLETE.$resource;
        //echo $endpoint . "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["follow_redirects: TRUE"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response,false); 
     
        return $requisicao;
        //echo $httpCode;
        // if($httpCode == "200"){
        //     echo "Token Gerado Com Sucesso!!";
        // }else if($httpCode == "404"){
        //     echo "Ordem Não Encontrada Verifique!";
        // }
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
     * Get the value of page
     */ 
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the value of page
     *
     * @return  self
     */ 
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }


    /**
     * Get the value of idPedido
     */ 
    public function getIdPedido()
    {
        return $this->idPedido;
    }

    /**
     * Set the value of idPedido
     *
     * @return  self
     */ 
    public function setIdPedido($idPedido)
    {
        $this->idPedido = $idPedido;

        return $this;
    }

    /**
     * Get the value of dataInicial
     */ 
    public function getDataInicial()
    {
        return $this->dataInicial;
    }

    /**
     * Set the value of dataInicial
     *
     * @return  self
     */ 
    public function setDataInicial($dataInicial)
    {
        $this->dataInicial = $dataInicial;

        return $this;
    }

    /**
     * Get the value of dataFinal
     */ 
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * Set the value of dataFinal
     *
     * @return  self
     */ 
    public function setDataFinal($dataFinal)
    {
        $this->dataFinal = $dataFinal;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

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

