<?php

interface Product{
    public function SaveAllProductRet($CodInterno,$description,$preco_venda,$preco_promocao,$sku,$pesavel,$ativo,$envia_ecommerce,$estoque,$filial,$categoria,$ultima_venda,$ultima_compra,$foto,$fracao_incremento,PDO $pdo2, PDO $pdo);
    public function CountRecordRet(\PDO $pdo2);
}

class SaveRecords implements Product{
    public function SaveAllProductRet($CodInterno,$description,$preco_venda,$preco_promocao,$sku,$pesavel,$ativo,$envia_ecommerce,$estoque,$filial,$categoria,$ultima_venda,$ultima_compra,$foto,$fracao_incremento,PDO $pdo2, PDO $pdo){
        
    }

    public function CountRecordRet(\PDO $pdo) {
        // Monta o statement para contagem dos campos
        $statement = $pdo->query("select count(*) from ret051 WHERE".'"PRODCod"'."");
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        print_r($records);
    }
}

abstract class ProductFactory {
    //public abstract function criarProdutoBanco($CodInterno,$description,$preco_venda,$preco_promocao,$sku,$pesavel,$ativo,$envia_ecommerce,$estoque,$filial,$categoria,$ultima_venda,$ultima_compra,$foto,$fracao_incremento,PDO $pdo2, PDO $pdo):Product;
    public abstract function CountRecourd(\PDO $pdo);
}


class ProductFactoryRecords extends ProductFactory {

    // public function criarProdutoBanco($CodInterno, $description, $preco_venda, $preco_promocao, $sku, $pesavel, $ativo, $envia_ecommerce, $estoque, $filial, $categoria, $ultima_venda, $ultima_compra, $foto, $fracao_incremento, PDO $pdo2, PDO $pdo): SaveRecords
    // {
       
    // }

    public function CountRecourd($pdo): Product{

        $Records = new SaveRecords;
        $Records->CountRecordRet($pdo);
        return $Records;
    }



}

include_once 'BancoRetAPPTRAY.php';

$Produto = new ProductFactoryRecords();
$Produto->CountRecourd($pdo);

