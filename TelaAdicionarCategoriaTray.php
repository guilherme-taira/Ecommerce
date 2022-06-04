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
    <div class="container-sm">
        <div class="container-fluid mt-4">
            <form class="row g-3 needs-validation mt-2" action="TrayCreateCategoria.php" method="GET" novalidate>
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Nome da Categoria</label>
                    <input type="text" class="form-control" name="nome" id="validationCustom01" placeholder="Confeitaria" required>
                    <div class="valid-feedback">
                        Digite o nome da Categoria.
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="validationCustom01" class="form-label">Palavra Chave</label>
                    <input type="text" class="form-control" name="palavrachave" id="validationCustom01" placeholder="Confeitaria" required>
                    <div class="valid-feedback">
                        Digite a palavra chave
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Meta Description</label>
                    <input type="text" class="form-control" name="metadescription" id="validationCustom01" placeholder="" required>
                    <div class="valid-feedback">
                        Número a meta Description
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Propriedades - Coloque virgula para separar as palavras</label>
                    <input type="text" class="form-control" name="propriedades" id="validationCustom01" placeholder="Confeitaria" required>
                    <div class="valid-feedback">
                        Número do Pedido
                    </div>
                </div>

                <div class="mb-3">
                    <label for="validationTextarea" class="form-label">Descrição da Categoria</label>
                    <textarea class="form-control is-invalid" id="validationTextarea" rows="5" name="descricao" placeholder="produtos para confeitaria em geral para você fazer..." required></textarea>
                    <div class="invalid-feedback">
                        Preencha a Descrição da Categoria
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
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