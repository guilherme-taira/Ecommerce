<?php
// ---------- SESSÂO ABERTA --------------//
  
// autenticação para pegar o ACESS_TOKEN DA api INVOICE
// create by GUILHERME TAIRA  --> 24/11/2021 as 14:42

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_BUSCA_BYORDERNUMBER_YAPAY","https://api.intermediador.yapay.com.br/");

class GetOrderByNumberYapay {

    private $order_number;
    private $token;

    function __construct($order_number,$token)
    {
        $this->order_number = $order_number;
        $this->token = $token;   
    }


    function resource(){
        // seta os valores das variaveis
        $this->setToken($this->token);
        $this->setOrder_number($this->order_number);

        return $this->get('api/v3/sales?order_number='.$this->getOrder_number());
    }

    function get($resource){
        
        // endpoint para requsição CURL
        $endpoint = URL_BASE_BUSCA_BYORDERNUMBER_YAPAY.$resource;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, ["Authorization: Token token={$this->getToken()}, type=access_token"]);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);

        // echo "<pre>";
        // foreach ($res->data as $dados) {
        //     print_r($dados);
        // }
        // chamada da class RET 
     
        echo "<table class='table'>
        <thead>
          <tr>
            <th scope='col'>Nome</th>
            <th scope='col'>CPF</th>
            <th scope='col'>Número Pedido</th>
            <th scope='col'>Status</th>
            <th scope='col'>Valor Original</th>
            <th scope='col'>Taxa</th>
            <th scope='col'>Valor Líquido</th>
            <th scope='col'>Frete</th>
          </tr>
        </thead>
        <tbody>
          <tr>";       
        foreach ($res->data as $dados) {
            // echo "<td><img src='{$dados->transaction_products[0]->img_url}'></td>";
            
            echo "<td>{$dados->customer->name}</td>";
            echo "<td>{$dados->customer->cpf}</td>";
            echo "<td>{$dados->order_number}</td>";
            
               // status do pedido verificação
            if($dados->status->name == "monitoring"){
                echo "<td><p class='badge bg-warning text-dark'>Monitorando</p></td>";
            }else if($dados->status->name == "approved"){
                echo "<td><p class='badge bg-success'>Aprovado</p></td>";
            }else if($dados->status->name == "waiting_payment"){
                echo "<td><p class='badge bg-primary'>Aguardando Pagamento</p></td>";
            }
            else if($dados->status->name == "canceled"){
            echo "<td><p class='badge bg-danger'>Cancelado</p></td>";
            }
            else if($dados->status->name == "contestation"){
                echo "<td><p class='badge bg-warning text-dark'>Em Contestação</p></td>";
            }
            else if($dados->status->name == "chargeback"){
                echo "<td><p class='badge bg-warning text-dark'>chargeback</p></td>";
            }
            else if($dados->status->name == "failed"){
                echo "<td><p class='badge bg-danger'>chargeback</p></td>";
            }

            echo "<td>{$dados->original_price}</td>";
            echo "<td>{$dados->tax}</td>";
            echo "<td>{$dados->seller_price}</td>";
            echo "<td>{$dados->shipping->shipping_price}</td> ";
        }
          
        include_once 'BancoRet.php';
        
        echo "<tr><th>Imagens</th><th>Descrição</th><th>Valor</th><th>Quantidade</th><th>SKU</th><th>Preço Custo</th><th>Preço Venda</th><th>Custo Final</th></tr>";
        foreach ($res->data as $dados) {
          foreach ($dados->transaction_products as $Fotos) {
             echo "<tr>
             <td><img src='{$Fotos->img_url}'></td>
             <td>$Fotos->description</td>
             <td>$Fotos->unit_price</td>
             <td>".intval($Fotos->quantity)."</td>
             <td>$Fotos->code</td>";
             $sql = "SELECT".'"PRODCusto"'.",".'"PRODVenda"'.",".'"PRODCUSTOFINAL"'."from ret051 WHERE PRODIDSITE = '$Fotos->code'";
             $statement = $pdo->query($sql);
             $produtos = $statement->fetchAll(PDO::FETCH_ASSOC);
             foreach($produtos as $produto){
               $precoCusto = floatval($produto['PRODCusto']);
               $prodVenda = floatval($produto['PRODVenda']);
               $prodCustoFinal = floatval($produto['PRODCUSTOFINAL']);
                echo"<td>".number_format($precoCusto, 2)."</td>";
                echo"<td>".number_format($prodVenda, 2)."</td>";
                echo"<td>".number_format($prodCustoFinal, 2)."</td>";
             }
             "</tr>"; 
          }
        }
          "</tr>
        </tbody>
      </table>
        ";
    }

    /**
     * Get the value of order_number
     */ 
    public function getOrder_number()
    {
        return $this->order_number;
    }

    /**
     * Set the value of order_number
     *
     * @return  self
     */ 
    public function setOrder_number($order_number)
    {
        $this->order_number = $order_number;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}

