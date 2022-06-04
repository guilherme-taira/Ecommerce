<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET CAREGORIAS TRAY 
// create by GUILHERME TAIRA  --> 16/12/2021 as 09:35

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_PRODUTOS_TRAY_PRODUTO", "https://testeblipchat.commercesuite.com.br/web_api/");

class TrayListProdutos{
    
    private $access_token;
    private $page;
    private $name;
    private $status;
    
    function resource($access_token,$page,$status,$name){
        $this->setAccess_token($access_token);
        $this->setPage($page);
        $this->setStatus($status);
        $this->setName($name);
        if(!empty($name)){
            return $this->get('products/?access_token='.$this->getAccess_token().'&page='.$this->getPage().'&availability='. $this->getStatus().'&name='.$this->getName());
        }else{
            return $this->get('products/?access_token='.$this->getAccess_token().'&page='.$this->getPage().'&availability='. $this->getStatus());
        }
    }

    function get($resource){
        // ENDPOINT PARA REQUISIÇÃO
        $endpoint = URL_BASE_GET_PRODUTOS_TRAY_PRODUTO.$resource;
        $id =  array(
            "sort" => array([
                "id" => "asc",
            ])
         );

        $json = json_encode($id);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', "sort" => "id:desc"]);

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
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

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
}

