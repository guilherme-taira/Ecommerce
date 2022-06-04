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
    include_once 'TrayListCategoria.php';


    if(isset($_SESSION['msg_success'])){
        echo $_SESSION['msg_success'];
        unset($_SESSION['msg_success']);
    }

    if(isset($_SESSION['msg_error'])){
        echo $_SESSION['msg_error'];
        unset($_SESSION['msg_error']);
    }
    ?>


    
    <div class="container-fluid mt-4">

    <a href='TelaAdicionarCategoriaTray.php?'><button class='btn btn-outline-success' type='button'>+ Adicionar Nova Categoria</button></a>
   
        <form class="row g-3 needs-validation mt-2" action="" method="GET" novalidate>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" name="name" id="validationCustom01" value="<?php echo isset($_REQUEST['name']) ? $_REQUEST['name']:""; ?>" placeholder="Chocolate Importado">
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
$_SESSION['name'] = isset($_REQUEST['name']) ? $_REQUEST['name'] : "";

$page = $_SESSION['page'];
$name = $_SESSION['name'];
// $numpedido = $_SESSION['numpedido'];

// INSTANCIA DO OBJETO DA CLASSE
$GetCategorias = new ListCategoriaTray;
$orders = $GetCategorias->resource($_SESSION['access_token_tray'],$page,$name);


if (intval($orders->paging->total) <= intval($orders->paging->offset)) {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaListaCategoriaTray.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
    <a href='TelaListaCategoriaTray.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
}else if (intval($orders->paging->offset) == 0) {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaListaCategoriaTray.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
    <a href='TelaListaCategoriaTray.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
}else {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaListaCategoriaTray.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
    <a href='TelaListaCategoriaTray.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
    <a href='TelaListaCategoriaTray.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
}

echo "<table class='table mt-4'>
<thead>
  <tr>
    <th scope='col'>ID</th>
    <th scope='col'>Nome</th>
    <th scope='col'>Ativo</th>
    <th scope='col'>Descrição</th>
    <th scope='col'>Descrição Reduzida</th>
  </tr>
</thead>
<tbody>
  <tr>";

foreach ($orders->Categories as $categoria) {

    //print_r($categoria->Category);
    echo "<tbody>
        <td>{$categoria->Category->id}</div></td>
        <td><a href='#'>{$categoria->Category->name}</a></td>
        <td>{$categoria->Category->active}</td>
        <td>{$categoria->Category->description}</td>
        <td>{$categoria->Category->small_description}</td>
      </tr>
    </tbody>";
   
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