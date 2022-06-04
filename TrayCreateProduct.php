<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// POST CADASTRO PRODUTO TRAY 
// create by GUILHERME TAIRA  --> 13/12/2021 as 11:00

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_CREATE_PRODUTO_TRAY", "https://testeblipchat.commercesuite.com.br/web_api/");


class CreateProduct{
    private $access_token;
    private $ean;
    private $name;
    private $description;
    private $description_small;
    private $price;
    private $cost_price;
    private $promotional_price;
    private $start_promotion;
    private $end_promotion;
    private $marca;
    private $model;
    private $weight;
    private $comprimento;
    private $largura;
    private $altura;
    private $stock;
    private $category_id;
    private $available;
    private $availability;
    private $availability_days;
    private $reference;
    private $additional_button;
    private $related_categories;
    private $release_date;
    private $shortcut;
    private $virtual_product;
    private $picture_source_1;

    function __construct($access_token,$ean,$name,$description,$description_small,$price,$cost_price,$promotional_price,$start_promotion,
    $end_promotion,$marca,$model,$weight,$comprimento,$largura,$altura,$stock,$category_id,$available,$availability,
    $availability_days,$reference,$additional_button,$related_categories,$release_date,$shortcut,$virtual_product,$picture_source_1)
    {
        $this->access_token = $access_token;
        $this->ean = $ean;
        $this->name = $name;
        $this->description = $description;
        $this->description_small = $description_small;
        $this->price = $price;
        $this->cost_price = $cost_price;
        $this->promotional_price = $promotional_price;
        $this->start_promotion = $start_promotion;
        $this->end_promotion = $end_promotion;
        $this->marca = $marca;
        $this->model = $model;
        $this->weight = $weight;
        $this->comprimento = $comprimento;
        $this->largura = $largura;
        $this->altura = $altura;
        $this->stock = $stock;
        $this->category_id = $category_id;
        $this->available = $available;
        $this->availability = $availability;
        $this->availability_days = $availability_days;
        $this->reference = $reference;
        $this->additional_button = $additional_button;
        $this->related_categories = $related_categories; 
        $this->release_date = $release_date;
        $this->shortcut = $shortcut;
        $this->virtual_product = $virtual_product;
        $this->picture_source_1 = $picture_source_1;
    }

    function resource(){
        return $this->get('products?access_token='.$this->getAccess_token());
    }

