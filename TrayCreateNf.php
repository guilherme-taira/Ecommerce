<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// POST CREATE NOTA FISCAL TRAY 
// create by GUILHERME TAIRA  --> 23/12/2021 as 15:30

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_POST_NOTAFISCAL_TRAY_NF", "https://testeblipchat.commercesuite.com.br/web_api/");

class CreateNfTray
{

    private $access_token;
    private $OrderNumber;
    private $issue_date;
    private $number;
    private $serie;
    private $value;
    private $key;
    private $link;
    private $xml_danfe;
    private $ProductCfopId;
    private $ProductCfopVariation;
    private $ProductCfopCfop;

    function __construct($access_token, $issue_date, $number, $serie, $value, $key, $link, $ProductCfopId, $ProductCfopVariation, $ProductCfopCfop,$OrderNumber)
    {
        $this->access_token = $access_token;
        $this->issue_date = $issue_date;
        $this->number = $number;
        $this->serie = $serie;
        $this->value = $value;
        $this->key = $key;
        $this->link = $link;
        $this->ProductCfopId = $ProductCfopId;
        $this->ProductCfopVariation = $ProductCfopVariation;
        $this->ProductCfopCfop = $ProductCfopCfop;
        $this->OrderNumber = $OrderNumber;

    }

    function resource()
    {
        return $this->get('orders/'.$this->getOrderNumber().'/invoices?access_token=' . $this->getAccess_token());
    }

    function get($resource)
    {
        // URL PARA REQUISICAO
        $endpoint = URL_BASE_POST_NOTAFISCAL_TRAY_NF . $resource;

        /***
         * CRIAÇÂO DA XML
         * **/
        $this->setXml_danfe($this->GeraXml($this->getIssue_date(),$this->getNumber(),$this->getSerie(),$this->getValue(),$this->getKey(),$this->getLink(),$this->getProductCfopCfop(),$this->getProductCfopCfop(),$this->getProductCfopVariation(),$this->getProductCfopId()));

        $data = array(
            "issue_date" => $this->getIssue_date(),
            "number" => $this->getNumber(),
            "serie" => $this->getSerie(),
            "value" => $this->getValue(),
            "key" => $this->getKey(),
            "link" => $this->getLink(),
            "xml_danfe" => $this->getXml_danfe(),
            "ProductCfop" => array([
                "product_id" => $this->getProductCfopId(),
                "variation_id" => $this->getProductCfopVariation(),
                "cfop" => $this->getProductCfopCfop()
            ]),
        );

        print_r($data);

        /**
         * 
         *  CONVERTE ARRAY EM JSON
         * 
         */

        $data_json = json_encode($data);



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, false);

