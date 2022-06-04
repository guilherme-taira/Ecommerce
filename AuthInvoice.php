<?php

// autenticação para pegar o ACESS_TOKEN DA api INVOICE
// create by GUILHERME TAIRA  --> 23/11/2021 as 17:01

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URLBASE_AUTH_INVOICE", "https://api.intermediador.yapay.com.br/api/");

class AuthInvoice
{

    function resource()
    {
        return $this->get('v1/authorizations/access_token');
    }

    function get($resource)
    {

        // endpoint url para Requisição VIA CURL

        $endpoint = URLBASE_AUTH_INVOICE . $resource;

        // array com dados para autenticação --> Consumer_key --> consumer_secret --> code
        $dados = array(
            "consumer_key" => "3348b63aa393c20a0fdbc4e1a1dc9096",
            "consumer_secret" => "ebc19c252c9ca6774b983b18588a21c3",
            "code" => "6aaaaeb5406df526b1722a4f1d2abf0521f0b7cf69bef3a2d0bd9f959313541b",
        );

        $credenciais = json_encode($dados);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $credenciais);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        
        $xml = simplexml_load_string($response);
        $json = json_encode($xml,JSON_PRETTY_PRINT | JSON_FORCE_OBJECT);
        $dados = json_decode($json);

        // echo"<table>
        //     <tr><th colspan='3'>Mensagem</th><td>{$dados->message_response->message}</td><tr>
        //     <tr>
        //     <th>access_token</th>
        //     <th>access_token_expiration</th>
        //     <th>refresh_token</th>
        //     <th>refresh_token_expiration</th>
        //     </tr>
        //     <tr>
        //         <td>{$dados->data_response->authorization->access_token}</td>
        //         <td>{$dados->data_response->authorization->access_token_expiration}</td>
        //         <td>{$dados->data_response->authorization->refresh_token}</td>
        //         <td>{$dados->data_response->authorization->access_token}</td>
        //     </tr>
        // </table>";

            $_SESSION['access_token'] = $dados->data_response->authorization->access_token;
            $_SESSION['access_token_expiration'] = $dados->data_response->authorization->access_token_expiration;

            }
}

$auth = new AuthInvoice;
$auth->resource();
