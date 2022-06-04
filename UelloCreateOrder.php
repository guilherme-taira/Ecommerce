<?php
// Gera Valor do Preço do Frete
// create by GUILHERME TAIRA  --> 01/12/2021 as 14:24

// METHOD POST

// URLBASE PARA AUTENTICAR
define("URLBASE_GERA_ORDER_PLATAFORMA", "http://integration-api.uello.com.br/");


class UelloOrder
{
    private $numOp;
    private $nome;
    private $email;
    private $telefone;
    private $document;
    private $endereco;
    private $numero;
    private $complemento;
    private $referencia;
    private $cep;
    private $vizinho;
    private $cidade;
    private $uf;
    private $chavenf;
    private $numeronf;
    private $dataNf;
    private $serieNf;
    private $totalNf;
    private $peso;
    private $identificador;
    private $pesovolume;
    private $volume;
    private $quantityVolume;
    private $dataVolume;

    function __construct(
        $numOp,
        $nome,
        $email,
        $telefone,
        $document,
        $endereco,
        $numero,
        $complemento,
        $referencia,
        $cep,
        $vizinho,
        $cidade,
        $uf,
        $chavenf,
        $numeronf,
        $dataNf,
        $serieNf,
        $totalNf,
        $peso,
        $identificador,
        $pesovolume,
        $volume,
        $quantityVolume,
        $dataVolume
    ) {
        $this->numOp = $numOp;
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->document = $document;
        $this->endereco = $endereco;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->refencia = $referencia;
        $this->cep = $cep;
        $this->vizinho = $vizinho;
        $this->cidade = $cidade;
        $this->uf = $uf;
        $this->chavenf = $chavenf;
        $this->numeronf = $numeronf;
        $this->dataNf = $dataNf;
        $this->serieNf = $serieNf;
        $this->totalNf = $totalNf;
        $this->peso = $peso;
        $this->identificador = $identificador;
        $this->pesovolume = $pesovolume;
        $this->volume = $volume;
        $this->quantityVolume = $quantityVolume;
        $this->dataVolume = $dataVolume;
    }

    function resource()
    {
        return $this->get('v1/orders');
    }

    function get($resource)
    {

        // Endpoint para requisicao
        $endpoint = URLBASE_GERA_ORDER_PLATAFORMA . $resource;


        $data = array(
            "operation" => 1721,
            "number" => $this->getNumOp(),
            "customer" => array(
                "name" => $this->getNome(),
                "email" => $this->getEmail(),
                "phone" => $this->getTelefone(),
                "document" => $this->getDocument(),
                "address" => array(
                    "address" => $this->getEndereco(),
                    "number" => $this->getNumero(),
                    "complement" => $this->getComplemento(),
                    "reference" => $this->getReferencia(),
                    "postcode" => $this->getCep(),
                    "neighborhood" => $this->getVizinho(),
                    "city" => $this->getCidade(),
                    "uf" => $this->getUf(),
                )
            ),
            "invoice" => array(
                "key" => $this->getChavenf(),
                "number" => $this->getNumeronf(),
                "data" => $this->getDataNf(),
                "serie" => $this->getSerieNf(),
                "total" => $this->getTotalNf(),
                "weight" => $this->getPeso(),
            ),
            "volumes" => $this->dataVolume($this->getDataVolume(),$this->getQuantityVolume()),

        );

        $jsonOrder = json_encode($data, JSON_PRETTY_PRINT);
        //print_r($jsonOrder);

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonOrder);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-KEY: 5d603c762cd410fe66cfa7e689006fec4f395c800eab45327d35f5002d1e0b31", "Content-Type: application/json"]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $requisicao = json_decode($response, false);

