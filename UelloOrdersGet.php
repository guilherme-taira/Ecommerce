<?php
// Retorna Todas as Ordem Geradas.
// create by GUILHERME TAIRA  --> 06/12/2021 as 14:24

// METHOD GET
// URLBASE PARA AUTENTICAR
define("URLBASE_GERA_ORDENS_PLATAFORMA", "http://integration-api.uello.com.br/");

class GetPedidosUello{
    
    function resource(){
        return $this->get('v1/orders');
    }

    function get($resource){

        // ENDPOINT para requisição
        $endpoint = URLBASE_GERA_ORDENS_PLATAFORMA.$resource;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);

        if($httpCode == "200"){
            echo "Ordem Geradas com Sucesso!";
        }else if($httpCode == "404"){
            echo "Ordem Não Encontrada Verifique!";
        }
        echo "<pre>";
        $res = json_decode($response,false);
        print_r($res);
    }
}


$GetPedidos = new GetPedidosUello;
$GetPedidos->resource();