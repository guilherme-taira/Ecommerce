<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET PRODUTOS TRAY 
// create by GUILHERME TAIRA  --> 10/12/2021 as 09:44

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_PRODUTOS_TRAY", "https://testeblipchat.commercesuite.com.br/web_api");

class GetProdutos{

    private $access_token;
    private $produto;
    
    function resource($access_token,$produto){
        $this->setAccess_token($access_token);
        $this->setProduto($produto);
        return $this->get('products/'.$this->getProduto().'?access_token='.$this->getAccess_token());
    }

    function get($resource){
        // ENDPOINT PARA REQUISCAO
        $endpoint = URL_BASE_GET_PRODUTOS_TRAY.$resource;

        echo $endpoint;
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
     * Get the value of produto
     */ 
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * Set the value of produto
     *
     * @return  self
     */ 
    public function setProduto($produto)
    {
        $this->produto = $produto;

        return $this;
    }
}
//echo "<pre>";
//print_r($_SESSION);
