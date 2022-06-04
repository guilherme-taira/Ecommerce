<?php
session_start();
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
    include_once 'AuthInvoice.php';
    ?>

    <div class="container-fluid mt-4">
        <form class="row g-3 needs-validation" action="" method="GET" novalidate>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Número do Pedido</label>
                <input type="text" class="form-control" name="numpedido" id="validationCustom01" placeholder="123456">
                <div class="valid-feedback">
                    Número do Pedido
                </div>
            </div>

            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Email ou Nome do cliente</label>
                <input type="text" class="form-control" name="cliente" id="validationCustom02" placeholder="teste@teste.com / Maria jose">
                <div class="valid-feedback">
                    Email ou Nome do cliente
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Data inicial de Criação</label>
                <input type="date" class="form-control" name="dataInicial" value="<?php echo isset($_SESSION['dataInicial']) ? $_SESSION['dataInicial']:"";?>" id="validationCustom05">
                <div class="valid-feedback">
                    Data inicial de Criação
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Data final de Criação</label>
                <input type="date" class="form-control" name="dataFinal"  value="<?php echo isset($_SESSION['dataFinal']) ? $_SESSION['dataFinal']:""; ?>"  id="validationCustom05">
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

        $_SESSION['dataInicial'] = isset($_REQUEST['dataInicial']) ? $_REQUEST['dataInicial'] : "";
        $_SESSION['dataFinal'] = isset($_REQUEST['dataFinal']) ? $_REQUEST['dataFinal'] : "";
        $_SESSION['status'] = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
        $_SESSION['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
        include_once 'BuscaByOrderPedidos.php';

        // retorno simples
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : $_SESSION['dataInicial'];
        $order_number = isset($_REQUEST['numpedido']) ? $_REQUEST['numpedido'] : "";
        $cliente = isset($_REQUEST['cliente']) ? $_REQUEST['cliente'] : "";
        $dataInicial = isset($_REQUEST['dataInicial']) ? $_REQUEST['dataInicial'] : "";
        $dataFinal = isset($_REQUEST['dataFinal']) ? $_REQUEST['dataFinal'] : "";
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;


        $GetDataCostumer = new GetOrderByNumberYapay($_SESSION['access_token'],$status,$order_number,$cliente,$dataInicial,$dataFinal,$page);
        $GetDataCostumer->resource();

        function avancaPagina($pagina){
            $pagina += 1;
            return $pagina;
        }

        function voltaPagina($pagina){
            $pagina -= 1;
            return $pagina;
        }

        function limpaFiltros(){
            unset($_SESSION);
            unset($_REQUEST);
        }
   
        if(intval($GetDataCostumer->getPage()) >= intval($GetDataCostumer->getLastPage())){
        echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
        <a href='TelaConciliadorGetAll.php?".http_build_query($_REQUEST)."&page=". voltaPagina($page)."'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
        <a href='TelaConciliadorGetAll.php?".limpaFiltros()."'><button class='btn btn-outline-warning' type='button'>Limpar Filtros</button></a>
        </div>";
        unset($_REQUEST['page']);
        }else{
            echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
            <a href='TelaConciliadorGetAll.php?".http_build_query($_REQUEST)."&page=". voltaPagina($page)."'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
            <a href='TelaConciliadorGetAll.php?".http_build_query($_REQUEST)."&page=". avancaPagina($page)."'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
            <a href='TelaConciliadorGetAll.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
           
            </div>";
        }

         // http://localhost/dashboard/Dobesone/TelaConciliadorGetAll.php?numpedido=&cliente=&dataInicial=2021-03-12&dataFinal=2021-03-12&status=approved
         // http://localhost/dashboard/Dobesone/TelaConciliadorGetAll.php?page=numpedido=&cliente=&dataInicial=2021-03-12&dataFinal=2021-03-12&status=approved1
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

