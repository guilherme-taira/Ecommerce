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


    if (isset($_SESSION['msg_success'])) {
        echo $_SESSION['msg_success'];
        unset($_SESSION['msg_success']);
    }

    if (isset($_SESSION['msg_error'])) {
        echo $_SESSION['msg_error'];
        unset($_SESSION['msg_error']);
    }
    ?>

    <div class="container-fluid mt-4">

        <form class="row g-3 needs-validation mt-2" action="TrayCreateNf.php" method="POST" novalidate>

        <div class="col-md-1">
                <label for="validationCustom01" class="form-label">Pedido Gerado</label>
                <input type="text" class="form-control" name="Order" id="validationCustom01" placeholder="1231321" required>
                <div class="valid-feedback">
                    Digite o Número do Pedido
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Data da Nota</label>
                <input type="text" class="form-control" name="Data_Nota" id="validationCustom01" value="<?php echo date('Y-m-d'); ?>" placeholder="yyyy-mm-dd" required>
                <div class="valid-feedback">
                    Digite o valor unitário
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Número</label>
                <input type="text" class="form-control" name="NumeroNota" id="validationCustom01" placeholder="000001" required>
                <div class="valid-feedback">
                    Digite o Número da nota
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Serie</label>
                <input type="text" class="form-control" name="Serie" id="validationCustom01" placeholder="123" required>
                <div class="valid-feedback">
                    Digite o Preço Promocional
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Valor</label>
                <input type="text" class="form-control" name="value" id="validationCustom01" value="0.00" required>
                <div class="valid-feedback">
                    Digite a data inicial da promoção
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Chave</label>
                <input type="text" class="form-control" name="chaveNota" id="validationCustom01" placeholder="3521554432139654659342434131231" required>
                <div class="valid-feedback">
                    Digite a data Final da promoção
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Link de Pesquisa</label>
                <input type="text" class="form-control" name="link" value="www.embaleme.br/" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o link para pesquisa
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">CFOP DO PRODUTO</label>
                <input type="text" class="form-control" name="cfopProd" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Variação id</label>
                <input type="text" class="form-control" name="cfopid" value="0" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o cfop da variação
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">CFOP</label>
                <input type="text" class="form-control" name="cfop" value="1234" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o cfop da variação
                </div>
            </div>

            <!----->
            <div class="col-12">
                <button class="btn btn-success" type="submit">Pesquisar</button>
            </div>
        </form>
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