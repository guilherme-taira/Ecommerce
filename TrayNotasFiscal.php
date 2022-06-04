<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET NOTAS FISCAIS TRAY 
// create by GUILHERME TAIRA  --> 16/12/2021 as 09:35

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_NOTAFISCAL_TRAY_PRODUTO", "https://testeblipchat.commercesuite.com.br/web_api/");

class GetNotasFiscais{

    private $acess_token;
    private $page;
    
    function __construct($acess_token,$page)
    {
        $this->acess_token = $acess_token;
        $this->page = $page;
    }   

    function resource(){
        $this->setAcess_token($this->acess_token);
        return $this->get('orders/invoices?access_token='.$this->getAcess_token().'&page='.$this->getPage());
    }
    
    function get($resouce){
        // URL PARA REQUISICAO
        $endpoint = URL_BASE_GET_NOTAFISCAL_TRAY_PRODUTO.$resouce;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,  CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo "<pre>";
        $decode = json_decode($response, false);
        
        // if ($httpCode == "200") {
        //     $_SESSION["msg_success"] = "<div class='alert alert-success'> Produto Atualizado com Sucesso! </div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // } else if ($httpCode == "400") {
        //     $_SESSION["msg_error"] = "<div class='alert alert-danger'> Erro ao Cadastraro  Produto Verifique! </div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // }

        return $decode;
    }

    /**
     * Get the value of acess_token
     */ 
    public function getAcess_token()
    {
        return $this->acess_token;
    }

    /**
     * Set the value of acess_token
     *
     * @return  self
     */ 
    public function setAcess_token($acess_token)
    {
        $this->acess_token = $acess_token;

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
}

