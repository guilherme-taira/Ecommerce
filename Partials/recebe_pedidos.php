<?php
 ini_set('display_errors',1);
 ini_set('display_startup_erros',1);
 error_reporting(E_ALL);

// função que muda o traço da data
$data_inicial = $_REQUEST['data_inicial'];
$data_final = $_REQUEST['data_inicial'];
$pagina = $_REQUEST['pagina'];
$patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/','/^\s*{(\w+)}\s*=/');
$replace = array ('\4/\3/\1\2', '$\1 =');

$data1 =  preg_replace($patterns, $replace, $data_inicial);
$data2 = preg_replace($patterns, $replace, $data_final);

echo "<div class='container'>
<div class='row align-items-start'>
        <h1> Pedidos de Venda </h1>
";

$apikey = "a0e92e1b13cad53953fa6b425bc6cb36bcf51d327ec8ca3c9a0c20d271edb3585cc96277";
$filter = "dataAlteracao[{$data1}TO{$data2}]";
$outputType = "json";
$url = "https://bling.com.br/Api/v2/pedidos/page={$pagina}/json";
$retorno = executeGetOrder($url, $filter, $apikey);
echo $retorno;
function executeGetOrder($url, $filter,$apikey)
{
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url .'&filters='. $filter .'&apikey='.$apikey);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl_handle);
    $jsonDecodificado = json_decode($response);
    curl_close($curl_handle);
    echo "<div class='container-xxl'>";
        echo "<table class='table table-hover'>";
        echo "<thead>
        <tr>
          <th scope='col'>Status</i></th>
          <th scope='col'>Número</th>
          <th scope='col'>Cliente</th>
          <th scope='col'>CPF / CNPJ</th>
          <th scope='col'>Valor Pedido</th>
          <th scope='col'>Situação</th>
          <th scope='col'>Data Pedido</th>
          <th scope='col'>Integração</th>
          <th scope='col'>Email</th>
          <th scope='col'>FRETE</th>
          <th scope='col'>Data</th>
          <th scope='col'>Código</th>
          <th scope='col'>FRETE PREVISTO</th>
        </tr>
      </thead>";
    foreach ($jsonDecodificado->retorno->pedidos as $pedido) {
    
        include_once 'conexao_pdo.php';
        foreach ($pedido as $produtos) {
            $n_pedido = $pedido->pedido->numeroPedidoLoja;
            $statement = $pdo->prepare("SELECT * from pedidos WHERE n_pedido = :numeropedido");
            $statement->bindParam(':numeropedido', $n_pedido, PDO::PARAM_INT);
            $statement->execute();
            $count = $statement->fetchAll();
            if(count($count) > 0){
                echo "
              <tbody>
                <tr>
                <tr>
                <th scope='row'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-square-fill' viewBox='0 0 16 16'>
                <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z'/>
              </svg></th>
                  <td>{$pedido->pedido->numeroPedidoLoja}</td>
                  <td>{$pedido->pedido->cliente->nome}</td>
                  <td>{$pedido->pedido->cliente->cnpj}</td>
                  <td>{$pedido->pedido->totalvenda}</td>
                  <td>{$pedido->pedido->situacao}</td>
                  <td>{$pedido->pedido->data}</td>
                  <td>{$pedido->pedido->tipoIntegracao}</td>
                  <td>{$pedido->pedido->cliente->email}</td>
                  <td>{$pedido->pedido->valorfrete}</td>
                  <td>{$pedido->pedido->dataSaida}</td>
                  ";
                  foreach ($pedido->pedido->transporte->volumes as $volume) {
                         echo"<td>{$volume->volume->codigoRastreamento}</td>
                         <td>{$volume->volume->valorFretePrevisto}</td>";
         
                  }
               echo" </tr>
               </tbody>";
            }else{
            foreach ($produtos->itens as $lista) {
             echo "
              <tbody>
              <th scope='row'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sd-card-fill' viewBox='0 0 16 16'>
              <path fill-rule='evenodd' d='M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0zm-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75zm2.75.75a.75.75 0 0 0-1.5 0v2a.75.75 0 0 0 1.5 0v-2zm1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75z'/>
            </svg></th>
                  <td><div class='alert alert-success' role='alert'>{$pedido->pedido->numeroPedidoLoja}</div></td>
                  <td>{$pedido->pedido->cliente->nome}</td>
                  <td>{$pedido->pedido->totalvenda}</td>
                  <td>{$pedido->pedido->situacao}</td>
                  <td>{$pedido->pedido->data}</td>
                  <td>{$pedido->pedido->tipoIntegracao}</td>
                  <td>{$pedido->pedido->cliente->email}</td>
                </tr>
              </tbody>";

                // echo "número pedido: ". $pedido->pedido->numeroPedidoLoja . "<br>";
                // echo "número pedido: ". $pedido->pedido->numero . "<br>";
                // echo "Código pedido: ". $lista->item->codigo . "<br>";
                // echo "Nome pedido: ". $lista->item->descricao . "<br>";
                // echo "Quantidade: ". $lista->item->quantidade . "<br>";
                // echo "Peso Bruto ".  $lista->item->pesoBruto . "<br>";
                // echo "EAN :". $lista->item->gtin . "<br>";

                try {
                    $pdo->beginTransaction();
                    $n_pedido = $pedido->pedido->numeroPedidoLoja;
                    $cod_prod = $lista->item->codigo;
                    $descricao = $lista->item->descricao;
                    $quantidade = $lista->item->quantidade;
                    $peso = $lista->item->pesoBruto;
                    $EAN = $lista->item->gtin;
                    $valorFrete = $pedido->pedido->valorfrete;
                    $data = $pedido->pedido->dataSaida;
                    $cpnj = $pedido->pedido->cliente->cnpj;
                    $codigoRastreamento = $volume->volume->codigoRastreamento;


                    $sql = "INSERT INTO pedidos (n_pedido,cod_prod,descricao,quantidade,peso,EAN,dataSaida,frete,cpf,codigoRastreamento)";
                    $sql_values = " VALUES (:n_pedido, :cod_prod, :descricao, :quantidade, :peso, :EAN, :datasaida, :frete, :cpf, :codigoRastreamento)";

                    $statement = $pdo->prepare($sql.=$sql_values);
                    $statement->bindValue('n_pedido',(string) $n_pedido, PDO::PARAM_INT);
                    $statement->bindValue('cod_prod', (int) $cod_prod, PDO::PARAM_INT);
                    $statement->bindValue('descricao', (string) $descricao, PDO::PARAM_STR);
                    $statement->bindValue('quantidade', (int) $quantidade, PDO::PARAM_INT);
                    $statement->bindValue('peso', $peso, PDO::PARAM_STR);
                    $statement->bindValue('EAN', $EAN, PDO::PARAM_STR);
                    $statement->bindValue('datasaida', $data, PDO::PARAM_STR);
                    $statement->bindValue('frete', (float) $valorFrete, PDO::PARAM_STR);
                    $statement->bindValue('cpf',$cpnj, PDO::PARAM_STR);
                    $statement->bindValue('codigoRastreamento',(string) $codigoRastreamento, PDO::PARAM_STR);
                    $statement->execute();
                    $pdo->commit();
                } catch (\PDOException $th) {
                    // cancela e devolve a transação.
                    $pdo->rollBack();
                    echo $th->getMessage();
                }
            }
        }
          
        }
     
    }
    echo "</table>";
}
echo "
</div>
</div>";

