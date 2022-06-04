<?php
session_start();
// ---------- SESSÂO ABERTA --------------//

// AUTENTICAÇÃO TRAY
// create by GUILHERME TAIRA  --> 10/12/2021 as 09:44

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URL_BASE_AUTH_TRAY_EMBALEME", "https://www.embaleme.com.br/");

class AuthTrayEmbaleme
{

    private $consumer_key;
    private $constumer_secret;
    private $code;
    private $pdo2;

    function __construct($consumer_key, $constumer_secret, $code, PDO $pdo2)
    {
        $this->consumer_key = $consumer_key;
        $this->constumer_secret = $constumer_secret;
        $this->code = $code;
        $this->pdo2 = $pdo2;
    }

    function resource()
    {
        return $this->get('web_api/auth');
    }
    function get($resource)
    {
        // ENDPOINT PARA REQUISICAO
        $endpoint = URL_BASE_AUTH_TRAY_EMBALEME . $resource;

        $body = array(
            'consumer_key' => $this->getConsumer_key(),
            'consumer_secret' => $this->getConstumer_secret(),
            'code' => $this->getCode(),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["follow_redirects: TRUE"]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $requisicao = json_decode($response, false);
        // echo "<pre>";
        // print_r($requisicao);

        // variaveis de sessão
        $_SESSION['access_token_tray'] = $requisicao->access_token;
        $_SESSION['refresh_token_tray'] = $requisicao->refresh_token;
        $_SESSION['date_expiration_access_token_tray'] = $requisicao->date_expiration_access_token;
        $_SESSION['date_expiration_refresh_token_tray'] = $requisicao->date_expiration_refresh_token;
        $_SESSION['store_id'] = $requisicao->store_id;

        $data = new DateTime();
        $this->UpdateAccessToken($_SESSION['access_token_tray'], 'Bearer', $_SESSION['date_expiration_access_token_tray'], $_SESSION['refresh_token_tray'], $_SESSION['store_id'], $this->getPdo2(), $data);
        // if($httpCode == "200"){
        //     echo "Token Gerado Com Sucesso!!";
        // }else if($httpCode == "404"){
        //     echo "Ordem Não Encontrada Verifique!";
        // }
    }
    /**
     * Get the value of consumer_key
     */
    public function getConsumer_key()
    {
        return $this->consumer_key;
    }

    /**
     * Set the value of consumer_key
     *
     * @return  self
     */
    public function setConsumer_key($consumer_key)
    {
        $this->consumer_key = $consumer_key;

        return $this;
    }

    /**
     * Get the value of constumer_secret
     */
    public function getConstumer_secret()
    {
        return $this->constumer_secret;
    }

    /**
     * Set the value of constumer_secret
     *
     * @return  self
     */
    public function setConstumer_secret($constumer_secret)
    {
        $this->constumer_secret = $constumer_secret;

        return $this;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function saveAccessToken($accessToken, $type, $user_id, $DataModify, $refreshToken, PDO $pdo)
    {
        // VARIAVEL DE SESSÂO VINDO DA TRAY
        try {
            $pdo->beginTransaction();
            $sql = "INSERT INTO token (access_token,type,user_id,refresh_token,DataModify)";
            $sql_values = " VALUES (:access_token, :type, :user_id, :refresh_token,:DataModify)";
            $statement = $pdo->prepare($sql .= $sql_values);
            $statement->bindValue('access_token', $accessToken, PDO::PARAM_STR);
            $statement->bindValue('type', $type, PDO::PARAM_STR);
            $statement->bindValue('user_id', $user_id, PDO::PARAM_STR);
            $statement->bindValue('refresh_token', $refreshToken, PDO::PARAM_STR);
            $statement->bindValue('DataModify', $DataModify, PDO::PARAM_STR);
            $statement->execute();
            $pdo->commit();
        } catch (\PDOException $e) {
            echo $e->getCode();
            echo $e->getMessage();
            $pdo->rollback();
        }
    }

    public function UpdateAccessToken($accessToken, $type, $DataModify, $refreshToken, $user_id, PDO $pdo, DateTime $dataAtual)
    {
        // VERIFICA O USER_ID
        $stmt = $pdo->query("SELECT * FROM token where user_id = '$user_id'");
        $user = $stmt->fetch();
        // ## CONVERTE A DATA DO BANCO PADRÃO DATETIME ##
        $dataBanco = DateTime::createFromFormat('Y-m-d H:i:s', $user['DataModify']);
        $CompareDate = $dataBanco->format('Y-m-d H:i:s');
    
        $dataAtual = new DateTime();
        $DateCurrent = $dataAtual->format('Y-m-d H:i:s');


        if (isset($user['user_id'])) {
            // VARIAVEL DE SESSÂO VINDO DA TRAY
            if ($DateCurrent > $CompareDate) {
                try {
                    $pdo->beginTransaction();
                    $sql = "UPDATE token set access_token = :access_token, refresh_token = :refresh_token , DataModify = :DataModify where user_id = :user_id";
                    $statement = $pdo->prepare($sql);
                    $statement->bindValue('access_token', $accessToken, PDO::PARAM_STR);
                    $statement->bindValue('refresh_token', $refreshToken, PDO::PARAM_STR);
                    $statement->bindValue('DataModify', $DataModify, PDO::PARAM_STR);
                    $statement->bindValue('user_id', $user_id, PDO::PARAM_STR);
                    $statement->execute();
                    $pdo->commit();
                } catch (\PDOException $e) {
                    echo $e->getCode();
                    echo $e->getMessage();
                    $pdo->rollback();
                }
            }
        } else {

            $this->saveAccessToken($accessToken, $type, $user_id, $DataModify, $refreshToken, $pdo);
        }
    }

    /**
     * Get the value of pdo2
     */
    public function getPdo2()
    {
        return $this->pdo2;
    }
}
include_once '../conexao_pdoDBRET.php';

$AuthTray = new AuthTrayEmbaleme('9dec7ed695dbf7eac41b56c5a3fd122a8f4ef5ea40a733b12e54ff062f76c6eb', 'c6b66367fc609afa2968275dff7971258b0365eceaec8b380b06fe37c9968e25', '1641c70247b460e4247abd5aa38290465a364dd370b9ed627a9800f507a38ba1', $pdo2);
$AuthTray->resource();


// echo "<label>access_token_tray : </label>";
// echo "<input type='text' value='{$Auth['access_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>refresh_token_tray : </label>";
// echo "<input type='text' value='{$Auth['refresh_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>date_expiration_access_token_tray : </label>";
// echo "<input type='text' value='{$Auth['date_expiration_access_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>date_expiration_refresh_token_tray : </label>";
// echo "<input type='text' value='{$Auth['date_expiration_refresh_token_tray']}' size='100' name='' id=''><br>";

// echo "<label>access_token : </label>";
// echo "<input type='text' value='{$Auth['access_token']}' size='100' name='' id=''><br>";

// echo "<label>access_token_expiration : </label>";
// echo "<input type='text' value='{$Auth['access_token_expiration']}' size='100' name='' id=''><br>";
// code do Aplicativo Embaleme *** ->>>> e140024829b4ca3b284e1646863ec211466ec75e5c48a4a4d0f104fdc25d8805
