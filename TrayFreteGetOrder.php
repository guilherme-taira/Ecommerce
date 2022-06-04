<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// GET BUSCA FRETE GATEWAY TRAY 
// create by GUILHERME TAIRA  --> 31/12/2021 as 07:08

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_GET_FRETE_GATEWAY_TRAY", "https://testeblipchat.commercesuite.com.br/web_api/");


class FreteGateway{

    private $access_token;
    private $cep;
    private $cep_destino;
    private $envio;
    private $session_id;
    private $produtos;
    private $productId;
    private $price;
    private $quantidade;


    function __construct($access_token, $cep,$cep_destino,$envio, $session_id, array $productId, array $price, array $quantidade)
    {
        $this->access_token = $access_token;
        $this->cep = $cep;
        $this->cep_destino = $cep_destino;
        $this->envio = $envio;
        $this->session_id = $session_id;
        $this->productId = $productId;
        $this->price = $price;
        $this->quantidade = $quantidade;
    }
    
    function resource(){

        $produtos = array(
            'product_id' => $this->getProductId(),
            'price' => $this->getQuantidade(),
            'quantity' => $this->getPrice(),
        );

        /*****
         * 
         * MODELO 
         * 
         *          https://{api_address}/shippings/cotation/?access_token={{access_token}}&zipcode=04001001
         *          &products[0][product_id]=123&products[0][price]=58.90&products[0]
         *          [quantity]=2&products[1][product_id]=456&products[1][price]=98.89&products[1][quantity]=1
         * 
         *****/

        $i = 0;
        $e = 0;
        $link = [];
        // CONTAGEM DO ARRAY
        $size = count($produtos['product_id']);

        // ITERA OS VALORES PARA CRIACAÇÂO
        for($i = 0; $i < $size; $i++) {
            $id = $produtos['product_id'][$i];
            $preco = $produtos['price'][$i];
            $quantity = $produtos['quantity'][$i];
            $link[$i] = "products[$i][product_id]=$id".'&'."products[$i][price]=$preco".'&'."products[$i][quantity]=$quantity"; 
        }

        $this->setAccess_token($this->access_token);
        // URL DOS PRODUTOS 
        $url = implode('&',$link);
        return $this->get("shippings/cotation/?access_token=".$this->getAccess_token().'&zipcode='.$this->getCep().'&'.$url);
    }

    function get($resource){
        // ENDPOINT PARA REQUSICÂO
        $endpoint = URL_BASE_GET_FRETE_GATEWAY_TRAY.$resource;
       // echo $endpoint;
        //echo $endpoint;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo "<pre>";
        print_r($httpCode);
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
     * Get the value of produtos
     */ 
    public function getProdutos()
    {
        return $this->produtos;
    }

    /**
     * Set the value of produtos
     *
     * @return  self
     */ 
    public function setProdutos($produtos)
    {
        $this->produtos = $produtos;

        return $this;
    }

    /**
     * Get the value of productId
     */ 
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     *
     * @return  self
     */ 
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantidade
     */ 
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     *    
     * @return  self
     */ 
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get the value of cep
     */ 
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @return  self
     */ 
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of cep_destino
     */ 
    public function getCep_destino()
    {
        return $this->cep_destino;
    }

    /**
     * Set the value of cep_destino
     *
     * @return  self
     */ 
    public function setCep_destino($cep_destino)
    {
        $this->cep_destino = $cep_destino;

        return $this;
    }

    /**
     * Get the value of envio
     */ 
    public function getEnvio()
    {
        return $this->envio;
    }

    /**
     * Set the value of envio
     *
     * @return  self
     */ 
    public function setEnvio($envio)
    {
        $this->envio = $envio;

        return $this;
    }

    /**
     * Get the value of session_id
     */ 
    public function getSession_id()
    {
        return $this->session_id;
    }

    /**
     * Set the value of session_id
     *
     * @return  self
     */ 
    public function setSession_id($session_id)
    {
        $this->session_id = $session_id;

        return $this;
    }
}


$frete = new FreteGateway($_SESSION['access_token_tray'],"13610230","13616450",1,111,[18,20,1266094933],[12.00,35.00,1110.00],[4,4,1]);
print_r($frete->resource());  