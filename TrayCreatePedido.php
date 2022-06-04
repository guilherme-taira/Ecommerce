<?php
include_once 'TrayAuth.php';
// ---------- SESSÂO ABERTA --------------//

// PUT ATUALIZA PEDIDO TRAY 
// create by GUILHERME TAIRA  --> 13/12/2021 as 11:00

// METHOD PUT

// URLBASE PARA AUTENTICAR
define("URL_BASE_CREATE_PEDIDOS_TRAY", "https://testeblipchat.commercesuite.com.br/web_api/");

class CreatePedidoTray {
    
    private $acess_token;
    private $session_id;
    private $point_sale;
    private $shipment;
    private $shipment_value;
    private $payment_form;
    private $Customer;
    private $type;
    private $name;
    private $cpf;
    private $email;
    private $rg;
    private $gender;
    private $phone;
    private $address;
    private $zip_code;
    private $number;
    private $complement;
    private $neighborhood;
    private $city;
    private $state;
    private $country;
    private $type2;
    private $ProductsSold;
    private $product_id;
    private $variant_id;
    private $price;
    private $original_price;
    private $quantity;
    private $marketplace_name;
    private $marketplace_seller_name;
    private $marketplace_seller_id;
    private $marketplace_document;
    private $payment_responsible_document;
    private $marketplace_order_id;
    private $marketplace_shipping_id;
    private $marketplace_shipping_type;
    private $marketplace_internal_status;
    

    function __construct($acess_token,$point_sale,$session_id,
                         $shipment,$shipment_value,$payment_form,
                         $type,$name,$cpf,$email,$rg,
                         $gender,$phone,$address,
                         $zip_code,$number,$complement,$neighborhood,
                         $city,$state,$country,$type2,
                         $product_id,$variant_id,$price,$original_price,
                         $quantity,$marketplace_name,$marketplace_seller_name,
                         $marketplace_seller_id,$marketplace_document,
                         $payment_responsible_document,$marketplace_order_id
                         ,$marketplace_shipping_id,$marketplace_shipping_type
                         ,$marketplace_internal_status)
    {
        $this->acess_token = $acess_token;
        $this->point_sale = $point_sale;
        $this->session_id = $session_id;
        $this->shipment = $shipment;
        $this->shipment_value = $shipment_value;
        $this->payment_form = $payment_form;
        $this->type = $type;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->rg = $rg;
        $this->gender =$gender;
        $this->phone = $phone;
        $this->address = $address;
        $this->zip_code = $zip_code;
        $this->number = $number;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
        $this->type2 = $type2;
        $this->product_id = $product_id;
        $this->variant_id =$variant_id;
        $this->price = $price;
        $this->original_price = $original_price;
        $this->quantity = $quantity;
        $this->marketplace_name = $marketplace_name;
        $this->marketplace_seller_name = $marketplace_seller_name;
        $this->marketplace_seller_id = $marketplace_seller_id;
        $this->marketplace_document = $marketplace_document;
        $this->payment_responsible_document = $payment_responsible_document;
        $this->marketplace_order_id = $marketplace_order_id;
        $this->marketplace_shipping_id = $marketplace_shipping_id;
        $this->marketplace_shipping_type = $marketplace_shipping_type;
        $this->marketplace_internal_status = $marketplace_internal_status;
    }

    function resource(){
        $this->setAcess_token($this->acess_token);
        $this->setPoint_sale($this->point_sale);
        $this->setSession_id($this->session_id);
        $this->setShipment($this->shipment);
        $this->setShipment_value($this->shipment_value);
        $this->setPayment_form($this->payment_form);
        $this->setType($this->type);
        $this->setName($this->name);
        $this->setCpf($this->cpf);
        $this->setEmail($this->email);
        $this->setRg($this->rg);
        $this->setGender($this->gender);
        $this->setPhone($this->phone);
        $this->setAddress($this->address);
        $this->setZip_code($this->zip_code);
        $this->setNumber($this->number);
        $this->setComplement($this->complement);
        $this->setNeighborhood($this->neighborhood);
        $this->setCity($this->city);
        $this->setState($this->state);
        $this->setCountry($this->country);
        $this->setType2($this->type2);
        $this->setProduct_id($this->product_id);
        $this->setVariant_id($this->variant_id);
        $this->setPrice($this->price);
        $this->setOriginal_price($this->original_price);
        $this->setQuantity($this->quantity);
        $this->setMarketplace_name($this->marketplace_name);
        $this->setMarketplace_seller_name($this->marketplace_seller_name);
        $this->setMarketplace_seller_id($this->marketplace_seller_id);
        $this->setMarketplace_document($this->marketplace_document);
        $this->setPayment_responsible_document($this->payment_responsible_document);
        $this->setMarketplace_order_id($this->marketplace_order_id);
        $this->setMarketplace_shipping_id($this->marketplace_shipping_id);
        $this->setMarketplace_shipping_type($this->marketplace_shipping_type);
        $this->setMarketplace_internal_status($this->marketplace_internal_status);

        return $this->get("orders?access_token=".$this->getAcess_token());
    }

