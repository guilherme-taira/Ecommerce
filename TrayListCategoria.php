<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET CAREGORIAS TRAY 
// create by GUILHERME TAIRA  --> 16/12/2021 as 09:35

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_CATEGORIAS_TRAY", "https://testeblipchat.commercesuite.com.br/web_api/");

class ListCategoriaTray{
    
    private $access_token;
    private $page;
    private $name;

    function resource($access_token,$page,$name){
        
        $this->setAccess_token($access_token);
        $this->setPage($page);
        $this->setName($name);
        if(empty($this->getName())){
            return $this->get('categories/?access_token='.$this->getAccess_token().'&page='.$this->getPage());
        }else{
            return $this->get('categories/?access_token='.$this->getAccess_token().'&page='.$this->getPage().'&name='.$this->getName());
        }   
    }

    function get($resource){
        // ENDPOINT PARA REQUISIÇÃO
        $endpoint = URL_BASE_GET_CATEGORIAS_TRAY.$resource;
  
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo "<pre>";
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
}