    function get($resource){
        // ENDPOINT PARA REQUISIÇÃO
        $endpoint = URL_BASE_CREATE_PRODUTO_TRAY.$resource;

        $this->setEan($this->ean);
        $this->setName($this->name);
        $this->setDescription($this->description);
        $this->setDescription_small($this->description_small);
        $this->setPrice($this->price);
        $this->setCost_price($this->cost_price);
        $this->setPromotional_price($this->promotional_price);
        $this->setStart_promotion($this->start_promotion);
        $this->setEnd_promotion($this->end_promotion);
        $this->setMarca($this->marca);
        $this->setModel($this->model);
        $this->setWeight($this->weight);
        $this->setComprimento($this->comprimento);
        $this->setLargura($this->largura);
        $this->setAltura($this->altura);
        $this->setStock($this->stock);
        $this->setCategory_id($this->category_id);
        $this->setAvailable($this->available);
        $this->setAvailability($this->availability);
        $this->setAvailability_days($this->availability_days);
        $this->setReference($this->reference);
        $this->setAdditional_button($this->additional_button);
        $this->setRelated_categories($this->related_categories);
        $this->setShortcut($this->shortcut);
        $this->setVirtual_product($this->virtual_product);
        $this->setPicture_source_1($this->picture_source_1);

        // dados Array
        $data = array(
            "Product" => array(
                "ean" => $this->getEan(),
                "name" => $this->getName(),
                "description" => $this->getDescription(),
                "description_small" => $this->getDescription_small(),
                "price" => $this->getPrice(),
                "cost_price" => $this->getCost_price(),
                "promotional_price" => $this->getPromotional_price(),
                "start_promotion" => $this->getStart_promotion(),
                "end_promotion" => $this->getEnd_promotion(),
                "brand" => $this->getMarca(),
                "model" => $this->getModel(),
                "weight" => $this->getWeight(),
                "length" => $this->getComprimento(),
                "width" => $this->getLargura(),
                "height" => $this->getAltura(),
                "stock" => $this->getStock(),
                "category_id" => $this->getCategory_id(),
                "available" => $this->getAvailable(),
                "availability" => $this->getAvailability(),
                "availability_days" => $this->getAvailability_days(),
                "reference" => $this->getReference(),
                "additional_button" => $this->getAdditional_button(),
                "related_categories" => $this->getRelated_categories(),
                "release_date" => $this->getRelease_date(),
                "shortcut" => $this->getShortcut(),
                "virtual_product" => $this->getVirtual_product(),
                "picture_source_1" => $this->getPicture_source_1(),
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
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POST => 1,
         CURLOPT_POSTFIELDS => $data_json,
         CURLOPT_RETURNTRANSFER =>true,
         CURLOPT_HTTPHEADER => ['Content-Type:application/json'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "<pre>";
        $decode = json_decode($response,false);
        
        echo $httpCode;
        if($httpCode == "201"){
            echo "Produto Cadastrado com Sucesso!";
        }else if($httpCode == "400"){
            echo "Erro ao Cadastraro  Produto Verifique!";
        }

        return $decode;
    }

    /**
     * Get the value of ean
     */ 
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * Set the value of ean
     *
     * @return  self
     */ 
    public function setEan($ean)
    {
        $this->ean = $ean;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of description_small
     */ 
    public function getDescription_small()
    {
        return $this->description_small;
    }

    /**
     * Set the value of description_small
     *
     * @return  self
     */ 
    public function setDescription_small($description_small)
    {
        $this->description_small = $description_small;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of cost_price
     */ 
    public function getCost_price()
    {
        return $this->cost_price;
    }

    /**
     * Set the value of cost_price
     *
     * @return  self
     */ 
    public function setCost_price($cost_price)
    {
        $this->cost_price = $cost_price;

        return $this;
    }

    /**
     * Get the value of promotional_price
     */ 
    public function getPromotional_price()
    {
        return $this->promotional_price;
    }

    /**
     * Set the value of promotional_price
     *
     * @return  self
     */ 
    public function setPromotional_price($promotional_price)
    {
        $this->promotional_price = $promotional_price;

        return $this;
    }

    /**
     * Get the value of start_promotion
     */ 
    public function getStart_promotion()
    {
        return $this->start_promotion;
    }

    /**
     * Set the value of start_promotion
     *
     * @return  self
     */ 
    public function setStart_promotion($start_promotion)
    {
        $this->start_promotion = $start_promotion;

        return $this;
    }

    /**
     * Get the value of end_promotion
     */ 
    public function getEnd_promotion()
    {
        return $this->end_promotion;
    }

    /**
     * Set the value of end_promotion
     *
     * @return  self
     */ 
    public function setEnd_promotion($end_promotion)
    {
        $this->end_promotion = $end_promotion;

        return $this;
    }

    /**
     * Get the value of marca
     */ 
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set the value of marca
     *
     * @return  self
     */ 
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of weight
     */ 
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of weight
     *
     * @return  self
     */ 
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of comprimento
     */ 
    public function getComprimento()
    {
        return $this->comprimento;
    }

    /**
     * Set the value of comprimento
     *
     * @return  self
     */ 
    public function setComprimento($comprimento)
    {
        $this->comprimento = $comprimento;

        return $this;
    }

    /**
     * Get the value of largura
     */ 
    public function getLargura()
    {
        return $this->largura;
    }

    /**
     * Set the value of largura
     *
     * @return  self
     */ 
    public function setLargura($largura)
    {
        $this->largura = $largura;

        return $this;
    }

    /**
     * Get the value of altura
     */ 
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Set the value of altura
     *
     * @return  self
     */ 
    public function setAltura($altura)
    {
        $this->altura = $altura;

        return $this;
    }

    /**
     * Get the value of stock
     */ 
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */ 
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of category_id
     */ 
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Get the value of available
     */ 
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set the value of available
     *
     * @return  self
     */ 
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get the value of availability
     */ 
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set the value of availability
     *
     * @return  self
     */ 
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get the value of availability_days
     */ 
    public function getAvailability_days()
    {
        return $this->availability_days;
    }

    /**
     * Set the value of availability_days
     *
     * @return  self
     */ 
    public function setAvailability_days($availability_days)
    {
        $this->availability_days = $availability_days;

        return $this;
    }

    /**
     * Get the value of reference
     */ 
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the value of reference
     *
     * @return  self
     */ 
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get the value of hot
     */ 
    public function getHot()
    {
        return $this->hot;
    }

    /**
     * Set the value of hot
     *
     * @return  self
     */ 
    public function setHot($hot)
    {
        $this->hot = $hot;

        return $this;
    }

    /**
     * Get the value of release
     */ 
    public function getRelease()
    {
        return $this->release;
    }

    /**
     * Set the value of release
     *
     * @return  self
     */ 
    public function setRelease($release)
    {
        $this->release = $release;

        return $this;
    }

    /**
     * Get the value of additional_button
     */ 
    public function getAdditional_button()
    {
        return $this->additional_button;
    }

    /**
     * Set the value of additional_button
     *
     * @return  self
     */ 
    public function setAdditional_button($additional_button)
    {
        $this->additional_button = $additional_button;

        return $this;
    }

    /**
     * Get the value of related_categories
     */ 
    public function getRelated_categories()
    {
        return $this->related_categories;
    }

    /**
     * Set the value of related_categories
     *
     * @return  self
     */ 
    public function setRelated_categories($related_categories)
    {
        $this->related_categories = $related_categories;

        return $this;
    }

    /**
     * Get the value of release_date
     */ 
    public function getRelease_date()
    {
        return $this->release_date;
    }

    /**
     * Set the value of release_date
     *
     * @return  self
     */ 
    public function setRelease_date($release_date)
    {
        $this->release_date = $release_date;

        return $this;
    }

    /**
     * Get the value of shortcut
     */ 
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * Set the value of shortcut
     *
     * @return  self
     */ 
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    /**
     * Get the value of virtual_product
     */ 
    public function getVirtual_product()
    {
        return $this->virtual_product;
    }

    /**
     * Set the value of virtual_product
     *
     * @return  self
     */ 
    public function setVirtual_product($virtual_product)
    {
        $this->virtual_product = $virtual_product;

        return $this;
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
     * Get the value of picture_source_1
     */ 
    public function getPicture_source_1()
    {
        return $this->picture_source_1;
    }

    /**
     * Set the value of picture_source_1
     *
     * @return  self
     */ 
    public function setPicture_source_1($picture_source_1)
    {
        $this->picture_source_1 = $picture_source_1;

        return $this;
    }
}

$name = $_REQUEST['name'];
$ean = $_REQUEST['ean'];
$valor_unit = $_REQUEST['valor_unit'];
$precoCusto = $_REQUEST['precocusto'];
$precopromocional = $_REQUEST['precopromocional'];
$iniciopromocao = $_REQUEST['iniciopromocao'];
$finalpromocao = $_REQUEST['finalpromocao'];
$marca = $_REQUEST['marca'];
$modelo = $_REQUEST['modelo'];
$peso = $_REQUEST['peso'];
$comprimento = $_REQUEST['comprimento'];
$largura = $_REQUEST['largura'];
$altura = $_REQUEST['altura'];
$estoque = $_REQUEST['estoque'];
$condicao = $_REQUEST['condicao'];
$msgdisponivel = $_REQUEST['msgdisponivel'];
$diadisponivel = $_REQUEST['diadisponivel'];
$referencia = $_REQUEST['referencia'];
$botaoadicional = $_REQUEST['botaoadicional'];
$data_release = $_REQUEST['data_release'];
$virtualProduct = $_REQUEST['virtualProduct'];
$categoria = $_REQUEST['categoria'];
$categoriaRelacionada = $_REQUEST['categoriaRelacionada'];
$url_img_principal = $_REQUEST['url_img_principal'];

$CreateProduct = new CreateProduct($_SESSION['access_token_tray'],$ean,$name,$name,$name,$valor_unit,$precoCusto,$precopromocional,$iniciopromocao,$finalpromocao,$marca,$modelo,$peso,$comprimento,$largura,$altura,$estoque,$categoria,$condicao,$msgdisponivel,$diadisponivel,$referencia,$botaoadicional,$categoriaRelacionada,$data_release,1,$virtualProduct,$url_img_principal);
$ordem = $CreateProduct->resource();
// echo "<pre>";
// print_r($ordem);
// id do produto
echo $ordem->id;


