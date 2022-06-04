<?php
//include_once 'APPEMBALEME/AppEmbalemeAuth.php';
// ---------- SESSÂO ABERTA --------------//

// POST PEDIDO BLING 
// create by GUILHERME TAIRA  --> 25/01/2022 as 16:36

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_POST_PRODUTO_BLING", "https://bling.com.br/Api/");

class ProdutoBlingUpdate
{

    private $produto;
    private $idloja;
    private $valorShopee;

    public function __construct($produto,$valorShopee,$idloja)
    {
        $this->produto = $produto;
        $this->valorShopee = $valorShopee;
        $this->idloja = $idloja;
    }

    public function resource()
    {
        return $this->get("v2/produtoLoja/".$this->getIdloja()."/".$this->getProduto()."/json/");
    }

    public function get($resource)
    {
        // URL PARA REQUISICAO
        $endpoint = URL_BASE_POST_PRODUTO_BLING . $resource;

        $xml = "
        <?xml version='1.0' encoding='UTF-8'?>
        <produtosLoja>
            <produtoLoja>
            <idLojaVirtual>203436048</idLojaVirtual>
            <preco>
                <preco></preco>
                <precoPromocional>-01</precoPromocional>
            </preco>
        </produtoLoja>
        </produtosLoja>";

        $posts = array(
            "apikey" => "a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277",
            "xml" => rawurlencode($xml),
        );

        echo $endpoint;

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $endpoint);
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $posts);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        echo "<pre>";
        print_r($response);
    }

    /**
     * Get the value of produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * Set the value of produto
     *
     * @return  self
     */
    public function setProduto($produto)
    {
        $this->produto = $produto;

        return $this;
    }

    /**
     * Get the value of idloja
     */ 
    public function getIdloja()
    {
        return $this->idloja;
    }

    /**
     * Set the value of idloja
     *
     * @return  self
     */ 
    public function setIdloja($idloja)
    {
        $this->idloja = $idloja;

        return $this;
    }

    /**
     * Get the value of valorShopee
     */ 
    public function getValorShopee()
    {
        return $this->valorShopee;
    }

    /**
     * Set the value of valorShopee
     *
     * @return  self
     */ 
    public function setValorShopee($valorShopee)
    {
        $this->valorShopee = $valorShopee;

        return $this;
    }
}

$produto = new ProdutoBlingUpdate('5802695',10,'203436048', '');
print_r($produto->resource());
