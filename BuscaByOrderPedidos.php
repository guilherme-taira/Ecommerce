<?php

// ---------- SESSÂO ABERTA --------------//

// autenticação para pegar o ACESS_TOKEN DA api INVOICE
// create by GUILHERME TAIRA  --> 24/11/2021 as 14:42

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_BUSCA_BYORDERNUMBER_YAPAY", "https://api.intermediador.yapay.com.br/");

class GetOrderByNumberYapay
{
    private $token;
    private $status;
    private $order_number;
    private $customer;
    private $dataInicial;
    private $dataFinal;
    private $page;
    private $LastPage;

    function __construct($token, $status = "", $order_number = "", $customer = "", $dataInicial = "", $dataFinal = "",$page = 0)
    {
        $this->token = $token;
        $this->status = $status;
        $this->order_number = $order_number;
        $this->customer = $customer;
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
        $this->page = $page;
    }


    function resource()
    {
        // seta os valores das variaveis
        $this->setToken($this->token);
        $this->setStatus($this->status);
        $this->setOrder_number($this->order_number);
        $this->setPage($this->page);

        // retorno do endpoint para requisição
        return $this->get('api/v3/sales');
    }

    function get($resource)
    {

        // endpoint para requsição CURL
        $endpoint = URL_BASE_BUSCA_BYORDERNUMBER_YAPAY . $resource;

        $filtros = array(
            "status" => $this->getStatus(),
            "order_number" => $this->getOrder_number(),
            "customer" => $this->getCustomer(),
            "start_date_created" => $this->getDataInicial(),
            "end_date_created" => $this->getDataFinal(),
            "current_page" => $this->getPage(),
        );

      

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $filtros);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Token token={$this->getToken()}, type=access_token"]);

        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);
        
       // setando a variavel com a ultima pagina
       $this->setLastPage($res->pagination->page_amount);
        // chamada da class / instancia do objeto 
        include_once 'BancoRet.php';
        include_once 'BuscaByOrderBytransactionToken.php';

        echo "<table class='table'>
        <thead>
          <tr>
            <th scope='col'>Imagem</th>
            <th scope='col'>Nome</th>
            <th scope='col'>CPF</th>
            <th scope='col'>Número Pedido</th>
            <th scope='col'>Status</th>
            <th scope='col'>Valor Original</th>
            <th scope='col'>Taxa</th>
            <th scope='col'>% Taxa</th>
            <th scope='col'>Valor Líquido</th>
            <th scope='col'>Frete</th>
            <th scope='col'>Aprovado</th>
            <th scope='col'>Pagamento</th>
            <th scope='col'>Data Baixa</th>
            <th scope='col'>Número da Nota</th>
            <th scope='col'>Valor Declarado</th>
            <th scope='col'>Orçamento RET</th>
          </tr>
        </thead>
        <tbody>";
        foreach ($res->data as $dados) {
            echo "<tr><td><img src='{$dados->transaction_products[0]->img_url}'></td>";
            echo "<td>{$dados->customer->name}</td>";
            echo "<td>{$dados->customer->cpf}</td>";
            echo "<td><a href='YapayIndex.php?numpedido={$dados->order_number}'>{$dados->order_number}</a></td>";

            // status do pedido verificação
            if ($dados->status->name == "monitoring") {
                echo "<td><p class='badge bg-warning text-dark'>Monitorando</p></td>";
            } else if ($dados->status->name == "approved") {
                echo "<td><p class='badge bg-success'>Aprovado</p></td>";
            } else if ($dados->status->name == "waiting_payment") {
                echo "<td><p class='badge bg-primary'>Aguardando Pagamento</p></td>";
            } else if ($dados->status->name == "canceled") {
                echo "<td><p class='badge bg-danger'>Cancelado</p></td>";
            } else if ($dados->status->name == "contestation") {
                echo "<td><p class='badge bg-warning text-dark'>Em Contestação</p></td>";
            } else if ($dados->status->name == "chargeback") {
                echo "<td><p class='badge bg-warning text-dark'>chargeback</p></td>";
            } else if ($dados->status->name == "failed") {
                echo "<td><p class='badge bg-danger'>Reprovada</p></td>";
            }

            echo "<td>{$dados->original_price}</td>";
            echo "<td>".number_format(floatval($dados->tax),2)."</td>";
            echo "<td>".number_format($this->CalculaPorcentagem($dados->original_price,$dados->tax),2)."%</td>";
            echo "<td>{$dados->seller_price}</td>";
            echo "<td>{$dados->shipping->shipping_price}</td>";

            // Dados de data de pagamento e recebimento
            $createOrder = new BuscaByOrderBytransactionToken($_SESSION['access_token'], '8e1e557f716763a', $dados->transaction_token);
            $createOrder->resource();

            include_once 'BancoRet.php';
            /***
             * 
             * DADOS DO BANCO RET 
             * 
            ***/
            $sql = "SELECT FIRST 1 * from ret305 WHERE ORCANDROID = '{$dados->order_number}'";
            //echo "$sql";
            $statement = $pdo->query($sql);
            $orcamentos = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($orcamentos as $orcamento) {
                // Transformação dos dados orçamento em Objeto.
                $obj = (object) $orcamento;
                // Query SQL
                $sql = "SELECT FIRST 1 A04, Q07, Q08, Q16, recnumeronf, recvlr, RECpago, ORCNUM from ret092,ret150 WHERE ORCNUM = '$obj->ORCNUM'";
                // Busca dos Dados
                $statement = $pdo->query($sql);
                $Pedidos = $statement->fetchAll(PDO::FETCH_ASSOC);
                // Verifica se existe a baixa no Banco RET
                if(isset($obj->ORCBAIXA)){
                    echo "<td><span class='badge bg-success'>{$obj->ORCBAIXA}</span></td>";
                }else{
                    echo "<td><span class='badge bg-secondary'>Aguardando..</span></td>";
                }
                // VALORES DO PEDIDO TABELA RET092,RET150
                foreach ($Pedidos as $pedido) {
                    echo "<td>{$pedido['RECNUMERONF']}</td>";
                    echo "<td>{$pedido['RECVLR']}</td>";
                    echo "<td>{$pedido['ORCNUM']}</td>";
                }
            
            }
         
            // $sql = "SELECT A04, Q07, Q08, Q16 FROM ret150 WHERE T03 LIKE '%{$dados->order_number}%'";
            // $statement = $pdo->query($sql);
            // $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            // foreach ($registros as $registro) {
            //     echo "
            //     <td>{$registro['A04']}</td>
            //     <td>{$registro['Q07']}</td>
            //     <td>{$registro['Q16']}</td>
            //     ";
            // }
            echo "</tr>";
            "</tbody>
             </table>
            ";
        }

    
    }

    
   
    public function CalculaPorcentagem($valorOriginal, $taxa)
    {
         return floatval($taxa) / floatval($valorOriginal) * 100;
    }
 

    public function UnixDate($data)
    {
        $timestamp = strtotime($data);
        return $timestamp;
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
     * Get the value of customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the value of customer
     *
     * @return  self
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get the value of dataInicial
     */ 
    public function getDataInicial()
    {
        $timestamp = strtotime($this->dataInicial);
        return $timestamp;
    }

    /**
     * Set the value of dataInicial
     *
     * @return  self
     */ 
    public function setDataInicial($dataInicial)
    {
        $this->dataInicial = $dataInicial;

        return $this;
    }

    /**
     * Get the value of dataFinal
     */ 
    public function getDataFinal()
    {
        $timestamp = strtotime($this->dataFinal);
        return $timestamp;
    }

    /**
     * Set the value of dataFinal
     *
     * @return  self
     */ 
    public function setDataFinal($dataFinal)
    {
        $this->dataFinal = $dataFinal;

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
     * Get the value of LastPage
     */ 
    public function getLastPage()
    {
        return $this->LastPage;
    }

    /**
     * Set the value of LastPage
     *
     * @return  self
     */ 
    public function setLastPage($LastPage)
    {
        $this->LastPage = $LastPage;

        return $this;
    }
}


// @emba3571