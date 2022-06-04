<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET NOTAS FISCAIS TRAY 
// create by GUILHERME TAIRA  --> 16/12/2021 as 09:35

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_NOTAFISCAL_TRAY_PRODUTO", "https://testeblipchat.commercesuite.com.br/web_api/");

class GetNotasFiscalDados{

    private $acess_token;
    private $order;
    private $invoice_id;

    function __construct($acess_token,$order,$invoice_id)
    {
        $this->acess_token = $acess_token;
        $this->order = $order;
        $this->invoice_id = $invoice_id;
    }   

    function resource(){
        $this->setAcess_token($this->acess_token);
        return $this->get('orders/'.$this->getOrder().'/'.'invoices/'.$this->getInvoice_id().'?access_token='.$this->getAcess_token());
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
     * Get the value of invoice_id
     */ 
    public function getInvoice_id()
    {
        return $this->invoice_id;
    }

    /**
     * Set the value of invoice_id
     *
     * @return  self
     */ 
    public function setInvoice_id($invoice_id)
    {
        $this->invoice_id = $invoice_id;

        return $this;
    }
}

