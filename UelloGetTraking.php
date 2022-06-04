<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
// Envia os dados do Pedidod e Atualiza no banco o id do pedido e a url de rastreio Uello
// create by GUILHERME TAIRA  --> 06/12/2021 as 14:56

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URLBASE_GET_DADOS_PEDIDO_ORDER_PLATAFORMA", "http://integration-api.uello.com.br/");


interface UelloGetDados
{
    public function resource();
    public function get($resource);
}

class GetDadosDoPedido implements UelloGetDados
{

    private $id_pedido;

    public function __construct($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

    public function resource()
    {
        return $this->get('v1/orders/' . $this->getId_pedido());
    }

    public function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = URLBASE_GET_DADOS_PEDIDO_ORDER_PLATAFORMA . $resource;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // print_r($response);
        if ($httpCode == "200") {
            return json_decode($response, false);
        } else if ($httpCode == "404") {
            //echo "Ordem Não Encontrada Verifique!";
        }
    }
    /**
     * Get the value of id_pedido
     */
    public function getId_pedido()
    {
        return $this->id_pedido;
    }

    /**
     * Set the value of id_pedido
     *
     * @return  self
     */
    public function setId_pedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;

        return $this;
    }
}

abstract class GravaBancoUello
{
    public abstract function GravaPedido($id_pedido, PDO $pdo2);
    public abstract function RevisaCampoRastreio($id_pedido,$rastreio, PDO $pdo2);
}

class BancoGuardaDados extends GravaBancoUello
{   
    // constante de flag do banco
    const X = 'X';

    public function RevisaCampoRastreio($id_pedido,$rastreio, PDO $pdo2)
    {
        if(empty($rastreio)) {
            try {
                $pdo2->beginTransaction();
                $statement6 = $pdo2->prepare("UPDATE UelloPedidos SET FlagStatus = :Flag_Status WHERE Id_Uello = :id_uello");
                $statement6->bindValue(':Flag_Status', self::X , PDO::PARAM_STR);
                $statement6->bindValue(':id_uello', $id_pedido, PDO::PARAM_STR);
                $statement6->execute();
                $pdo2->commit();
            } catch (\PDOException $th) {
                $pdo2->rollBack();
            }
            
        }
    }

    public function GravaPedido($id_pedido, PDO $pdo2)
    {
        $GetDados = new GetDadosDoPedido($id_pedido);
        $dados = json_decode(json_encode($GetDados->resource()), false);
        // STATEMENT SQL
        try {
            $pdo2->beginTransaction();
            $statement5 = $pdo2->prepare("UPDATE UelloPedidos SET url_rastreio = :url_rastreio WHERE Id_Uello = :id_uello");
            $statement5->bindValue(':url_rastreio', $dados->data->data->tracking, PDO::PARAM_STR);
            $statement5->bindValue(':id_uello', $id_pedido, PDO::PARAM_STR);
            $statement5->execute();
            $pdo2->commit();
        } catch (\PDOException $e) {
            $pdo2->rollBack();
            // echo $e->getCode();
            // echo $e->getMessage();
        }

         // revisa campo de rastreio vazio
        $this->RevisaCampoRastreio($id_pedido,$dados->data->data->tracking,$pdo2);
    }
}
