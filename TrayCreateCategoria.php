<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// POST CREATE CATEGORIA TRAY 
// create by GUILHERME TAIRA  --> 14/12/2021 as 17:48

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_CREATE_CATEGORIA_TRAY", "https://testeblipchat.commercesuite.com.br/web_api/");

class CreateCategoriaTray{
    private $access_token;
    private $name;
    private $descriptionCategory;
    private $slug;
    private $order;
    private $title;
    private $small_description;
    private $has_acceptance_term;
    private $acceptance_term;
    private $Metatag;
    private $keywords;
    private $description;
    private $property;
    
    function __construct($access_token,$name,$descriptionCategory,$slug,$order,$title,$small_description,$has_acceptance_term,$acceptance_term,$Metatag,$keywords,$description,$property){
        $this->access_token = $access_token;
        $this->name = $name;
        $this->descriptionCategory = $descriptionCategory;
        $this->slug = $slug;
        $this->order = $order;
        $this->title = $title;
        $this->small_description = $small_description;
        $this->has_acceptance_term = $has_acceptance_term;
        $this->acceptance_term = $acceptance_term;
        $this->Metatag = $Metatag;
        $this->keywords = $keywords;
        $this->description = $description;
        $this->property = $property;
    }

    function resource(){
        return $this->get('categories/'.'?access_token='.$this->getAccess_token());
    }

    function get($resource){

        

        // ENDPOINT PARA REQUISIÇÂO
        $endpoint = URL_BASE_CREATE_CATEGORIA_TRAY.$resource;

        $data = array(
            "Category" => array(
              "name" => $this->getName(),
              "description" => $this->getDescriptionCategory(),
              "slug" => $this->getSlug(),
              "order" => $this->getOrder(),
              "title" => $this->getTitle(),
              "small_description" => $this->getSmall_description(),
              "has_acceptance_term" => $this->getHas_acceptance_term(),
              "acceptance_term" => $this->getAcceptance_term(),
              "metatag" => array(
                  "keywords" => $this->getKeywords(),
                  "description" => $this->getDescription(),
              ),
              "property" => array([
                  "{".$this->getProperty().""
              ])
            ),
        );

        $data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "<pre>";
        $decode = json_decode($response,false);
        print_r($decode);

        //echo $httpCode;

        // if($httpCode == "201"){
        //     $_SESSION["msg_success"] = "<div class='alert alert-success'> Categoria {$this->getName()} Cadastrado com Sucesso! </div>";
        //     header('Location: TelaListaCategoriaTray.php');
        // }else if($httpCode == "400"){
        //     $_SESSION["msg_error"] = "<div class='alert alert-danger'>Erro ao Cadastrar Categoria</div>";
        //     header(sprintf('location: %s', $_SERVER['HTTP_REFERER']));
        // }

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
     * Get the value of slug
     */ 
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of small_description
     */ 
    public function getSmall_description()
    {
        return $this->small_description;
    }

    /**
     * Set the value of small_description
     *
     * @return  self
     */ 
    public function setSmall_description($small_description)
    {
        $this->small_description = $small_description;

        return $this;
    }

    /**
     * Get the value of has_acceptance_term
     */ 
    public function getHas_acceptance_term()
    {
        return $this->has_acceptance_term;
    }

    /**
     * Set the value of has_acceptance_term
     *
     * @return  self
     */ 
    public function setHas_acceptance_term($has_acceptance_term)
    {
        $this->has_acceptance_term = $has_acceptance_term;

        return $this;
    }

    /**
     * Get the value of acceptance_term
     */ 
    public function getAcceptance_term()
    {
        return $this->acceptance_term;
    }

    /**
     * Set the value of acceptance_term
     *
     * @return  self
     */ 
    public function setAcceptance_term($acceptance_term)
    {
        $this->acceptance_term = $acceptance_term;

        return $this;
    }

    /**
     * Get the value of Metatag
     */ 
    public function getMetatag()
    {
        return $this->Metatag;
    }

    /**
     * Set the value of Metatag
     *
     * @return  self
     */ 
    public function setMetatag($Metatag)
    {
        $this->Metatag = $Metatag;

        return $this;
    }

    /**
     * Get the value of keywords
     */ 
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the value of keywords
     *
     * @return  self
     */ 
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

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
     * Get the value of property
     */ 
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set the value of property
     *
     * @return  self
     */ 
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get the value of descriptionCategory
     */ 
    public function getDescriptionCategory()
    {
        return $this->descriptionCategory;
    }

    /**
     * Set the value of descriptionCategory
     *
     * @return  self
     */ 
    public function setDescriptionCategory($descriptionCategory)
    {
        $this->descriptionCategory = $descriptionCategory;

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
}
echo "<pre>";
print_r($_REQUEST);
 $nome = $_REQUEST['nome'];
 $descricao = $_REQUEST['descricao'];   
 $metadescription = $_REQUEST['metadescription'];
 $palavraChave = $_REQUEST['propriedades'];
 $property = $_REQUEST['propriedades'];



$CreateCategoriaTray = new CreateCategoriaTray($_SESSION['access_token_tray'],$nome,$descricao,slugForm($nome),'2',$nome,$metadescription,1,'Eu Aceito o termo da categoria',$metadescription,$palavraChave,'',$property);
$CreateCategoriaTray->resource();

function slugForm($string) {
    $nome = $string;
    $regex = "/\ /";
    $replecement = "-";
    return preg_replace($regex,$replecement,$nome);
}