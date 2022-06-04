<?php
include_once 'conexao_pdo.php';
// ---------- SESSÂO ABERTA --------------//

//  ATUALIZA PRODUTOS NO BANCO NO MULTILOJA SHOPEE 
// create by GUILHERME TAIRA  --> 19/01/2022 as 08:35

// METHOD GET

// // URLBASE PARA AUTENTICAR
// define("URL_BASE_GET_BLING_PRODUTO", "https://bling.com.br/");


// interface Bling{
//     public function resource();
//     public function get($resource);
// }


// class MercadolivreImplements implements Bling {

//     private $apikey;

//     public function __construct($apikey)
//     {
//         $this->apikey = $apikey;
//     }
    
//     public function resource(){

//         $dataInicial = new DateTime();
//         $dataFinal = new DateTime();
//         $dataInicial->modify('-2 days'); // decrementa 2 dias da data atual
//         $dataFinal->modify('+2 days'); // acresenta 2 dias da data atual
   
//         return $this->get('Api/v2/produtos/json/'.'?apikey=' . $this->getApikey()."&loja=203874743&filters=dataInclusaoLoja[{$dataInicial->format('d/m/Y')} TO {$dataFinal->format('d/m/Y')}]");
//     }

//     public function get($resource){

//         // ENDPOINT PARA REQUISICAO
//         $endpoint = URL_BASE_GET_BLING_PRODUTO.$resource;
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL, $endpoint);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json','Accept:application/json']);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'GET');
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        
//         $response = curl_exec($ch);
//         curl_close($ch);
//         return $response;
//     }

//     /**
//      * Get the value of apikey
//      */ 
//     public function getApikey()
//     {
//         return $this->apikey;
//     }

//     /**
//      * Set the value of apikey
//      *
//      * @return  self
//      */ 
//     public function setApikey($apikey)
//     {
//         $this->apikey = $apikey;

//         return $this;
//     }
// }

abstract class FactoryShopee {
    public abstract function CadastraBancoMercadoLivre($apikey, \PDO $pdo);
}
 
class AnaliseDeDadosFactory extends FactoryShopee{

    public function CadastraBancoMercadoLivre($apikey,\PDO $pdo){

        $MercadolivreImplements = new MercadolivreImplements($apikey);
        $dadosProduto =  $MercadolivreImplements->resource();

        $json = json_decode($dadosProduto,false); 
          
        foreach ($json->retorno->produtos as $produto) {
            
            // echo "<pre>";
            // print_r($produto->produto->produtoLoja);
            // echo "</pre>";

            $referencia = $produto->produto->codigo;
            $MercadoLivreID = isset($produto->produto->produtoLoja->idProdutoLoja)? $produto->produto->produtoLoja->idProdutoLoja : "";
            
            if(!empty($MercadoLivreID)){
                 // GRAVA NO BANCO SE TIVER VAZIO O ID MERCADO LIVRE
                 try {
                    $pdo->beginTransaction();
                    $statement = $pdo->prepare("UPDATE TrayProdutos SET MercadoLivreID = :MercadoLivreID WHERE referencia = :referencia");
                    $statement->bindValue(':MercadoLivreID',$MercadoLivreID, PDO::PARAM_STR);
                    $statement->bindValue(':referencia', $referencia, PDO::PARAM_STR);
                    $statement->execute();
                    $pdo->commit();
                 } catch (\PDOException $e) {
                     $pdo->rollBack();
                     echo $e->getMessage();
                     echo $e->getCode();
                 }
            }else{
                // GRAVA NO BANCO SE TEVE ALTERACAO
                echo "
                <tbody>
                <div class='card mt-2 alert alert-danger'>
                <ul class='list-group list-group-flush'>
                <li class='list-group-item'><strong>Referencia: {$produto->produto->codigo}  ->>>>> {$produto->produto->descricao} - Pedido Já Cadastrado!</strong></li>
                </ul>
                </div>  
                ";
            }
        }
       
    }

}

// 034099 = MLB2613589541
// 063712 = MLB2613576539, 
// 018535 = MLB2613558739


$produtos = new AnaliseDeDadosFactory();
$produtos->CadastraBancoMercadoLivre('a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277',$pdo2);
