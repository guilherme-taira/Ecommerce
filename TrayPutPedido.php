<?php
include_once 'APPEMBALEME/AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// PUT ATUALIZA PEDIDO TRAY 
// create by GUILHERME TAIRA  --> 14/12/2021 as 09:54

// METHOD PUT

// URLBASE PARA AUTENTICAR
define("URL_BASE_PUT_PEDIDO_TRAY", "https://www.embaleme.com.br/web_api/");

class PutOrderTray{

    private $acess_token;
    private $order;
    private $status;
    private $taxes;
    private $shipment;
    private $shipment_value;
    private $discount;
    private $sending_code;
    private $sending_date;
    private $tracking_url;
    private $store_note;
    private $customer_note;
    private $partner_id;

    function __construct($acess_token,$order,$status,$tracking_url)
    {   
        $this->acess_token = $acess_token;
        $this->order = $order;
        $this->status = $status;
        $this->tracking_url = $tracking_url;
    }

    function resource(){
        return $this->get('orders/'.$this->getOrder().'?access_token='.$this->getAcess_token());
    }

    function get($resource){
        //ENDPOINT para quesição
        $endpoint = URL_BASE_PUT_PEDIDO_TRAY.$resource;

        $data = array(
                'Order' => [
                    'status_id' => $this->getStatus(),
                    'tracking_url' => $this->getTracking_url(),
                ],
        );

        // transforma array data em json
        $data_json = json_encode($data);
        // print_r($data_json);
        // echo $endpoint;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response,false); 
        //echo "<pre>";
        //print_r($requisicao);
       //echo $httpCode;
        if($httpCode == "200"){
            //echo "Pedido atualizado Com Sucesso!!";
        }else if($httpCode == "400"){
            //echo "Ordem Não Encontrada Verifique!";
        }
        
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

    /**
     * Get the value of taxes
     */ 
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Set the value of taxes
     *
     * @return  self
     */ 
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * Get the value of shipment
     */ 
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * Set the value of shipment
     *
     * @return  self
     */ 
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * Get the value of shipment_value
     */ 
    public function getShipment_value()
    {
        return $this->shipment_value;
    }

    /**
     * Set the value of shipment_value
     *
     * @return  self
     */ 
    public function setShipment_value($shipment_value)
    {
        $this->shipment_value = $shipment_value;

        return $this;
    }

    /**
     * Get the value of discount
     */ 
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set the value of discount
     *
     * @return  self
     */ 
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get the value of sending_code
     */ 
    public function getSending_code()
    {
        return $this->sending_code;
    }

    /**
     * Set the value of sending_code
     *
     * @return  self
     */ 
    public function setSending_code($sending_code)
    {
        $this->sending_code = $sending_code;

        return $this;
    }

    /**
     * Get the value of sending_date
     */ 
    public function getSending_date()
    {
        return $this->sending_date;
    }

    /**
     * Set the value of sending_date
     *
     * @return  self
     */ 
    public function setSending_date($sending_date)
    {
        $this->sending_date = $sending_date;

        return $this;
    }

    /**
     * Get the value of store_note
     */ 
    public function getStore_note()
    {
        return $this->store_note;
    }

    /**
     * Set the value of store_note
     *
     * @return  self
     */ 
    public function setStore_note($store_note)
    {
        $this->store_note = $store_note;

        return $this;
    }

    /**
     * Get the value of customer_note
     */ 
    public function getCustomer_note()
    {
        return $this->customer_note;
    }

    /**
     * Set the value of customer_note
     *
     * @return  self
     */ 
    public function setCustomer_note($customer_note)
    {
        $this->customer_note = $customer_note;

        return $this;
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
     * Get the value of tracking_url
     */ 
    public function getTracking_url()
    {
        return $this->tracking_url;
    }

    /**
     * Set the value of tracking_url
     *
     * @return  self
     */ 
    public function setTracking_url($tracking_url)
    {
        $this->tracking_url = $tracking_url;

        return $this;
    }

    /**
     * Get the value of partner_id
     */ 
    public function getPartner_id()
    {
        return $this->partner_id;
    }

    /**
     * Set the value of partner_id
     *
     * @return  self
     */ 
    public function setPartner_id($partner_id)
    {
        $this->partner_id = $partner_id;

        return $this;
    }
}


// $id_pedido = isset($_REQUEST['id_pedido']) ? $_REQUEST['id_pedido'] : 0;
// $status = 342;

// $PutOrderTray = new PutOrderTray($_SESSION['access_token_tray'],$id_pedido,$status);
// $PutOrderTray->resource();


//*****TABELA DE PEDIDOS STATUS ****//
// 124117 -> ENTREGUE
// 124113 -> AGUARDANDO PAGAMENTO
// 124009 -> EM TRANSITO
// 124141 -> ENVIADO
// 124123 -> APROVADO
// 31 -> TRAY -> AGUARDANDO ENVIO
