<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  <title>Produtividade AoVivo</title>
  <script>
        function update() {
            $('#atualiza').load("produtividadelive.php #atualiza");
        }
           setInterval('update()', 1000);

 </script>
</head>
<body>

<?php
set_time_limit(0);
$apikey = "a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277";
$filter = "dataAlteracao[10/11/2021 TO 10/11/2021]";
$outputType = "json";
$url = "https://bling.com.br/Api/v2/pedidos/page=1/json/";

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url . '&filters=' . $filter. '&apikey=' . $apikey);   	
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl_handle);
    $json = json_decode($response,false);

    echo "<div class='container-xxl'>";
    echo "<table border='1'>";
    echo "<thead>
    <tr>
      <th scope='col'>Status</i></th>
      <th scope='col'>Número</th>
      <th scope='col'>Cliente</th>
      <th scope='col'>Valor Pedido</th>
      <th scope='col'>Situação</th>
      <th scope='col'>Data Pedido</th>
      <th scope='col'>Integração</th>
      <th scope='col'>Email</th>
      <th scope='col'>RET</th>
    </tr>
  </thead>";
foreach ($json->retorno->pedidos as $value) {

    include_once 'conexao_pdo.php';
    foreach ($value as $produtos) {

        $n_pedido = $value->pedido->numeroPedidoLoja;
        $statement = $pdo2->prepare("SELECT * from pedidos WHERE n_pedido = :numeropedido");
        $statement->bindParam(':numeropedido', $n_pedido, PDO::PARAM_INT);
        $statement->execute();
        $count = $statement->fetchAll();
        if(count($count) > 0){
            if($value->pedido->tipoIntegracao == "Shopee"){

                echo "
                 <tbody>
                 <th scope='row'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sd-card-fill' viewBox='0 0 16 16'>
                 <path fill-rule='evenodd' d='M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2.75.75a.75.75 0 0 0-1.5 0v2a.75.75 0 0 0 1.5 0v-2zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75z'/>
               </svg></th>
                     <td class='alert alert-success'><div class='alert alert-success' role='alert'>{$value->pedido->numeroPedidoLoja}</div></td>
                     <td class='alert alert-success'>{$value->pedido->cliente->nome}</td>
                     <td class='alert alert-success'>{$value->pedido->totalvenda}</td>
                     <td class='alert alert-success'>{$value->pedido->situacao}</td>
                     <td class='alert alert-success'>{$value->pedido->data}</td>
                     <td class='alert alert-success'>{$value->pedido->tipoIntegracao}</td>
                     <td class='alert alert-success'>{$value->pedido->cliente->email}</td>
                     <td class='alert alert-success'>RET OK</td>
                   </tr>
               
                 </tbody>";
                   }else{
                       echo "
                       <tbody>
                       <th scope='row'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sd-card-fill' viewBox='0 0 16 16'>
                       <path fill-rule='evenodd' d='M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2.75.75a.75.75 0 0 0-1.5 0v2a.75.75 0 0 0 1.5 0v-2zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75z'/>
                     </svg></th>
                       <td><div class='alert alert-success' role='alert'>{$value->pedido->numeroPedidoLoja}</div></td>
                       <td>{$value->pedido->cliente->nome}</td>
                       <td>{$value->pedido->totalvenda}</td>
                       <td>{$value->pedido->situacao}</td>
                       <td>{$value->pedido->data}</td>
                       <td>{$value->pedido->tipoIntegracao}</td>
                       <td>{$value->pedido->cliente->email}</td>
                       <td>RET NÂO</td>
                         </tr>
                       </tbody>";
                   }    
        }else{
            
            include_once 'BancoRet.php';  
            if($value->pedido->tipoIntegracao == "Shopee"){
        
                /// variaveis que serao Padrão /////
        
                // inscrição estadual isento (padrão)
                $value->pedido->cliente->ie = "ISENTO";
                $fantasia = "CLIENTE INTERNET";
                // não contribuinte
                $IndicadorIe = 9;
                //tipo de empresa 
                $tipoEmpresa = "PRIVADA";
                //consumidor final 1 = true 0 = false
                $consumidorFinal = 1;
                // email padrao 
                $email = "cliente@cliente.com";
                // convenio padrao = NÃO
                $convenio = "N";
                // credito para o cliente
                $clienteCredito = "S";
                // cheque pre
                $chequePre = "N";
                // Conta Corrente
                $CC = "N";
                // Crediário
                $crediario = "S";
                // nome do cliente integração
                $nome = $value->pedido->cliente->nome;
                // cpf/cnpj do cliente
                $cpnj = $value->pedido->cliente->cnpj;
                // inscricao estadual 
                $ie = $value->pedido->cliente->ie;
                // cep do cliente 
                $cep = $value->pedido->cliente->cep;
                // endereco do cliente
                $endereco = $value->pedido->cliente->endereco;
                // numero do cliente
                $numero = $value->pedido->cliente->numero;
                // bairro do cliente
                $bairro = $value->pedido->cliente->bairro;
                // complemento do cliente
                $complemento = $value->pedido->cliente->complemento;
                // telefone 1 do cliente
                $fone1 = $value->pedido->cliente->celular;
                // telefone 2 do cliente
                $fone2 = $value->pedido->cliente->fone;
              
                // FAZER A COMPARAÇÂO DE SE EXISTE A STRING UF NO CADASTRO 
                // SE NÃO HOUVER QUERY SEM O FILTRO ESTADO APENAS NOME DA CIDADE
                
               echo $cidade = strtoupper($value->pedido->cliente->cidade);
               echo $CidadeAcento = tirarAcentos($cidade);

                $UF = strtoupper($value->pedido->cliente->uf);

                // if(empty($UF)){
                //   $sql = "SELECT * from ret501 WHERE ".'"CIDNome"'." LIKE '%".strtoupper($CidadeAcento)."'";
                //   $statement = $pdo->query($sql);
                //   $cidades = $statement->fetch();
                //   echo "Código da Cidade:".$cidades['CIDCod'];
                //   $codCidade = $cidades['CIDCod'];
                // }else{
                //   $sql = "SELECT * from ret501 WHERE ".'"CIDNome"'." LIKE '%".strtoupper($CidadeAcento)."' AND ".'"CIDUF"'." = '$UF'";
                //   $statement = $pdo->query($sql);
                //   $cidades = $statement->fetch();
                //   echo "Código da Cidade:".$cidades['CIDCod'];
                //   $codCidade = $cidades['CIDCod'];
                // }

                // try {
                //   $pdo->beginTransaction();
                //   // select para o generator e lista o proximo id
                //   $sql = "SELECT GEN_ID(GEN_RET028_ID, 1) from ". 'rdb$database';
        
                //   $statement1 = $pdo->query($sql);
                //   $last_insert = $statement1->fetch();
                //   // verifica a quantidade de letras e retorna formatado de acordo com a quantidade
                //   $lastId = '0'.$last_insert['GEN_ID'];
        
                //   $sql = "INSERT INTO ret028 (".'"CLICod"'.",".'"CLINome"'.",".'"CLICPF"'.",".'"CLIFantasia"'.",".'"CLICep"'.",".'"CLIEnd"'.",".'"CLINUMERO"'.",".'"CLIBairro"'.",".'"CLICOMPLEMENTO"'.",".'"CLIFone1"'.",".'"CLIIE"'.",".'"CLIINDINSCESTADUAL"'.",".'"CLITIPOEMPRESA"'.",".'"CLICONVENIO"'.",".'"CLICred"'.",".'"CLICH"'.",".'"CLICR"'.",".'"CLICC"'.",".'"CIDCod"'.",".'"CLIEmail"'.")";
                //   $sql_values = " VALUES (:clicod,:clinome, :clicpf, :clifantasia, :clicep, :cliend, :clinumero,:clibairro,:clicomplemento,:clifone1,:cliie,:cliindinscestadual,:clitipoempresa,:cliconvenio,:clicred,:clich,:clicr,:clicc,:cidcod,:cliemail)";
                //   $statement = $pdo->prepare($sql.=$sql_values);
                //   $statement->bindValue(':clinome', strtoupper(removecarecteresespecial($nome)), PDO::PARAM_STR);
                //   $statement->bindValue(':clicpf', limpacpf($cpnj), PDO::PARAM_STR);
                //   $statement->bindValue(':clifantasia', $fantasia, PDO::PARAM_STR);
                //   $statement->bindValue(':clicep', $cep, PDO::PARAM_STR);
                //   $statement->bindValue(':cliend', strtoupper(removecarecteresespecial($endereco)), PDO::PARAM_STR);
                //   $statement->bindValue(':clinumero',$numero,PDO::PARAM_INT);
                //   $statement->bindValue(':clibairro',strtoupper(removecarecteresespecial($bairro)),PDO::PARAM_STR);
                //   $statement->bindValue(':clicomplemento',$complemento,PDO::PARAM_STR);
                //   $statement->bindValue(':clifone1',FiltraTelefone($fone1),PDO::PARAM_STR);
                //   $statement->bindValue(':cliie',$ie,PDO::PARAM_STR);
                //   $statement->bindValue(':cliindinscestadual',$IndicadorIe,PDO::PARAM_INT);
                //   $statement->bindValue(':clitipoempresa',$tipoEmpresa,PDO::PARAM_STR);
                //   $statement->bindValue(':cliconvenio',$convenio,PDO::PARAM_STR);
                //   $statement->bindValue(':clicred',$clienteCredito,PDO::PARAM_STR);
                //   $statement->bindValue(':clich',$chequePre,PDO::PARAM_STR);
                //   $statement->bindValue(':clicr',$crediario,PDO::PARAM_STR);
                //   $statement->bindValue(':clicc',$CC,PDO::PARAM_STR);
                //   $statement->bindValue(':cidcod',$codCidade,PDO::PARAM_STR); 
                //   $statement->bindValue(':cliemail',$email,PDO::PARAM_STR);     
                //   $statement->bindValue(':clicod', $lastId, PDO::PARAM_STR);
                //   $statement->execute();
                //   echo "CADASTRO COM SUCESSSO! <br>";
                //   $pdo->commit();
                // } catch (\PDOException $e) {
                //     echo $e->getMessage();
                //     echo $e->getCode();
                //     $pdo->rollBack();
                // }
                }

        foreach ($produtos->itens as $lista) {
            if($value->pedido->tipoIntegracao == "Shopee"){

         echo "
          <tbody>
          <th scope='row'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sd-card-fill' viewBox='0 0 16 16'>
          <path fill-rule='evenodd' d='M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2.75.75a.75.75 0 0 0-1.5 0v2a.75.75 0 0 0 1.5 0v-2zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75z'/>
        </svg></th>
              <td class='alert alert-success'><div class='alert alert-success' role='alert'>{$value->pedido->numeroPedidoLoja}</div></td>
              <td class='alert alert-success'>{$value->pedido->cliente->nome}</td>
              <td class='alert alert-success'>{$value->pedido->totalvenda}</td>
              <td class='alert alert-success'>{$value->pedido->situacao}</td>
              <td class='alert alert-success'>{$value->pedido->data}</td>
              <td class='alert alert-success'>{$value->pedido->tipoIntegracao}</td>
              <td class='alert alert-success'>{$value->pedido->cliente->email}</td>
              <td class='alert alert-success'>{$value->pedido->cliente->telefone}</td>
              <td class='alert alert-success'>RET OK</td>
            </tr>
        
          </tbody>";
            }else{
                echo "
                <tbody>
                <th scope='row'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sd-card-fill' viewBox='0 0 16 16'>
                <path fill-rule='evenodd' d='M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2.75.75a.75.75 0 0 0-1.5 0v2a.75.75 0 0 0 1.5 0v-2zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75z'/>
              </svg></th>
                <td><div class='alert alert-success' role='alert'>{$value->pedido->numeroPedidoLoja}</div></td>
                <td>{$value->pedido->cliente->nome}</td>
                <td>{$value->pedido->totalvenda}</td>
                <td>{$value->pedido->situacao}</td>
                <td>{$value->pedido->data}</td>
                <td>{$value->pedido->tipoIntegracao}</td>
                <td>{$value->pedido->cliente->email}</td>
                <td>RET NÂO</td>
                  </tr>
              
                </tbody>";
            }

            // try {
            //     $pdo2->beginTransaction();
            //     $n_pedido = $pedido->pedido->numeroPedidoLoja;
            //     $cod_prod = $lista->item->codigo;
            //     $descricao = $lista->item->descricao;
            //     $quantidade = $lista->item->quantidade;
            //     $peso = $lista->item->pesoBruto;
            //     $EAN = $lista->item->gtin;

            //     $sql = "INSERT INTO pedidos (n_pedido,cod_prod,descricao,quantidade,peso,EAN)";
            //     $sql_values = " VALUES (:n_pedido, :cod_prod, :descricao, :quantidade, :peso, :EAN)";

            //     $statement = $pdo2->prepare($sql.=$sql_values);
            //     $statement->bindValue('n_pedido',(string) $n_pedido, PDO::PARAM_INT);
            //     $statement->bindValue('cod_prod', (int) $cod_prod, PDO::PARAM_INT);
            //     $statement->bindValue('descricao', (string) $descricao, PDO::PARAM_STR);
            //     $statement->bindValue('quantidade', (int) $quantidade, PDO::PARAM_INT);
            //     $statement->bindValue('peso', $peso, PDO::PARAM_STR);
            //     $statement->bindValue('EAN', $EAN, PDO::PARAM_STR);
            //     $statement->execute();
            //     $pdo2->commit();
            // } catch (\PDOException $th) {
            //     // cancela e devolve a transação.
            //     $pdo2->rollBack();
            //     echo $th->getMessage();
            // }
        }
    }
      
    }
}
echo "</table>";

// função para validação dos campos retornados



function limpacpf($cpf){
    $regex = "/[.-]/";
    $replecement = "";
    return preg_replace($regex,$replecement,$cpf);
}


function tirarAcentos($string){
  return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}

function FiltraTelefone($numero)
{

  $regexFone = "/^55/";
  $regexEspecial = "/[(]/";

  if(preg_match($regexFone,$numero) == TRUE){
      $res = substr($numero, -11);   
  }elseif(preg_match($regexEspecial,$numero) == TRUE){
      $res = preg_replace('/[@\.\;\-\(\)\" "]+/', '', $numero);
  }else{
      $res = $numero;
  }
    return $res;
}


function removecarecteresespecial($str)
{
    $res = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$str);
    return $res;
}
?>
</div>  
</div>
</body>
</html>