        echo $httpCode;
        if ($httpCode == "200") {
            echo "Nota Fiscal Gerada Com Sucesso!!";
        } else if ($httpCode == "404") {
            echo "Ordem Não Encontrada Verifique!";
        }
        echo "<pre>";
        print_r($requisicao);
    }
    /**
     * Get the value of access_token
     */
    public function getAccess_token()
    {
        return $this->access_token;
    }

    /**
     * Set the value of access_token
     *
     * @return  self
     */
    public function setAccess_token($access_token)
    {
        $this->access_token = $access_token;

        return $this;
    }

    /**
     * Get the value of issue_date
     */
    public function getIssue_date()
    {
        return $this->issue_date;
    }

    /**
     * Set the value of issue_date
     *
     * @return  self
     */
    public function setIssue_date($issue_date)
    {
        $this->issue_date = $issue_date;

        return $this;
    }

    /**
     * Get the value of number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     * @return  self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set the value of serie
     *
     * @return  self
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the value of key
     *
     * @return  self
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of xml_danfe
     */
    public function getXml_danfe()
    {
        return $this->xml_danfe;
    }

    /**
     * Set the value of xml_danfe
     *
     * @return  self
     */
    public function setXml_danfe($xml_danfe)
    {
        $this->xml_danfe = $xml_danfe;

        return $this;
    }

    /**
     * Get the value of ProductCfopId
     */
    public function getProductCfopId()
    {
        return $this->ProductCfopId;
    }

    /**
     * Set the value of ProductCfopId
     *
     * @return  self
     */
    public function setProductCfopId($ProductCfopId)
    {
        $this->ProductCfopId = $ProductCfopId;

        return $this;
    }

    /**
     * Get the value of ProductCfopVariation
     */
    public function getProductCfopVariation()
    {
        return $this->ProductCfopVariation;
    }

    /**
     * Set the value of ProductCfopVariation
     *
     * @return  self
     */
    public function setProductCfopVariation($ProductCfopVariation)
    {
        $this->ProductCfopVariation = $ProductCfopVariation;

        return $this;
    }

    /**
     * Get the value of ProductCfopCfop
     */
    public function getProductCfopCfop()
    {
        return $this->ProductCfopCfop;
    }

    /**
     * Set the value of ProductCfopCfop
     *
     * @return  self
     */
    public function setProductCfopCfop($ProductCfopCfop)
    {
        $this->ProductCfopCfop = $ProductCfopCfop;

        return $this;
    }

    /**
     * Get the value of OrderNumber
     */ 
    public function getOrderNumber()
    {
        return $this->OrderNumber;
    }

    /**
     * Set the value of OrderNumber
     *
     * @return  self
     */ 
    public function setOrderNumber($OrderNumber)
    {
        $this->OrderNumber = $OrderNumber;

        return $this;
    }

    function GeraXml($dataEmissao,$numero,$serie,$valor,$chave,$link,$cfop,$productid,$variationId,$cfopProductId){

        $XML = new \DOMDocument('1.0','UTF-8');
        // FORMATA SAIDA DO XML
        $XML->formatOutput = true;
        
        // NO DE DATA DE EMISSAO
        $dataEmiValue = $XML->createTextNode($dataEmissao);
        $DataEmi = $XML->createElement('dEmi');
        $DataEmi->appendChild($dataEmiValue);
        
        // NO DE NUMERO DA NF
        $NumeroNfValue = $XML->createTextNode($numero);
        $NumeroNf = $XML->createElement('numero');
        $NumeroNf->appendChild($NumeroNfValue);

        // NO DE SERIE DA NF
        $SerieNfValue = $XML->createTextNode($serie);
        $SerieNf = $XML->createElement('serie');
        $SerieNf->appendChild($SerieNfValue);
        
        // NO DE VALOR DA NF
        $ValordaNfValue = $XML->createTextNode($valor);
        $ValorNf = $XML->createElement('value');
        $ValorNf->appendChild($ValordaNfValue);
        
        // NO DE CHAVE DA NF
        $ChaveNfValue = $XML->createTextNode($chave);
        $chaveNf = $XML->createElement('key');
        $chaveNf->appendChild($ChaveNfValue);
        
        // NO DE LINK DA NF
        $LinkNfValue = $XML->createTextNode($link);
        $LinkNf = $XML->createElement('link');
        $LinkNf->appendChild($LinkNfValue);
        
        // NO DE CFOP DA NF
        $CFOPNfValue = $XML->createTextNode($cfop);
        $CfopNf = $XML->createElement('cfop');
        $CfopNf->appendChild($CFOPNfValue);
        
        // NO DE ID PRODUTO DA NF
        $ProductIdNfValue = $XML->createTextNode($productid);
        $ProductIdNf = $XML->createElement('productId');
        $ProductIdNf->appendChild($ProductIdNfValue);
        
        // NO DE VARIAÇÂO ID DA NF
        $VariationIdNfValue = $XML->createTextNode($variationId);
        $VariationIdNf = $XML->createElement('variationId');
        $VariationIdNf->appendChild($VariationIdNfValue);
        
        // NO DE CFOP DE PRODUTO  DA NF
        $CfopProdutoIdNfValue = $XML->createTextNode($cfopProductId);
        $CfopProductIdNf = $XML->createElement('cfopProductId');
        $CfopProductIdNf->appendChild($CfopProdutoIdNfValue);
        
        $userNode = $XML->createElement('data');
        $userNode->appendChild($DataEmi);
        $userNode->appendChild($NumeroNf);
        $userNode->appendChild($SerieNf);
        $userNode->appendChild($ValorNf);
        $userNode->appendChild($chaveNf);
        $userNode->appendChild($LinkNf);
        $userNode->appendChild($CfopNf);
        $userNode->appendChild($ProductIdNf);
        $userNode->appendChild($VariationIdNf);
        $userNode->appendChild($CfopProductIdNf);
        $rootNode = $XML->createElement('infNF');
        $rootNode->appendChild($userNode);
        $XML->appendChild($rootNode);
        return $XML->saveXML();
    }
}

echo "<pre>";
//print_r($_REQUEST);

$dataNota = $_REQUEST['Data_Nota'];
$NumeroNota = $_REQUEST['NumeroNota'];
$Serie = $_REQUEST['Serie'];
$value = $_REQUEST['value'];
$chaveNota = $_REQUEST['chaveNota'];
$link = $_REQUEST['link'];
$cfopProd = $_REQUEST['cfopProd'];
$cfopid = $_REQUEST['cfopid'];
$cfop = $_REQUEST['cfop'];
$OrderNumber = $_REQUEST['Order'];
$link.= $chaveNota;
$linkCompleto = $link;

$CreateNfTray = new CreateNfTray($_SESSION['access_token_tray'],$dataNota,$NumeroNota,$Serie,$value,$chaveNota,$linkCompleto,$cfopProd,$cfopid,$cfop,$OrderNumber);
$CreateNfTray->resource();


        