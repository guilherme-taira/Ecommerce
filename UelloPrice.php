<?php
// Gera Valor do Preço do Frete
// create by GUILHERME TAIRA  --> 30/11/2021 as 16:38

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URLBASE_API_UELLO_PRICE", "http://integration-api.uello.com.br/");

class SearchPriceUelloFrete{
    
    function resource(){
        return $this->get('v1/orders/price');
    }

    function get($resource){
        // endpoint para requisicao

        $endpoint = URLBASE_API_UELLO_PRICE.$resource;

        $data = array(
            "type" => "price",
            "operation" => "1721",
            "source" => array(
                "postcode" => "13610230",
                "latitude" => 0,
                "longitude" => 0,
            ),
            "destination" => array(
                "postcode" => "13616450",
                "latitude" => 0,
                "longitude" => 0,
            ),
            "q_vol" => 1,
            "weight" => 4.911,
            "volume" => 0.01
        );
  
        $json = json_encode($data);
        // print_r($json);
        try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
        $response = curl_exec($ch);
        //echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        $res = json_decode($response,false);

        echo "<pre>";
        print_r($res);
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo $th->getCode();
        }
       
    }
}


$SearchPriceUelloFrete = new SearchPriceUelloFrete;
$SearchPriceUelloFrete->resource();