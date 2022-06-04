<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// PUT ATUALIZA PRODUTOS TRAY 
// create by GUILHERME TAIRA  --> 20/12/2021 as 16:31

// METHOD GET

// URLBASE PARA AUTENTICAR
define("URL_BASE_PUT_ATUALIZA_PRODUTOS_TRAY", "https://testeblipchat.commercesuite.com.br/web_api");

class AtualizaPrecoEstoqueTray
{

    private $id;
    private $preco;
    private $Preco_custo;
    private $saldo;
    private $acces_token;
    private $ativo;
    private $image1;

    function __construct($acces_token, $id, $preco, $Preco_custo,$saldo, $ativo,$image1)
    {
        $this->acces_token = $acces_token;
        $this->id = $id;
        $this->preco = $preco;
        $this->Preco_custo = $Preco_custo;
        $this->saldo = $saldo;
        $this->ativo = $ativo;
        $this->image1 = $image1;
    }

    function resource()
    {
        return $this->get("products/{$this->getId()}?access_token=" . $this->getAcces_token());
    }

    function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_PUT_ATUALIZA_PRODUTOS_TRAY . $resource;

        // dados Array
        $data = array(
            "Product" => array(
                "price" => $this->getPreco(),
                "cost_price" => $this->getPreco_custo(),
                "stock" => $this->getSaldo(),
                "available" => $this->getAtivo(),
                "picture_source_1" => $this->getImage1(),
            ),
        );

        // data convertido em json
        $data_json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        echo "<pre>";
        print_r($data_json);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $endpoint,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //echo "<pre>";
        $decode = json_decode($response, false);

        // if ($httpCode == "200") {
        //     $_SESSION["msg_success"] = "<div class='alert alert-success'> Produto Atualizado com Sucesso! </div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // } else if ($httpCode == "400") {
        //     $_SESSION["msg_error"] = "<div class='alert alert-danger'> Erro ao Cadastraro  Produto Verifique! </div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // }

        return $decode;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of preco
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * Set the value of preco
     *
     * @return  self
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }

    /**
     * Get the value of saldo
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set the value of saldo
     *
     * @return  self
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get the value of acces_token
     */
    public function getAcces_token()
    {
        return $this->acces_token;
    }

    /**
     * Set the value of acces_token
     *
     * @return  self
     */
    public function setAcces_token($acces_token)
    {
        $this->acces_token = $acces_token;

        return $this;
    }

    /**
     * Get the value of image1
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set the value of image1
     *
     * @return  self
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get the value of ativo
     */ 
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * Set the value of ativo
     *
     * @return  self
     */ 
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get the value of Preco_custo
     */ 
    public function getPreco_custo()
    {
        return $this->Preco_custo;
    }

    /**
     * Set the value of Preco_custo
     *
     * @return  self
     */ 
    public function setPreco_custo($Preco_custo)
    {
        $this->Preco_custo = $Preco_custo;

        return $this;
    }
}

$id = $_REQUEST['id_produto'];
$Valor_Unit = $_REQUEST['valor_unit'];
$Preco_Custo = $_REQUEST['precocusto'];
$Estoque = $_REQUEST['estoque'];
$Condicao = $_REQUEST['condicao'];
$url_img_principal = $_REQUEST['url_img_principal'];

print_r($_REQUEST);

$AtualizaPrecoEstoqueTray = new AtualizaPrecoEstoqueTray($_SESSION['access_token_tray'],$id,$Valor_Unit,$Preco_Custo,$Estoque,$Condicao,$url_img_principal);
print_r($AtualizaPrecoEstoqueTray->resource());
