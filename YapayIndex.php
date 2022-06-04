<!DOCTYPE html>
<html lang="en">
<?php
include_once 'AuthInvoice.php';
include_once 'Partials/_header.php';
?>
<body>
    <?php
    include_once 'Partials/_navbar.php';
    ?>

    <div class="container-xl mt-4">
        <form class="row g-3 needs-validation" action="" method="POST" novalidate>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Número do Pedido</label>
                <input type="text" class="form-control" name="numpedido" id="validationCustom01" placeholder="123456">
                <div class="valid-feedback">
                    Número do Pedido
                </div>
            </div>

            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Email ou Nome do cliente</label>
                <input type="text" class="form-control" id="validationCustom02" placeholder="teste@teste.com / Maria jose">
                <div class="valid-feedback">
                    Email ou Nome do cliente
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Data inicial de Criação</label>
                <input type="date" class="form-control" id="validationCustom05" disabled>
                <div class="valid-feedback">
                    Data inicial de Criação
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Data final de Criação</label>
                <input type="date" class="form-control" id="validationCustom05" disabled>
                <div class="valid-feedback">
                    Data Final de Criação
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-success" type="submit">Pesquisar</button>
            </div>
        </form>

        <?php

        include_once 'BuscaByOrderNumber.php';
        // retorno simples
        if (isset($_REQUEST['numpedido'])) {
            $numeroPedido = $_REQUEST['numpedido'];
            $GetDataCostumer = new GetOrderByNumberYapay($numeroPedido, $_SESSION['access_token']);
            $GetDataCostumer->resource();
            unset($_REQUEST);
        } else {
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