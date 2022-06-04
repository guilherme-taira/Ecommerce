<?php
       // [date_payment] => 1638481557
        // [date_approval] => 1638481625
//12/02/2021 22:45:57
// $timestamp = strtotime("23-04-2020");
echo date('m/d/Y H:i:s', 1638797537);
// autenticação para pegar o ACESS_TOKEN DA api INVOICE
// create by GUILHERME TAIRA  --> 23/11/2021 as 17:01

// METHOD POST

// URLBASE PARA AUTENTICAR
// define("URLBASE_AUTH_INVOICE","https://api.intermediador.yapay.com.br/api/");

// class AuthInvoice{

//     function resource(){
//         return $this->get('v1/authorizations/access_token');
//     }

//     function get($resource){

//         // endpoint url para Requisição VIA CURL

//         $endpoint = URLBASE_AUTH_INVOICE.$resource;
        
//         // array com dados para autenticação --> Consumer_key --> consumer_secret --> code
//         $dados = array(
//             "consumer_key" => "3348b63aa393c20a0fdbc4e1a1dc9096",
//             "consumer_secret" => "ebc19c252c9ca6774b983b18588a21c3",
//             "code" => "6aaaaeb5406df526b1722a4f1d2abf0521f0b7cf69bef3a2d0bd9f959313541b",
//         );

//         $credenciais = json_encode($dados);
//         echo $endpoint;
//         print_r($credenciais);
//         $ch = curl_init();
//         curl_setopt($ch, CURLOPT_URL,$endpoint);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
//         curl_setopt($ch, CURLOPT_POST,1);
//         // curl_setopt($ch, CURLOPT_POSTFIELDS,)
//     }
// }

// $auth = new AuthInvoice;
// $auth->resource();


// Embaleme@123
            // token de e chaves yapay
            // Token da Aplicação (consumer_key)
            // 3348b63aa393c20a0fdbc4e1a1dc9096
            // Chave da Aplicação (consumer_secret)
            // ebc19c252c9ca6774b983b18588a21c3
            // token : 8e1e557f716763a 144193


            // produtividade 
            // 1f523236430c02d28e5e35a598e3463d5c77218ace3affba7b37500e7d99cbef
            // SELECT nome, Departamento,count(cod) as Total FROM `codigo` 
            // INNER JOIN colaborador on codigo.colaborador = colaborador.id 
            // INNER JOIN Departamento on Departamento.id = colaborador.id_departamento
            // where datas like '%2021-11-12%' and Tipo IN('F','NF','NF*','V') group by colaborador ORDER BY Departamento

            // Embaleme@123
            // token de e chaves yapay
            // Token da Aplicação (consumer_key)
            // 3348b63aa393c20a0fdbc4e1a1dc9096
            // Chave da Aplicação (consumer_secret)
            // ebc19c252c9ca6774b983b18588a21c3
            // token : 8e1e557f716763a 144193
