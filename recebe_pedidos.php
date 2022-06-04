<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  <script>
        function update() {
            $('#atualiza').load("recebe_pedidos.php #atualiza");
        }
           setInterval('update()', 10000);

 </script>
  <style>
    .logo{
      width: 100px;
      float: left;
      margin: 10px;
    }
  </style>
</head>
<body>

<div class="container-fluid mt-2" id="atualiza">
<div class="row"> 
<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
session_start();
$_SESSION['data_inicial'] = isset($_REQUEST['data_inicial']) ? $_REQUEST['data_inicial'] : $_SESSION['data_inicial'];
$_SESSION['data_final'] = isset($_REQUEST['data_final']) ? $_REQUEST['data_final'] : $_SESSION['data_final'];
// Sessão pagina automatica
$_SESSION['page'] += isset($_REQUEST['pagina']) ? $_REQUEST['pagina']: 1;
$pagina = $_SESSION['page'];
$patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/','/^\s*{(\w+)}\s*=/');
$replace = array ('\4/\3/\1\2', '$\1 =');

$data1 =  preg_replace($patterns, $replace, $_SESSION['data_inicial']);
$data2 = preg_replace($patterns, $replace, $_SESSION['data_final']);

echo "<div class='container'><div class='row align-items-start'><h1> <span class='badge bg-primary'>Cadastro de Clientes RET</span> <span class='badge bg-success'>PAGINA : {$pagina}</span></h1>";

