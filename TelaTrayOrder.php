<?php
set_time_limit(100);
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once 'Partials/_header.php';
?>
<body>
    <?php
    include_once 'Partials/_navbar.php';
    // Classe
    include_once 'TrayOrder.php';
    ?>

    <div class="container-fluid mt-4">
        <form class="row g-3 needs-validation" action="" method="GET" novalidate>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Número do Pedido</label>
                <input type="text" class="form-control" name="numpedido" id="validationCustom01" value="<?php echo isset($_SESSION['numpedido']) ? $_SESSION['numpedido']:""; ?>" placeholder="123456">
                <div class="valid-feedback">
                    Número do Pedido
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Data inicial de Criação</label>
                <input type="date" class="form-control" name="dataInicial" value="<?php echo isset($_SESSION['dataInicial']) ? $_SESSION['dataInicial']:"";?>" id="validationCustom05" disabled>
                <div class="valid-feedback">
                    Data inicial de Criação
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Data final de Criação</label>
                <input type="date" class="form-control" name="dataFinal"  value="<?php echo isset($_SESSION['dataFinal']) ? $_SESSION['dataFinal']:""; ?>"  id="validationCustom05" disabled>
                <div class="valid-feedback">
                    Data Final de Criação
                </div>
            </div>

            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Status</label>
                <select class="form-select"  name="status"  id="validationCustom04">
                    <option selected disabled value="<?php echo isset($_SESSION['status']) ? $_SESSION['status']: "";?>">Selecione..</option>
                    <option value="approved">Aprovado</option>
                    <option value="canceled">Cancelado</option>
                    <option value="waiting_payment">Aguardando Pagamento</option>
                    <option value="contestation">Em Contestação</option>
                    <option value="chargeback">chargeback</option>
                    <option value="monitoring">Em Monitoramento</option>
                    <option value="failed">Reprovada</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-success" type="submit">Pesquisar</button>
            </div>
        </form>
<?php

// Tabela de Pedidos 
// Paginação -- Sessão Guarda Páginas Valor DEFAULT = 1.
$_SESSION['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$_SESSION['numpedido'] = isset($_REQUEST['numpedido']) ? $_REQUEST['numpedido'] : "";

$page = $_SESSION['page'];
$numpedido = $_SESSION['numpedido'];

// INSTANCIA DO OBJETO DA CLASSE
$GetPedidos = new GetPedido($_SESSION['access_token_tray'],$numpedido);
$orders = $GetPedidos->resource();

if (intval($orders->paging->total) <= intval($orders->paging->offset)) {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaTrayOrders.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
    <a href='TelaTrayOrders.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
} else {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaTrayOrders.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
    <a href='TelaTrayOrders.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
    <a href='TelaTrayOrders.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
}

echo "<table class='table'>
<thead>
  <tr>
    <th scope='col'>ID</th>
    <th scope='col'>Status</th>
    <th scope='col'>Número Pedido</th>
    <th scope='col'>Forma de Pagamento</th>
    <th scope='col'>Total</th>
    <th scope='col'>Data</th>
  </tr>
</thead>
<tbody>
  <tr>";
foreach ($orders->Orders as $order) {

    echo "<tbody>
        <td>{$order->Order->id}</div></td>
        <td><a href='#'>{$order->Order->status}</a></td>";
    if (empty($order->Order->OrderStatus->id)) {
        echo "<td>SEM NUMERO</td>";
    } else {
        echo "<td>{$order->Order->OrderStatus->id}</td>";
    }
    echo "<td>{$order->Order->payment_form}</td>
        <td>{$order->Order->total}</td>
        <td>{$order->Order->modified}</td>
      </tr>
    </tbody>";
    //print_r($order->Order);
}
echo "
<tr>
<table>";

function avancaPagina($pagina)
{
    $pagina += 1;
    return $pagina;
}

function voltaPagina($pagina)
{
    $pagina -= 1;
    return $pagina;
}

function limpaFiltros()
{
    unset($_SESSION['page']);
    unset($_SESSION['numpedido']);
}
?>


</div>

<!-- Bootstrap Bundle with Popper -->
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>