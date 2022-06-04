<?php

include_once 'BancoRet.php';

// $sql = "SELECT * from ret501 WHERE ".'"CIDNome"'." LIKE '%$cidade' AND ".'"CIDUF"'." = '$UF'";

$sql = "SELECT FIRST 1 * from ret305 WHERE ORCANDROID = '177133'";

$statement = $pdo->query($sql);
$orcamentos = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
foreach ($orcamentos as $orcamento) {
    $obj = (object) $orcamento;
    print_r($obj);
    print_r($obj->ORCNUM);

    $sql = "SELECT FIRST 1 A04, Q07, Q08, Q16, recnumeronf, recvlr, RECpago, ORCNUM from ret092,ret150 WHERE ORCNUM = '$obj->ORCNUM'";
    $statement = $pdo->query($sql);
    $Pedido = $statement->fetchAll(PDO::FETCH_ASSOC);
    print_r($Pedido);
}

