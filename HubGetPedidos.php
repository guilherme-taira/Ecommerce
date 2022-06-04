<?php
set_time_limit(0);
include_once 'TrayOrders.php';
include_once 'TrayOrderComplete.php';
// CADASTRA ORDEM DA UELLO NO BANCO PEDIDOS
include_once 'CadastrarUelloOrder.php';
// CONEXAO NO BANCO
include_once 'conexao_pdo.php';
// CLIENTE TRAY
include_once 'TrayCostumer.php';
include_once 'UelloAtualizaPedido.php';

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
//set_time_limit(60);
?>
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
    setTimeout(function() {
      window.location.reload(1);
    }, 120000);
  </script>

  <style>
    .logo {
      width: 80px;
      float: left;
    }

    .progressbar {
      width: 100%;
      margin: 25px auto;
      border: solid 1px #000;
    }

    .progressbar .inner {
      height: 15px;
      animation: progressbar-countdown;
      /* Placeholder, this will be updated using javascript */
      animation-duration: 120s;
      /* We stop in the end */
      animation-iteration-count: 1;
      /* Stay on pause when the animation is finished finished */
      animation-fill-mode: forwards;
      /* We start paused, we start the animation using javascript */
      animation-play-state: paused;
      /* We want a linear animation, ease-out is standard */
      animation-timing-function: linear;
    }

    @keyframes progressbar-countdown {
      0% {
        width: 70%;
        background: #0F0;
      }

      100% {
        width: 0%;
        background: #F00;
      }
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-2" id="atualiza">
    <div class="row">

      <script>
        /*
         *  Creates a progressbar.
         *  @param id the id of the div we want to transform in a progressbar
         *  @param duration the duration of the timer example: '10s'
         *  @param callback, optional function which is called when the progressbar reaches 0.
         */
        function createProgressbar(id, duration, callback) {
          // We select the div that we want to turn into a progressbar
          var progressbar = document.getElementById(id);
          progressbar.className = 'progressbar';

          // We create the div that changes width to show progress
          var progressbarinner = document.createElement('div');
          progressbarinner.className = 'inner';

          // Now we set the animation parameters
          progressbarinner.style.animationDuration = duration;

          // Eventually couple a callback
          if (typeof(callback) === 'function') {
            progressbarinner.addEventListener('animationend', callback);
          }

          // Append the progressbar to the main progressbardiv
          progressbar.appendChild(progressbarinner);

          // When everything is set up we start the animation
          progressbarinner.style.animationPlayState = 'running';
        }

        addEventListener('load', function() {
          createProgressbar('progressbar1', '120s');
        });
      </script>
      <?php
      $_SESSION['data_inicial'] = isset($_REQUEST['data_inicial']) ? $_REQUEST['data_inicial'] : date('Y-m-d');
      // data final com -7 dias apartir da data atual
      $dataFinal = DateTime::createFromFormat('Y-m-d', $_SESSION['data_inicial']);
      $dataFinal->format('Y-m-d');
      $dataFinal->modify('-2 day');

      // data final com +1 dias apartir da data atual
      $datainicial = DateTime::createFromFormat('Y-m-d', $_SESSION['data_inicial']);
      $datainicial->format('Y-m-d');
      $datainicial->modify('+2 day');

      // Sessão pagina automatica
      $_SESSION['page'] += isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
      $pagina = $_SESSION['page'];
      $patterns = array('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/', '/^\s*{(\w+)}\s*=/');
      $replace = array('\4/\3/\1\2', '$\1 =');

      $data2 = $datainicial->format('Y-m-d');
      $data1 = $dataFinal->format('Y-m-d');
      //$data2 = $_SESSION['data_inicial']->modify('+1 day');

      // ATUALIZA ORDEM TRAY
      $UpdateOrder = new UpdatePedidoTray();
      $UpdateOrder->EnviaOrdemTray('', $pdo2);

      // INSERT ORDER
      include_once 'UelloCreateOrder.php';
      $obj = new NovaOrdem;
      $obj->EnviaOrdem($pdo2);

      // DADOS DOS PEDIDOS RETORNADO DO SISTEMA
      $Orders = new GetPedidos($_SESSION['access_token_tray'], $pagina, $data1, $data2);
      $requisicao = $Orders->resource();

      //   //print_r($_SESSION['access_token_tray']);
      //   //PAGINA RETORNADO COMEÇO CASO NÂO ENCONTRE MAIS PEDIDOS
      $Paginacao = intval($requisicao->paging->total / $requisicao->paging->limit) + 1;
      if (intVal($Paginacao) <= intVal($_SESSION['page'])) {
        $_SESSION['page'] = 0;
      }

      echo "<div class='container py-2'><div class='row align-items-start'><h3><span class='badge bg-success'>PAGINA : {$pagina} </span> 
      <span class='badge bg-warning text-dark'>Período: {$data1} ~ {$data2}</span>
      <span class='badge bg-info text-dark'>TOTAL DE PEDIDOS NA DATA: {$requisicao->paging->offset} DE {$requisicao->paging->total}</span>
      <div class='spinner-border text-success' role='status'>
      <span class='visually-hidden'>Loading...</span>
      </div>
      </h3>";

      echo "<table border='1'>";
      echo "<pre>";
      // print_r($requisicao);
      foreach ($requisicao->Orders as $Order) {

        // RETORNA OS DADOS COMPLETO DO PEDIDO
        $GetPedidosComplete = new GetPedidosComplete($_SESSION['access_token_tray'], $Order->Order->id);
        $dados = $GetPedidosComplete->resource();

        // echo "<pre>";
        // print_r($dados);

        foreach ($dados->Order->OrderInvoice as $invoice) {
          $n_pedido = $dados->Order->id;
          $chaveNf = $invoice->OrderInvoice->key;
          $NumeroNf = $invoice->OrderInvoice->number;
          $dataNf = $invoice->OrderInvoice->issue_date;
          $serieNf = $invoice->OrderInvoice->serie;
          $TotalNf = $invoice->OrderInvoice->value;
        }

        // VARIAVEL PESO = 0;
        $peso = 0;
        foreach ($dados->Order->ProductsSold as $ProdutoPeso) {
          $peso += $ProdutoPeso->ProductsSold->weight * $ProdutoPeso->ProductsSold->quantity;
        }

        $dataVolume = GeradorMultiplosVolumes($n_pedido, $peso);
        $QuantityVolume = CalculaVolumes($peso);
        //print_r(DistribuiPeso($peso,GeradorDeEtiqueta($n_pedido,GeradorMultiplosVolumes($n_pedido,$peso))));

        if ($dados->Order->shipment == 'EXPRESSO' && $dados->Order->status == 'AGUARDANDO ENVIO') {

          //variavel Cliente $Order->Order->customer_id
          $Cliente = new getCustomers($_SESSION['access_token_tray'], $Order->Order->customer_id);
          $cliente = $Cliente->resource();

          $n_pedido = $dados->Order->id;
          $statement = $pdo2->prepare("SELECT * from UelloPedidos WHERE Orderid = :numeropedido");
          $statement->bindParam(':numeropedido', $n_pedido, PDO::PARAM_INT);
          $statement->execute();
          $count = $statement->fetchAll();


          if (count($count) > 0) {
            echo "<tr><td class='alert alert-danger'>" . $dados->Order->status . "</td>";
            echo "<td class='alert alert-danger'>" . $dados->Order->id . "</td>";
            echo "<td class='alert alert-danger'>" . $dados->Order->shipment . "</td>";
            echo "<td class='alert alert-danger'>" . $dados->Order->date . "</td>";
            echo "<td class='alert alert-danger'> Já Cadastrado</td></tr>";
          } else {
            echo "<tr><td class='alert alert-success'>" . $dados->Order->status . "</td>";
            echo "<td class='alert alert-success'>" . $dados->Order->id . "</td>";
            echo "<td class='alert alert-success'>" . $dados->Order->shipment . "</td>";
            echo "<td class='alert alert-success'>" . $dados->Order->date . "</td>";
            echo "<td class='alert alert-success'>Cadastrado Com Sucesso!</td></tr>";

             // NOVA ORDEM
             $OrderGravaBanco = new CadastrarNewOrder($dados->Order->status,$dados->Order->id,$dados->Order->date,$dados->Order->customer_id,$dados->Order->partial_total,$dados->Order->taxes,
             $dados->Order->discount,$dados->Order->point_sale,$dados->Order->shipment,$dados->Order->shipment_value,
             $dados->Order->shipment_date,$dados->Order->store_note,$dados->Order->discount_coupon,$dados->Order->payment_method_rate,$dados->Order->value_1,$Order->Order->payment_form,$dados->Order->sending_code,
             $dados->Order->session_id,$dados->Order->total,$dados->Order->payment_date,$dados->Order->access_code,$Order->Order->progressive_discount,$Order->Order->shipping_progressive_discount,
             $dados->Order->shipment_integrator,$dados->Order->modified,$dados->Order->printed,$dados->Order->interest,$dados->Order->id_quotation,$dados->Order->estimated_delivery_date,$dados->Order->external_code,
             $dados->Order->has_payment,$dados->Order->has_shipment,$dados->Order->has_invoice,$dados->Order->total_comission_user,$dados->Order->total_comission,0,0,$dados->Order->OrderStatus->id,$dados->Order->OrderStatus->default,
             $dados->Order->OrderStatus->type,$dados->Order->OrderStatus->show_backoffice,$dados->Order->OrderStatus->show_backoffice,$dados->Order->OrderStatus->description,$dados->Order->OrderStatus->show_backoffice,
             $dados->Order->OrderStatus->show_status_central,$dados->Order->OrderStatus->background,$cliente->Customer->name,$cliente->Customer->email,$cliente->Customer->phone,$cliente->Customer->address,
             $cliente->Customer->number,$cliente->Customer->neighborhood,$cliente->Customer->zip_code,$cliente->Customer->neighborhood,$cliente->Customer->city,$cliente->Customer->state,
             $chaveNf,$NumeroNf,$dataNf,$serieNf,$TotalNf,$peso,$cliente->Customer->cpf,$pdo2,$cliente->Customer->complement,$QuantityVolume,$dataVolume);
             // GRAVA NO BANCO
             $OrderGravaBanco->CadastrarOrdem();
          }
        }
      }



      echo "</table>";

      // FUNÇÂO GERA ARRAY DE VOLUMES 
      function GeradorMultiplosVolumes($n_pedido, $peso)
      {
        if (CalculaVolumes($peso) > 1) {
          $pesoreal = $peso;
          for ($i = 0; $i < CalculaVolumes($peso); $i++) {
            $dados[$i] = [
              'identifier' => GeradorDeEtiqueta($n_pedido, $i),
              'weight' => calculaLimitador($pesoreal),
              'volume' => 0.01
            ];
            $pesoreal -= 30000;
          }
        } else {
          $dados = [
            'identifier' => GeradorDeEtiqueta($n_pedido, 1),
            'weight' => calculaLimitador($peso),
            'volume' => 0.01
          ];
        }
         return json_encode($dados);
      }

      function GeradorDeEtiqueta(string $nOrder, $QuantityVolume)
      {
        // COMPOSIÇÂO EMPRESA + NUMERO DO PEDIDO + POSIÇÂO DO VOLUME
        $etiqueta = 'EMBALEME' . $nOrder . 'V' . $QuantityVolume;
        return $etiqueta;
      }

      // função para validação dos campos retornados

      function avancaPagina($pagina)
      {
        $pagina += 1;
        return $pagina;
      }

      function CalculaVolumes($peso)
      {
        if ($peso <= 30000) {
          return 1;
        } else {
          return QuantityVolume($peso);
        }
      }

      function QuantityVolume($peso)
      {
        $volumes = $peso / 30000;
        return ceil($volumes);
      }

      function calculaLimitador($pesoReal)
      {
        if ($pesoReal > 30000) {
          $divide = 30000;
        } else {
          $divide = $pesoReal;
        }
        return $divide;
      }



      function limpacpf($cpf)
      {
        $regex = "/[.-]/";
        $replecement = "";
        return preg_replace($regex, $replecement, $cpf);
      }


      function tirarAcentos($string)
      {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(')/", "/(ç|Ç)/", "/(-)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);
      }

      function FiltraTelefone($numero)
      {

        $regexFone = "/^55/";
        $regexEspecial = "/[(]/";

        if (preg_match($regexFone, $numero) == TRUE) {
          $res = substr($numero, -11);
        } elseif (preg_match($regexEspecial, $numero) == TRUE) {
          $res = preg_replace('/[@\.\;\-\(\)\" "]+/', '', $numero);
        } else {
          $res = $numero;
        }
        return $res;
      }

      function removecarecteresespecial($str)
      {
        $res = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç|Ç)/", "/(-)/"), explode(" ", "a A e E i I o O u U n N c C"), $str);
        return $res;
      }

      ?>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </div>
  </div>