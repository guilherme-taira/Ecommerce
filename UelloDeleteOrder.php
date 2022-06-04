<?php
// Deleta um Pedido dentro da Plataforma Uello
// create by GUILHERME TAIRA  --> 06/12/2021 as 14:56

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URLBASE_DELETA_ORDER_PLATAFORMA", "http://integration-api.uello.com.br/v1/");

class DeleteOrder{

    private $Order;

    function resource($Order){

        $this->setOrder($Order);
        return $this->get('orders?key=invoice_key&value='.$Order);
    }

    function get($resource){

        // endpoint para requisição
        $endpoint = URLBASE_DELETA_ORDER_PLATAFORMA.$resource;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($httpCode == "200"){
            echo "Ordem Cancelada com Sucesso!";
        }else if($httpCode == "404"){
            echo "Ordem Não Encontrada Verifique!";
        }
       
    }

    /**
     * Get the value of Order
     */ 
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * Set the value of Order
     *
     * @return  self
     */ 
    public function setOrder($Order)
    {
        $this->Order = $Order;

        return $this;
    }
}

$DeleteOrder = new DeleteOrder;
$DeleteOrder->resource('35211200458459000133550030001144101785680000');

