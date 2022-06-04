<?php
set_time_limit(0);
// Atualiza Status do Pedido para o Cliente
// create by GUILHERME TAIRA  --> 06/12/2021 as 16:20

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URLBASE_UPDATE_STATUS_ORDER_PLATAFORMA", "http://integration-api.uello.com.br/");

class UpdateOrder{

    private $KeyValue;

    function __construct($KeyValue)
    {
        $this->KeyValue = $KeyValue;
    }

    function resource(){

        // seta valores da variavel 
        $this->setKeyValue($this->KeyValue);
        // retorno do ENDPOINT
        return $this->get('v1/order/ocoren?key=invoice_key&value='.$this->getKeyValue().'&with=all');
    }

    function get($resource){
        // ENDPOINT PARA REQUICAO
        $endpoint = URLBASE_UPDATE_STATUS_ORDER_PLATAFORMA.$resource;
        
        //echo $endpoint . "<br>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // echo "Status Code: ".$httpCode."<br>";
        $json = json_decode($response,false);
    //    echo "<pre>";
        if($httpCode == "200"){
            return $json;
        }else if($httpCode == "404"){
            //echo "Ordem Não Encontrada Verifique!";
        }
    }
    
    /**
     * Get the value of KeyValue
     */ 
    public function getKeyValue()
    {
        return $this->KeyValue;
    }

    /**
     * Set the value of KeyValue
     *
     * @return  self
     */ 
    public function setKeyValue($KeyValue)
    {
        $this->KeyValue = $KeyValue;

        return $this;
    }
}

abstract class UpdatePedidosBanco {
    public abstract function AtualizaGravaPedido($indenficador,PDO $pdo2);
    public abstract function EnviaOrdemTray($indenficador,PDO $pdo2);
    public abstract function AtualizaOrdemEnviado($indenficador,PDO $pdo2);
    public abstract function AtualizaOrdemTransito($indenficador,PDO $pdo2);
    public abstract function AtualizaOrdemFinalizado($indenficador,PDO $pdo2);
}


class UpdatePedidoTray extends UpdatePedidosBanco{

    public function AtualizaGravaPedido($indenficador,PDO $pdo2){
        return new UpdateOrder($indenficador);
    }

    public function AtualizaOrdemEnviado($indenficador,PDO $pdo2){

        $statement2 = $pdo2->query("SELECT * from UelloPedidos WHERE chaveNota = '$indenficador' and FlagEnviado = 'X'");
        $statusPedido = $statement2->fetch();
        $PedidoUello = json_decode(json_encode($statusPedido),false);
        
        if(!empty($PedidoUello)){
            echo "<div class='alert alert-primary' role='alert'>NOTA - > $PedidoUello->chaveNota <strong> Enviado </strong> </div>";

            // TIRA A FLAG X DO FLAG ENVIADO
            $statement3 = $pdo2->query("UPDATE UelloPedidos SET FlagEnviado = '' WHERE chaveNota = '$PedidoUello->chaveNota'");
            $statement3->execute();
            // //Status de Enviado
            $status = 342;
            // requisicao enviada para tray loja 
            $PutOrderTray = new PutOrderTray($_SESSION['access_token_tray'],$PedidoUello->Orderid,$status,$PedidoUello->url_rastreio);
            $PutOrderTray->resource();
        }
    }


    public function AtualizaOrdemTransito($indenficador,PDO $pdo2){
        $statement2 = $pdo2->query("SELECT * from UelloPedidos WHERE chaveNota = '$indenficador' and FlagTransito = 'X'");
        $statusPedido = $statement2->fetch();
        $PedidoUello = json_decode(json_encode($statusPedido), false);

       
        if (!empty($PedidoUello)) {
            echo "<div class='alert alert-primary' role='alert'>NOTA - > $PedidoUello->chaveNota <strong> Em Trânsito </strong></div>";

            $statement4 = $pdo2->query("UPDATE UelloPedidos SET FlagTransito = '' WHERE chaveNota = '$PedidoUello->chaveNota'");
            $statement4->execute();
            // //Status EM TRANSITO
            $status = 371;
            // requisicao enviada para tray loja
            $PutOrderTray = new PutOrderTray($_SESSION['access_token_tray'], $PedidoUello->Orderid, $status, $PedidoUello->url_rastreio);
            $PutOrderTray->resource();
        }
    }