    function get($resource){
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_CREATE_PEDIDOS_TRAY.$resource;
        echo $endpoint;
        // array pedido

        $data = array(
         "Order" => ['point_sale' => $this->getPoint_sale(),
                     'session_id' => "0BBB15A404B6BA1",
                     'shipment'   => $this->getShipment(),
                     'shipment_value' => $this->getShipment_value(),
                     'payment_form' => $this->getPayment_form(),
                     'Customer' => [
                         'type' => $this->getType(),
                         'name' =>  $this->getName(),
                         'cpf'  => $this->getCpf(),
                         'email'=> $this->getEmail(),
                         'rg' =>  $this->getRg(),
                         'gender' => $this->getGender(),
                         'phone'  =>  $this->getPhone(),
                         'CustomerAddress' => [[
                             'address' => $this->getAddress(),
                             'zip_code' => $this->getZip_code(),
                             'number' =>  $this->getNumber(),
                             'complement' => $this->getComplement(),
                             'neighborhood' =>  $this->getNeighborhood(),
                             'city' => $this->getCity(),
                             "state" => $this->getState(),
                             "country" => $this->getCountry(),
                             "type" => $this->getType2(), 
                         ]],
                        ],
                        'ProductsSold' => [[
                            "product_id" => $this->getProduct_id(),
                            "variant_id" => '',
                            "price" => $this->getPrice(), 
                            "original_price" => $this->getOriginal_price(),
                            "quantity" => $this->getQuantity()
                        ]],
                        'MarketplaceOrder' => [[
                            "marketplace_name" => $this->getMarketplace_name(),
                            "marketplace_seller_name" => $this->getMarketplace_name(),
                            "marketplace_seller_id" => $this->getMarketplace_seller_id(),
                            "marketplace_document" => $this->getMarketplace_document(),
                            "payment_responsible_document" => $this->getPayment_responsible_document(),
                            "marketplace_order_id" => $this->getMarketplace_order_id(),
                            "marketplace_shipping_id" => $this->getMarketplace_shipping_id(),
                            "marketplace_shipping_type" => $this->getMarketplace_shipping_type(),
                            "marketplace_internal_status" => $this->getMarketplace_internal_status()
                        ]]
                    ],
        );
        echo "<pre>";
        //print_r($data);

        $data_json = json_encode($data, JSON_PRETTY_PRINT);
        print_r($data_json);
    
        //curl requisição
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

        echo $httpCode;
        if($httpCode == "201"){
            echo "Ordem Cadastrada com Sucesso!";
        }else if($httpCode == "400"){
            echo "Ordem Não Encontrada Verifique!";
        }

    }

    /**
     * Get the value of acess_token
     */ 
    public function getAcess_token()
    {
        return $this->acess_token;
    }

    /**
     * Set the value of acess_token
     *
     * @return  self
     */ 
    public function setAcess_token($acess_token)
    {
        $this->acess_token = $acess_token;

        return $this;
    }

    /**
     * Get the value of session_id
     */ 
    public function getSession_id()
    {
        return $this->session_id;
    }

    /**
     * Set the value of session_id
     *
     * @return  self
     */ 
    public function setSession_id($session_id)
    {
        $this->session_id = $session_id;

        return $this;
    }

    /**
     * Get the value of point_sale
     */ 
    public function getPoint_sale()
    {
        return $this->point_sale;
    }

    /**
     * Set the value of point_sale
     *
     * @return  self
     */ 
    public function setPoint_sale($point_sale)
    {
        $this->point_sale = $point_sale;

        return $this;
    }

    /**
     * Get the value of shipment
     */ 
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * Set the value of shipment
     *
     * @return  self
     */ 
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * Get the value of shipment_value
     */ 
    public function getShipment_value()
    {
        return $this->shipment_value;
    }

    /**
     * Set the value of shipment_value
     *
     * @return  self
     */ 
    public function setShipment_value($shipment_value)
    {
        $this->shipment_value = $shipment_value;

        return $this;
    }

    /**
     * Get the value of payment_form
     */ 
    public function getPayment_form()
    {
        return $this->payment_form;
    }

    /**
     * Set the value of payment_form
     *
     * @return  self
     */ 
    public function setPayment_form($payment_form)
    {
        $this->payment_form = $payment_form;

        return $this;
    }

