<?php
// ---------- SESSÂO ABERTA --------------//

// GET PRODUTOS BLING 
// create by GUILHERME TAIRA  --> 19/01/2022 as 14:04

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_PRODUTOS_BLING", "https://bling.com.br/");

class GetProdutosBling{

    private $access_token;
    private $page;
    
    function resource($page,$access_token){
        $this->setAccess_token($access_token);
        $this->setPage($page);

        $dataInicial = new DateTime();
        $dataFinal = new DateTime();
        $dataInicial->modify('-2 days'); // decrementa 2 dias da data atual
        $dataFinal->modify('+2 days'); // acresenta 2 dias da data atual

        return $this->get('Api/v2/produtos/json/?apikey='.$this->getAccess_token()."&loja=203874743&filters=dataInclusaoLoja[{$dataInicial->format('d/m/Y')} TO {$dataFinal->format('d/m/Y')}]");
    }

    function get($resource){
        // ENDPOINT PARA REQUISCAO
        $endpoint = URL_BASE_GET_PRODUTOS_BLING.$resource;
    
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
        //echo $httpCode;
        // if($httpCode == "200"){
        //     echo "Token Gerado Com Sucesso!!";
        // }else if($httpCode == "404"){
        //     echo "Ordem Não Encontrada Verifique!";
        // }
        print_r($requisicao);
        return $requisicao;
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
}


