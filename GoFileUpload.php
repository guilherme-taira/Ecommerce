<?php

define("URLBASE", "https://store3.gofile.io");

class UploadFile
{

    private $token;
    private $folderid;

    public function __construct($token, $folderid)
    {
        $this->token = $token;
        $this->folderid = $folderid;
    }

    function Upload()
    {
        return $this->get('/uploadFile');
    }

    function get($resource)
    {
        $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
        //loop para ler as imagens
  

        $endpoint = URLBASE.$resource;
        $ch = curl_init();

        for ($controle = 0; $controle < count($arquivo['name']); $controle++){    
        curl_setopt_array($ch,
        [   
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "file" => curl_file_create(
                        $arquivo['tmp_name'][$controle],
                        $arquivo['type'][$controle],
                        $arquivo['name'][$controle],
                ),
                "folderId" => $this->folderid,
                "token" => $this->token,
                
            ]
        ]);
        
        $response = curl_exec($ch);
        
    }
        
        curl_close($ch);
        $res = json_decode($response,false);
        header("Location: {$res->data->downloadPage}");
    }
}

$folder = $_REQUEST['folder'];

$newUpload = new UploadFile('Xkure2ZxOVWTB37obXxX8YK49m4WjiEi', $folder);
$newUpload->Upload();