    /**
     * Get the value of Customer
     */ 
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * Set the value of Customer
     *
     * @return  self
     */ 
    public function setCustomer($Customer)
    {
        $this->Customer = $Customer;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

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
     * Get the value of cpf
     */ 
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set the value of cpf
     *
     * @return  self
     */ 
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of rg
     */ 
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * Set the value of rg
     *
     * @return  self
     */ 
    public function setRg($rg)
    {
        $this->rg = $rg;

        return $this;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */ 
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of CustomerAddress
     */ 
    public function getCustomerAddress()
    {
        return $this->CustomerAddress;
    }

    /**
     * Set the value of CustomerAddress
     *
     * @return  self
     */ 
    public function setCustomerAddress($CustomerAddress)
    {
        $this->CustomerAddress = $CustomerAddress;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of zip_code
     */ 
    public function getZip_code()
    {
        return $this->zip_code;
    }

    /**
     * Set the value of zip_code
     *
     * @return  self
     */ 
    public function setZip_code($zip_code)
    {
        $this->zip_code = $zip_code;

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
     * Get the value of complement
     */ 
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set the value of complement
     *
     * @return  self
     */ 
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get the value of neighborhood
     */ 
    public function getNeighborhood()
    {
        return $this->neighborhood;
    }

    /**
     * Set the value of neighborhood
     *
     * @return  self
     */ 
    public function setNeighborhood($neighborhood)
    {
        $this->neighborhood = $neighborhood;

        return $this;
    }

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of state
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */ 
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the value of country
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the value of country
     *
     * @return  self
     */ 
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get the value of type2
     */ 
    public function getType2()
    {
        return $this->type2;
    }

    /**
     * Set the value of type2
     *
     * @return  self
     */ 
    public function setType2($type2)
    {
        $this->type2 = $type2;

        return $this;
    }

    /**
     * Get the value of ProductsSold
     */ 
    public function getProductsSold()
    {
        return $this->ProductsSold;
    }

    /**
     * Set the value of ProductsSold
     *
     * @return  self
     */ 
    public function setProductsSold($ProductsSold)
    {
        $this->ProductsSold = $ProductsSold;

        return $this;
    }

    /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of variant_id
     */ 
    public function getVariant_id()
    {
        return $this->variant_id;
    }

    /**
     * Set the value of variant_id
     *
     * @return  self
     */ 
    public function setVariant_id($variant_id)
    {
        $this->variant_id = $variant_id;

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
     * Get the value of original_price
     */ 
    public function getOriginal_price()
    {
        return $this->original_price;
    }

    /**
     * Set the value of original_price
     *
     * @return  self
     */ 
    public function setOriginal_price($original_price)
    {
        $this->original_price = $original_price;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of marketplace_name
     */ 
    public function getMarketplace_name()
    {
        return $this->marketplace_name;
    }

    /**
     * Set the value of marketplace_name
     *
     * @return  self
     */ 
    public function setMarketplace_name($marketplace_name)
    {
        $this->marketplace_name = $marketplace_name;

        return $this;
    }

    /**
     * Get the value of marketplace_seller_name
     */ 
    public function getMarketplace_seller_name()
    {
        return $this->marketplace_seller_name;
    }

    /**
     * Set the value of marketplace_seller_name
     *
     * @return  self
     */ 
    public function setMarketplace_seller_name($marketplace_seller_name)
    {
        $this->marketplace_seller_name = $marketplace_seller_name;

        return $this;
    }

    /**
     * Get the value of marketplace_seller_id
     */ 
    public function getMarketplace_seller_id()
    {
        return $this->marketplace_seller_id;
    }

    /**
     * Set the value of marketplace_seller_id
     *
     * @return  self
     */ 
    public function setMarketplace_seller_id($marketplace_seller_id)
    {
        $this->marketplace_seller_id = $marketplace_seller_id;

        return $this;
    }

    /**
     * Get the value of marketplace_document
     */ 
    public function getMarketplace_document()
    {
        return $this->marketplace_document;
    }

    /**
     * Set the value of marketplace_document
     *
     * @return  self
     */ 
    public function setMarketplace_document($marketplace_document)
    {
        $this->marketplace_document = $marketplace_document;

        return $this;
    }

    /**
     * Get the value of payment_responsible_document
     */ 
    public function getPayment_responsible_document()
    {
        return $this->payment_responsible_document;
    }

    /**
     * Set the value of payment_responsible_document
     *
     * @return  self
     */ 
    public function setPayment_responsible_document($payment_responsible_document)
    {
        $this->payment_responsible_document = $payment_responsible_document;

        return $this;
    }

    /**
     * Get the value of marketplace_order_id
     */ 
    public function getMarketplace_order_id()
    {
        return $this->marketplace_order_id;
    }

    /**
     * Set the value of marketplace_order_id
     *
     * @return  self
     */ 
    public function setMarketplace_order_id($marketplace_order_id)
    {
        $this->marketplace_order_id = $marketplace_order_id;

        return $this;
    }

    /**
     * Get the value of marketplace_shipping_id
     */ 
    public function getMarketplace_shipping_id()
    {
        return $this->marketplace_shipping_id;
    }

    /**
     * Set the value of marketplace_shipping_id
     *
     * @return  self
     */ 
    public function setMarketplace_shipping_id($marketplace_shipping_id)
    {
        $this->marketplace_shipping_id = $marketplace_shipping_id;

        return $this;
    }

    /**
     * Get the value of marketplace_shipping_type
     */ 
    public function getMarketplace_shipping_type()
    {
        return $this->marketplace_shipping_type;
    }

    /**
     * Set the value of marketplace_shipping_type
     *
     * @return  self
     */ 
    public function setMarketplace_shipping_type($marketplace_shipping_type)
    {
        $this->marketplace_shipping_type = $marketplace_shipping_type;

        return $this;
    }

    /**
     * Get the value of marketplace_internal_status
     */ 
    public function getMarketplace_internal_status()
    {
        return $this->marketplace_internal_status;
    }

    /**
     * Set the value of marketplace_internal_status
     *
     * @return  self
     */ 
    public function setMarketplace_internal_status($marketplace_internal_status)
    {
        $this->marketplace_internal_status = $marketplace_internal_status;

        return $this;
    }
}

echo "<pre>";
print_r($_REQUEST);
$localVenda = $_REQUEST['localVenda'];
$tipofrete = $_REQUEST['tipofrete'];
$valorfrete = $_REQUEST['valorfrete'];
$formpagamento = $_REQUEST['formpagamento'];
$tipocliente = $_REQUEST['tipocliente'];
$nomecliente = $_REQUEST['nomecliente'];
$cnpj = $_REQUEST['cnpj'];
$email = $_REQUEST['email'];
$rg = $_REQUEST['rg'];
$genero = $_REQUEST['genero'];
$telefone = $_REQUEST['telefone'];
$endereco = $_REQUEST['endereco'];
$cep = $_REQUEST['cep'];
$numero = $_REQUEST['numero'];
$complemento = $_REQUEST['complemento'];
$bairro = $_REQUEST['bairro'];
$cidade = $_REQUEST['cidade'];
$estado = $_REQUEST['estado'];
$pais = $_REQUEST['pais'];
$tipoentrega = $_REQUEST['tipoentrega'];
$produto = $_REQUEST['produto'];
$quantidade = $_REQUEST['quantidade'];
$localmarketplace = $_REQUEST['localmarketplace'];
$marketplace_seller_name = $_REQUEST['marketplace_seller_name'];
$marketplace_seller_id = $_REQUEST['marketplace_seller_id'];
$marketplace_document = $_REQUEST['marketplace_document'];
$payment_responsible_document = $_REQUEST['payment_responsible_document'];
$marketplace_order_id = $_REQUEST['marketplace_order_id'];
$marketplace_shipping_id = $_REQUEST['marketplace_shipping_id'];
$marketplace_shipping_type = $_REQUEST['marketplace_shipping_type'];
$marketplace_internal_status = $_REQUEST['marketplace_internal_status'];
$url_img_principal = $_REQUEST['url_img_principal'];

/***
 * // CLASSE PARA PEGAR OS DADOS DO PRODUTO
 * 
 * * */
 include_once 'TrayProdutoGet.php';
 $GetProdutos = new GetProdutos;
 $produto_id = $GetProdutos->resource($_SESSION['access_token_tray'],$produto);
 /***
  *  // VARIAVEIS DA API DE PRODUTO 
  *
  ****/
$preco = $produto_id->Product->price;
$preco_original = $produto_id->Product->cost_price;

 /***
  *  // VARIAVEIS DA API DE PRODUTO 
  *
  ****/
$CreatePedidoTray = new CreatePedidoTray($_SESSION['access_token_tray'],$localVenda,'1',$tipofrete,$valorfrete,$formpagamento,$tipocliente,$nomecliente,$cnpj,$email,$rg,$genero,$numero,$endereco,$cep,$numero,$complemento,$bairro,$cidade,$estado,$pais,$tipoentrega,$produto,'',$preco,$preco_original,$quantidade,$localmarketplace,$marketplace_seller_name,$marketplace_seller_id, $marketplace_document,$payment_responsible_document,'357129813','35712986','me2','shipping');
$CreatePedidoTray->resource();