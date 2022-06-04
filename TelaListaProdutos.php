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
    include_once 'TrayListProdutos.php';
    ?>
    <div class="container-fluid mt-4">

        <?php
            
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
                    <option selected value=""> Selecione..</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
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
$_SESSION['status'] = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
$page = $_SESSION['page'];
$name = $_SESSION['name'];
$status = $_SESSION['status'];
// $numpedido = $_SESSION['numpedido'];

// INSTANCIA DO OBJETO DA CLASSE
$TrayListProduto = new TrayListProdutos;
$orders = $TrayListProduto->resource($_SESSION['access_token_tray'],$page,$status,$name);


if (intval($orders->paging->total) <= intval($orders->paging->offset)) {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaListaProdutos.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
    <a href='TelaListaProdutos.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
}else if (intval($orders->paging->offset) == 0) {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaListaProdutos.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
    <a href='TelaListaProdutos.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
    </div>";
}else {
    echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    <a href='TelaListaProdutos.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
    <a href='TelaListaProdutos.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
    <a href='TelaListaProdutos.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
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

foreach ($orders->Products as $produto) {

    //print_r($categoria->Category);
    echo "<tbody>
        <td>{$produto->Product->id}</div></td>
        <td><a href='TelaAtualizaSaldoPreco.php?id={$produto->Product->id}'>{$produto->Product->name}</a></td>";
        if($produto->Product->available == 0){
            echo "<td><span class='badge rounded-pill bg-danger'>Inativo</span></td>";
        }else{
            echo "<td><span class='badge rounded-pill bg-success'>Ativo</span></td>";
        }
        echo"<td>{$produto->Product->price}</td>
        <td>{$produto->Product->stock}</td>
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
<!-- 
[Products] => Array
        (
            [0] => stdClass Object
                (
                    [Product] => stdClass Object
                        (
                            [modified] => 2021-11-17 09:36:15
                            [ean] => 6986500010425
                            [is_kit] => 0
                            [slug] => bolsas-brindes
                            [ncm] => 
                            [activation_date] => 0000-00-00
                            [deactivation_date] => 0000-00-00
                            [id] => 1507
                            [name] => CARTUCHO DE TONNER BROTHER 1617W
                            [price] => 99.00
                            [cost_price] => 0.00
                            [dollar_cost_price] => 0.00
                            [promotional_price] => 0.00
                            [start_promotion] => 0000-00-00
                            [end_promotion] => 0000-00-00
                            [brand] => LEADSHIP
                            [brand_id] => 71341
                            [model] => 
                            [weight] => 0
                            [length] => 0
                            [width] => 0
                            [height] => 0
                            [stock] => 23
                            [category_id] => 0
                            [available] => 0
                            [availability] => 
                            [reference] => 1507
                            [hot] => 0
                            [release] => 0
                            [additional_button] => 
                            [has_variation] => 0
                            [rating] => 0
                            [count_rating] => 0
                            [quantity_sold] => 0
                            [url] => stdClass Object
                                (
                                    [http] => http://trayparceiros.commercesuite.com.br/cartucho-de-tonner-brother-1617w-pr-1507-391250.htm
                                    [https] => https://trayparceiros.commercesuite.com.br/cartucho-de-tonner-brother-1617w-pr-1507-391250.htm
                                )

                            [created] => 2021-09-08 14:41:35
                            [Properties] => Array
                                (
                                )

                            [payment_option] => 
                            [payment_option_details] => Array
                                (
                                )

                            [related_categories] => Array
                                (
                                )

                            [release_date] => 0000-00-00
                            [shortcut] => cartucho-de-tonner-brother-1617w
                            [virtual_product] => 
                            [minimum_stock] => 2
                            [minimum_stock_alert] => 1
                            [free_shipping] => 0
                            [video] => 
                            [metatag] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [type] => description
                                            [content] => CARTUCHO DE TONNER BROTHER 1617W
                                        )

                                )

                            [payment_option_html] => 
                            [upon_request] => 0
                            [available_for_purchase] => 0
                            [all_categories] => Array
                                (
                                )

                            [AdditionalInfos] => Array
                                (
                                )

                            [ProductImage] => Array
                                (
                                )

                            [id_campaign] => 
                            [kit_has_variation] => 0
                            [Variant] => Array
                                (
                                )

                        )

                ) -->