    public function AtualizaOrdemFinalizado($indenficador,PDO $pdo2){
        $statement2 = $pdo2->query("SELECT * from UelloPedidos WHERE chaveNota = '$indenficador' and FlagFinalizado = 'X'");
        $statusPedido = $statement2->fetch();
        $PedidoUello = json_decode(json_encode($statusPedido),false);
      
        if(!empty($PedidoUello)){
            echo "<div class='alert alert-success' role='alert'>NOTA - > $PedidoUello->chaveNota <strong> Finalizado </strong></div>";

            $statement5 = $pdo2->query("UPDATE UelloPedidos SET FlagFinalizado = '' WHERE chaveNota = '$PedidoUello->chaveNota'");
            $statement5->execute();
            // //Status EM TRANSITO
            $status = 69;
            // // requisicao enviada para tray loja 
            $PutOrderTray = new PutOrderTray($_SESSION['access_token_tray'],$PedidoUello->Orderid,$status,$PedidoUello->url_rastreio);
            $PutOrderTray->resource();
        }
    }

    public function EnviaOrdemTray($indenficador,PDO $pdo2){
    // CONEXAO COM O BANCO
    include_once 'conexao_pdo.php';

    // CHAMA A FUNÇÃO PARA RETORNAR OS STATUS
    include_once 'TrayPutPedido.php';
    
    // STATEMENT DE BUSCA
    $statement = $pdo2->query("SELECT * FROM UelloPedidos WHERE FlagEnviado = 'X' OR FlagTransito = 'X' OR FlagFinalizado = 'X'");
    $Flag = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($Flag as $Order) {
        $ordem =  json_decode(json_encode($Order),false);
        $NovaOrdem = $this->AtualizaGravaPedido($ordem->chaveNota,$pdo2);
        $Status = $NovaOrdem->resource();

        if(empty($Status)){
            $codigo = 0;
        }else{
            foreach ($Status->data as $order) {
                $codigo = $order->code;
            }
        }

        switch ($codigo) {
                case 101:
                        $this->AtualizaOrdemEnviado($ordem->chaveNota,$pdo2);
                    break;
                case 102:
                        $this->AtualizaOrdemTransito($ordem->chaveNota,$pdo2);
                    break;
                case 1:
                        $this->AtualizaOrdemFinalizado($ordem->chaveNota,$pdo2);
                default:
                // echo "<hr> Nenhum Status Para Atualizar!  <hr>";
                    break;
            }
        }
    }
}


/**
 *  TABELA DE STATUS TRAY 
 * 
 *  FINALIZADO = 69
 *  ENVIADO = 342
 *  AGUARDANDO ENVIO = 31
 *  
*/


/**
 * 
 * 
 * -   0 - Arquivo Recebido
 * -  101 - Pedido Recebido
  *   103 - Cte emitido
   *  100 - Pedido Em Rota de Coleta ou Motorista saiu para Coleta
    * 102 - Pedido Em Rota de entrega
     * 1 - Entrega Realizada

    *Insucessos
    *   6 - Endereço do Cliente não Localizado
    *  27 - Carga Sinistrada
    *  46 - Cliente Ausente
    *  77 - Cliente Mudou de Endereço
    *  78 - Avaria
    * 81 - Extravio Total
    * 104 - Reagendado
    *  99 - Cliente Recusou
    *  20 - Entrega Prejudicada por Horário/Falta de Tempo Hábil
    * 400 - Pedido cancelado
    * 401 - Pedido Não coube
    * 402 - Informação divergente
    * 403 - Pedido indisponível
    * 404 - Pedido não encontrado
    * 405 - Pedido não coletado

    * Devolução
    * 998 - Iniciado processo de Devolução
    * 999 - Devolvido
 */