            if ($httpCode == "200") {
                return $requisicao;
            } else if ($httpCode == "404") {
                throw new \InvalidArgumentException("Erro ao Gerar o Pedido {$this->getNumeronf()} <br>");
            } else if ($httpCode == "422") {
                throw new \InvalidArgumentException("Erro ao Gerar o Pedido {$this->getNumeronf()} <br>");
            }
        } catch (\Exception $th) {
            echo $th->getMessage();
            echo $th->getCode();
        }
    }

    public function dataVolume($dataVolume, $quantidade)
    {
        $dataJson = [];
        if ($quantidade > 1) {
            foreach (json_decode($dataVolume,false) as $volumeData) {
                $array = [
                    'identifier' => $volumeData->identifier,
                    'weight' => floatval($volumeData->weight / 1000),
                    'volume' => $volumeData->volume,
                ];
                array_push($dataJson, $array);
            }
            return $dataJson;
        }else{
            $data = json_decode($dataVolume,false);
            return [$data];
        }
    }

    /**
     * Get the value of numOp
     */
    public function getNumOp()
    {
        return $this->numOp;
    }

    /**
     * Set the value of numOp
     *
     * @return  self
     */
    public function setNumOp($numOp)
    {
        $this->numOp = $numOp;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

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
     * Get the value of telefone
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     *
     * @return  self
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get the value of document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set the value of document
     *
     * @return  self
     */
    public function setDocument($document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get the value of endereco
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     * Set the value of endereco
     *
     * @return  self
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of complemento
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set the value of complemento
     *
     * @return  self
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    /**
     * Get the value of referencia
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * Set the value of referencia
     *
     * @return  self
     */
    public function setReferencia($referencia)
    {
        $this->referencia = $referencia;

        return $this;
    }

    /**
     * Get the value of cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @return  self
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     *
     * @return  self
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of uf
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set the value of uf
     *
     * @return  self
     */
    public function setUf($uf)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get the value of chavenf
     */
    public function getChavenf()
    {
        return $this->chavenf;
    }

    /**
     * Set the value of chavenf
     *
     * @return  self
     */
    public function setChavenf($chavenf)
    {
        $this->chavenf = $chavenf;

        return $this;
    }

    /**
     * Get the value of numeronf
     */
    public function getNumeronf()
    {
        return $this->numeronf;
    }

    /**
     * Set the value of numeronf
     *
     * @return  self
     */
    public function setNumeronf($numeronf)
    {
        $this->numeronf = $numeronf;

        return $this;
    }

    /**
     * Get the value of dataNf
     */
    public function getDataNf()
    {
        return $this->dataNf;
    }

    /**
     * Set the value of dataNf
     *
     * @return  self
     */
    public function setDataNf($dataNf)
    {
        $this->dataNf = $dataNf;

        return $this;
    }

    /**
     * Get the value of serieNf
     */
    public function getSerieNf()
    {
        return $this->serieNf;
    }

    /**
     * Set the value of serieNf
     *
     * @return  self
     */
    public function setSerieNf($serieNf)
    {
        $this->serieNf = $serieNf;

        return $this;
    }

    /**
     * Get the value of totalNf
     */
    public function getTotalNf()
    {
        return $this->totalNf;
    }

    /**
     * Set the value of totalNf
     *
     * @return  self
     */
    public function setTotalNf($totalNf)
    {
        $this->totalNf = $totalNf;

        return $this;
    }

    /**
     * Get the value of peso
     */
    public function getPeso()
    {
        return $this->peso / 1000;
    }

    /**
     * Set the value of peso
     *
     * @return  self
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get the value of identificador
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set the value of identificador
     *
     * @return  self
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get the value of pesovolume
     */
    public function getPesovolume()
    {
        return $this->pesovolume;
    }

    /**
     * Set the value of pesovolume
     *
     * @return  self
     */
    public function setPesovolume($pesovolume)
    {
        $this->pesovolume = $pesovolume;

        return $this;
    }

    /**
     * Get the value of volume
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set the value of volume
     *
     * @return  self
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get the value of vizinho
     */
    public function getVizinho()
    {
        return $this->vizinho;
    }

    /**
     * Set the value of vizinho
     *
     * @return  self
     */
    public function setVizinho($vizinho)
    {
        $this->vizinho = $vizinho;

        return $this;
    }

    /**
     * Get the value of quantityVolume
     */


    public function getQuantityVolume()
    {
        return $this->quantityVolume;
    }

    /**
     * Get the value of dataVolume
     */
    public function getDataVolume()
    {
        return $this->dataVolume;
    }
}

abstract class CadastraNovaOrdem
{
    public abstract function CadastraNewOrdem($numOp, $nome, $email, $telefone, $document, $endereco, $numero, $complemento, $referencia, $cep, $vizinho, $cidade, $uf, $chavenf, $numeronf, $dataNf, $serieNf, $totalNf, $peso, $identificador, $pesovolume, $volume, $quantityVolume, $dataVolume);
    public abstract function EnviaOrdem(PDO $pdo2);
}



class NovaOrdem extends CadastraNovaOrdem
{
    public function CadastraNewOrdem($numOp, $nome, $email, $telefone, $document, $endereco, $numero, $complemento, $referencia, $cep, $vizinho, $cidade, $uf, $chavenf, $numeronf, $dataNf, $serieNf, $totalNf, $peso, $identificador, $pesovolume, $volume, $quantityVolume, $dataVolume)
    {
        return new UelloOrder($numOp, $nome, $email, $telefone, $document, $endereco, $numero, $complemento, $referencia, $cep, $vizinho, $cidade, $uf, $chavenf, $numeronf, $dataNf, $serieNf, $totalNf, $peso, $identificador, $pesovolume, $volume, $quantityVolume, $dataVolume);
    }

    public function EnviaOrdem(PDO $pdo2)
    {
        // CONEXAO COM O BANCO
        //include_once 'conexao_pdo.php';
        // INSTANCIA DO GERADOR DE URL UELLO
        include_once 'UelloGetTraking.php';
        // STATEMENT DE BUSCA
        //$statement = $pdo2->query("SELECT * FROM UelloPedidos WHERE NFenviado = 1 LIMIT 5");
        $statement = $pdo2->query("SELECT * FROM UelloPedidos WHERE FlagStatus = 'X' LIMIT 15");
        $Flag = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($Flag as $Order) {

            $ordem =  json_decode(json_encode($Order), false);
            $quantityVolume = $ordem->volumes - 1;
            $NovaOrdem = $this->CadastraNewOrdem($ordem->id, $ordem->nomeCliente, $ordem->email, $ordem->telefone, $ordem->documento, $ordem->endereco, $ordem->NumeroCasa, $ordem->complement, $ordem->referencia, $this->LimpaCep($ordem->cep), $ordem->vizinho, $ordem->cidade, $ordem->uf, $ordem->chaveNota, $ordem->NumeroNf, $ordem->dataNf, $ordem->serieNf, $ordem->TotalNf, $ordem->Peso, $ordem->chaveNota, $ordem->Peso, 1, $quantityVolume, $ordem->dataVolume);
            $Status = $NovaOrdem->resource();

            if ($Status->status == 1) {

                echo "<div class='alert alert-success' role='alert'>Pedido Gerado Com SUcesso! Nº : {$Status->data->id} </strong></div>";

                try {
                    $pdo2->beginTransaction();
                    $statement2 = $pdo2->query("UPDATE UelloPedidos SET FlagStatus = '' WHERE id = $ordem->id");
                    $statement2->execute();
                    // GRAVA DADOS DO PEDIDO DO CLIENTE
                    $statement3 = $pdo2->query("UPDATE UelloPedidos SET Id_Uello = '{$Status->data->id}' WHERE id = $ordem->id");
                    $statement3->execute();
                    $pdo2->commit();
                } catch (\PDOException $th) {
                    $pdo2->rollBack();
                    echo $th->getMessage();
                    echo $th->getCode();
                }
                // PEDIDO ATUALIZA URL DE RASTREIO
                $Pedido = new BancoGuardaDados();
                $Pedido->GravaPedido($ordem->Id_Uello, $pdo2);
            } else {
                print_r("Error Ao Gerar o Pedido!");
            }
        }
    }

    function LimpaCep($cep)
    {
        $regex = "/-/";
        $replecement = "";
        return preg_replace($regex, $replecement, $cep);
    }
}

/**
 * 
 * TABELA DE STATUS UELLO
 * arquivo recebido (0)
 * fisico recebido (101)
 * em rota (102)
 * entregue (1)
 * 
 */
