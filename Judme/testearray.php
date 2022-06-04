<?php

$dados = array
(
    "0" => Array
        (
            "pedido" => 80405,
            "Produto" => 050552,
            "quantidade" => 1.0000,
        ),
    "1" => Array
        (
            "pedido" => 80405,
            "Produto" => '064607',
            "quantidade" => 2.0000,
        ),
    "2" => Array
        (
            "pedido" => 80405,
            "Produto" => '003496',
            "quantidade" => 2.0000,
        ),
    );

echo "<pre>";

$produtoPromocao = array(

    "0" => array(
    "Produto" => '003496',
    "quantidade" => 2),

    "1" => array (
    "Produto" => '064607',
     "quantidade" => 2),
);

$count = count(array_column($produtoPromocao,'Produto'));

$chaves = array_column($produtoPromocao,'Produto');
$quantidades = array_column($produtoPromocao,'quantidade');

$i = 0;
foreach ($chaves as $chave) {
    $key = in_array($chave, array_column($dados,'Produto'));
    if($key == 1){
        foreach ($quantidades as $quantidade) {
            $qtd = in_array($quantidade,array_column($dados,'quantidade'));
             if($qtd == 1){
                 $i++;
             }
        }
    }
}


if(($i - $count) >= $count){
    echo "GANHOU BRINDE";
}


?>