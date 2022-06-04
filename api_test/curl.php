<?php

$ch = curl_init();

$header = [
    'Autorization: Bearer 123',
    'Content-Type: application/json',
];

// $dados = array_reduce($x, function ($a, $b){
//         return $a + $b;
// },0);

$post = [
    'Nome' => 'Guilherme Taira',
    'Empresa' => 'Embaleme',
    'origem' => '13610230',
    'destino' => '13617635'
];

$json = json_encode($post);

curl_setopt($ch,CURLOPT_URL,'http://localhost/dashboard/Dobesone/api_test/api.php?cep='.$post['origem'].'&cep_destino='.$post['destino']);
$fp = fopen("temp_file.txt", "wb");
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'GET');
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
$response = curl_exec($ch);
curl_close($ch);
fwrite($fp,$response);
echo $response;