<?php
// INCLUIR CONEXAO COM BANCO DO RET

interface BancoRetPedidos
{
    public function GravaBancoPedidos(\PDO $pdo,\PDO $pdo2);
    public function PesquisaPedidoBancoRet($id_pedido,\PDO $pdo,\PDO $pdo2);
}

class UpdatePedidosRET implements BancoRetPedidos
{
    private $codigo;
    private $pdo;

    // public function __construct($codigo)
    // {
    //     $this->codigo = $codigo;

    // }

    // PDO2 -> BANCO NA NUVEM
    // PDO -> BANCO RET

    public function GravaBancoPedidos(\PDO $pdo,\PDO $pdo2)
    {
       // PDO STATEMENT
       $statement = $pdo2->query("SELECT DISTINCT n_pedido FROM pedidos WHERE data_inclusao BETWEEN '2022-03-01' and '2022-03-05' and Flag_divergencia = ''");
       $pedidos = $statement->fetchAll(PDO::FETCH_ASSOC);
       echo "<pre>";
       foreach ($pedidos as $pedido) {
            $this->PesquisaPedidoBancoRet($pedido,$pdo,$pdo2);
       }
       echo "</pre>";

    }

    public function PesquisaPedidoBancoRet($id_pedido, \PDO $pdo, \PDO $pdo2)
    {
        $statement2 = $pdo->query("SELECT * FROM ret305 where ret305.".'"orcandroid"'." = '$id_pedido'");
        $pedidos = $statement2->fetch(PDO::FETCH_ASSOC);
        return $pedidos;
    }


    /**
     * Get the value of codigo
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of pdo
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * Set the value of pdo
     *
     * @return  self
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;

        return $this;
    }
}


include_once '../conexao_pdo.php';


$CadastraPedido = new UpdatePedidosRET();
$CadastraPedido->GravaBancoPedidos($pdo,$pdo2);