$apikey = "a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277";
$filter = "dataEmissao[$data1 TO $data2]";
$outputType = "json";
$url = "https://bling.com.br/Api/v2/pedidos/page=$pagina/json/";
$retorno = executeGetOrder($url, $filter, $apikey);
echo $retorno;
function executeGetOrder($url, $filter,$apikey){
  include_once 'BancoRet.php';  
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url .'&filters='. $filter .'&apikey='.$apikey);	
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl_handle);
    curl_close($curl_handle);
    $json = (object) json_decode($response, false);

    foreach ($json->retorno->erros as $erro) {
      if($erro->erro->cod == '14'){
         unset($_SESSION['page']);
      }
    }

  //   echo "<div class='container-xxl'>";
  //   echo "<table border='1'>";
  //   echo "<thead>
  //   <tr>
  //     <th scope='col'>Número</th>
  //     <th scope='col'>Cliente</th>
  //     <th scope='col'>CPF</th>
  //     <th scope='col'>Fantasia</th>
  //     <th scope='col'>CEP</th>
  //     <th scope='col'>Rua</th>
  //     <th scope='col'>Número</th>
  //     <th scope='col'>Bairro</th>
  //     <th scope='col'>Telefone</th>
  //     <th scope='col'>RET</th>
  //     <th scope='col'>IE</th>
  //     <th scope='col'>Consumidor Final</th>
  //     <th scope='col'>Email</th>
  //     <th scope='col'>Convênio</th>
  //     <th scope='col'>Crédito</th>
  //     <th scope='col'>CH Pré</th>
  //     <th scope='col'>CC</th>
  //     <th scope='col'>Crediário</th>
  //   </tr>
  // </thead>";

    foreach ($json->retorno->pedidos as $value) {
  
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

        $cidade = strtoupper($value->pedido->cliente->cidade);
        $CidadeAcento = tirarAcentos($cidade);
        $UF = strtoupper($value->pedido->cliente->uf);
        
  
        // <td class='alert alert-success'>{$value->pedido->numeroPedidoLoja}</td>
        // <td class='alert alert-success'>{$value->pedido->cliente->nome}</td>
        // <td class='alert alert-success'>{$value->pedido->cliente->cnpj}</td>
        // <td class='alert alert-success'>{$fantasia}</td>
        // <td class='alert alert-success'>{$value->pedido->cliente->cep}</td>
        // <td class='alert alert-success'>{$value->pedido->cliente->endereco}</td>
        // <td class='alert alert-success'>{$value->pedido->cliente->numero}</td>
        // <td class='alert alert-success'>{$value->pedido->cliente->bairro}</td>
        // <td class='alert alert-success'>{$fone1}</td>
        // <td class='alert alert-success'>OK</td>";
        // if($IndicadorIe == 9){
        //   echo "<td class='alert alert-success'>Não Contribuinte </td>";
        // }else{
        //   echo "<td class='alert alert-success'>".$IndicadorIe."</td>";
        // }
        // if($consumidorFinal == 1){
        //   echo "<td class='alert alert-success'>SIM</td>";
        // }else{
        //   echo "<td class='alert alert-success'>NÂO</td>";
        // }

        // if(empty($value->pedido->cliente->email)){
        //   echo "<td class='alert alert-success'>".$email."</td>";
        // }else{
        //   echo "<td class='alert alert-success'>".$value->pedido->cliente->email."</td>";
        // }
  
        // if($convenio == 'N'){
        //   echo "<td class='alert alert-success'> NÃO </td>";
        // }else{
        //   echo "<td class='alert alert-success'>SIM </td>";
        // }
        // if($clienteCredito == 'N'){
        //   echo "<td class='alert alert-success'>NÃO </td>";
        // }else{
        //   echo "<td class='alert alert-success'>SIM </td>";
        // }

        // if($chequePre == 'N'){
        //   echo "<td class='alert alert-success'>NÃO </td>";
        // }else{
        //   echo "<td class='alert alert-success'>SIM </td>";
        // }

        // if($CC == 'N'){
        //   echo "<td class='alert alert-success'>NÃO </td>";
        // }else{
        //   echo "<td class='alert alert-success'>SIM </td>";
        // }

        // if($crediario == 'N'){
        //   echo "<td class='alert alert-success'>NÃO </td>";
        // }else{
        //   echo "<td class='alert alert-success'>SIM </td>";
        // }
        //"<td class='alert alert-success'>". strtoupper($CidadeAcento) . "</td>";
        //"<td class='alert alert-success'>". strtoupper($UF) . "</td>";
            

            
        // FAZER A COMPARAÇÂO DE SE EXISTE A STRING UF NO CADASTRO 
        // SE NÃO HOUVER QUERY SEM O FILTRO ESTADO APENAS NOME DA CIDADE

        if(empty($UF)){
          $sql = "SELECT * from ret501 WHERE ".'"CIDNome"'." LIKE '%".strtoupper(removecarecteresespecial($CidadeAcento))."'";
          $statement = $pdo->query($sql);
          $cidades = $statement->fetch();
          //echo "<td class='alert alert-success'>".$cidades['CIDCod']."</td>";
          $codCidade = $cidades['CIDCod'];
        }else{
          $sql = "SELECT * from ret501 WHERE ".'"CIDNome"'." LIKE '%".strtoupper(removecarecteresespecial($CidadeAcento))."' AND ".'"CIDUF"'." = '$UF'";
          $statement = $pdo->query($sql);
          $cidades = $statement->fetch();
          //echo "<td class='alert alert-success'>".$cidades['CIDCod']."</td>";
          $codCidade = $cidades['CIDCod'];
        }
        
          echo "</tr>
        </tbody>";

    
        // verifica se já esta cadastrado no banco
          $sql = "SELECT * from ret028 WHERE ".'"CLICPF"'." LIKE '".limpacpf($cpnj)."'";
          $statement = $pdo->query($sql);
          $clientesCpf = $statement->fetch();
  
          if(limpacpf($cpnj) == $clientesCpf['CLICPF']){
            echo "
            <tbody>
            <div class='card mt-2 alert alert-danger'>
            <ul class='list-group list-group-flush'>
            <li class='list-group-item'><strong>Número Pedido: {$value->pedido->numeroPedidoLoja} - Já Cadastrado! </strong> <img class='logo' src='shopee-logo.png'> <hr> Nome: {$value->pedido->cliente->nome}    - CPF: {$value->pedido->cliente->cnpj}    - Endereço: {$value->pedido->cliente->endereco},{$value->pedido->cliente->numero},{$value->pedido->cliente->bairro}</li>
            </ul>
            </div>
            ";
          }else{

            echo "
            <tbody>
            <div class='card mt-2 alert alert-success'>
            <ul class='list-group list-group-flush'>
            <li class='list-group-item'><strong>Número Pedido: {$value->pedido->numeroPedidoLoja} - Cadastrado com Sucesso</strong> <img class='logo' src='shopee-logo.png'> <hr> Nome: {$value->pedido->cliente->nome}    - CPF: {$value->pedido->cliente->cnpj}    - Endereço: {$value->pedido->cliente->endereco},{$value->pedido->cliente->numero},{$value->pedido->cliente->bairro}</li>
            </ul>
            </div>  
            ";
  
            try {
              $pdo->beginTransaction();
        
              // select para o generator e lista o proximo id
              $sql = "SELECT GEN_ID(GEN_RET028_ID, 1) from ". 'rdb$database';

              $statement1 = $pdo->query($sql);
              $last_insert = $statement1->fetch();
              // verifica a quantidade de letras e retorna formatado de acordo com a quantidade
              $lastId = '0'.$last_insert['GEN_ID'];

              $sql = "INSERT INTO ret028 (".'"CLICod"'.",".'"CLINome"'.",".'"CLICPF"'.",".'"CLIFantasia"'.",".'"CLICep"'.",".'"CLIEnd"'.",".'"CLINUMERO"'.",".'"CLIBairro"'.",".'"CLICOMPLEMENTO"'.",".'"CLIFone1"'.",".'"CLIIE"'.",".'"CLIINDINSCESTADUAL"'.",".'"CLITIPOEMPRESA"'.",".'"CLICONVENIO"'.",".'"CLICred"'.",".'"CLICH"'.",".'"CLICR"'.",".'"CLICC"'.",".'"CIDCod"'.",".'"CLIEmail"'.")";
              $sql_values = " VALUES (:clicod,:clinome, :clicpf, :clifantasia, :clicep, :cliend, :clinumero,:clibairro,:clicomplemento,:clifone1,:cliie,:cliindinscestadual,:clitipoempresa,:cliconvenio,:clicred,:clich,:clicr,:clicc,:cidcod,:cliemail)";
              $statement = $pdo->prepare($sql.=$sql_values);
              $statement->bindValue(':clinome', strtoupper(removecarecteresespecial($nome)), PDO::PARAM_STR);
              $statement->bindValue(':clicpf', limpacpf($cpnj), PDO::PARAM_STR);
              $statement->bindValue(':clifantasia', $fantasia, PDO::PARAM_STR);
              $statement->bindValue(':clicep', $cep, PDO::PARAM_STR);
              $statement->bindValue(':cliend', strtoupper(removecarecteresespecial($endereco)), PDO::PARAM_STR);
              $statement->bindValue(':clinumero',$numero,PDO::PARAM_INT);
              $statement->bindValue(':clibairro',strtoupper(removecarecteresespecial($bairro)),PDO::PARAM_STR);
              $statement->bindValue(':clicomplemento',$complemento,PDO::PARAM_STR);
              $statement->bindValue(':clifone1',FiltraTelefone($fone1),PDO::PARAM_STR);
              $statement->bindValue(':cliie',$ie,PDO::PARAM_STR);
              $statement->bindValue(':cliindinscestadual',$IndicadorIe,PDO::PARAM_INT);
              $statement->bindValue(':clitipoempresa',$tipoEmpresa,PDO::PARAM_STR);
              $statement->bindValue(':cliconvenio',$convenio,PDO::PARAM_STR);
              $statement->bindValue(':clicred',$clienteCredito,PDO::PARAM_STR);
              $statement->bindValue(':clich',$chequePre,PDO::PARAM_STR);
              $statement->bindValue(':clicr',$crediario,PDO::PARAM_STR);
              $statement->bindValue(':clicc',$CC,PDO::PARAM_STR);
              $statement->bindValue(':cidcod',$codCidade,PDO::PARAM_STR); 
              $statement->bindValue(':cliemail',$email,PDO::PARAM_STR);     
              $statement->bindValue(':clicod', $lastId, PDO::PARAM_STR);
              $statement->execute();
              $pdo->commit();
            } catch (\PDOException $e) {
                echo $e->getMessage();
                echo $e->getCode();
                $pdo->rollBack();
            }
          }
        
      }
    }
}

// função para validação dos campos retornados

function avancaPagina($pagina){
  $pagina += 1;
  return $pagina;
}

function limpacpf($cpf){
    $regex = "/[.-]/";
    $replecement = "";
    return preg_replace($regex,$replecement,$cpf);
}


function tirarAcentos($string){
  return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(')/","/(ç|Ç)/","/(-)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
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
    $res = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç|Ç)/","/(-)/"),explode(" ","a A e E i I o O u U n N c C"),$str);
    return $res;
}



?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</div>
</div>
</body>
</html>
