<!DOCTYPE html>
<html lang="en">
<?php
include_once 'Partials/_header.php';
include_once 'TrayListProdutoIndividual.php';
?>

<body>
    <?php
    include_once 'Partials/_navbar.php';
    // Classe
    if (isset($_SESSION['msg_success'])) {
        echo $_SESSION['msg_success'];
        unset($_SESSION['msg_success']);
    }

    if (isset($_SESSION['msg_error'])) {
        echo $_SESSION['msg_error'];
        unset($_SESSION['msg_error']);
    }
    ?>

    <div class="container-fluid mt-4" id="form-variacao">

        <a href='TelaAdicionarCategoriaTray.php?'><button class='btn btn-outline-success' type='button'>+ Adicionar Nova Categoria</button></a>

        <form class="row g-3 needs-validation mt-2" action="TrayPutAtualizaProduto.php" method="POST" novalidate>
            <?php

            $TrayListProdutoIndividual = new TrayListProdutoIndividual;
            $produto = $TrayListProdutoIndividual->resource($_SESSION['access_token_tray'], $_REQUEST['id']);

            echo "
            <div class='col-md-3'>
            <label for='validationCustom01' class='form-label'>ID PRODUTO</label>
            <input type='text' class='form-control' name='id_produto' id='validationCustom01' value='{$_REQUEST['id']}' required>
            <div class='valid-feedback'>
                Digite o valor unitário
            </div>
            </div>
            
            
            <div class='col-md-6'>
                <label for='validationCustom01' class='form-label'>Titulo do Anunúcio</label>
                <input type='text' class='form-control' disabled name='name' id='validationCustom01' value='{$produto->Product->name}'placeholder='Iphone 6s apple..'>
                <div class='valid-feedback'>
                    Digite o Título do Anúncio
                </div>
            </div>

            

            <div class='col-md-2'>
                <label for='validationCustom01' class='form-label'>Valor Unitário</label>
                <input type='text' class='form-control' name='valor_unit' id='validationCustom01' value='{$produto->Product->price}'placeholder='12.99' required>
                <div class='valid-feedback'>
                    Digite o valor unitário
                </div>
            </div>
        
        
            <div class='col-md-2'>
                <label for='validationCustom01' class='form-label'>Preço de Custo</label>
                <input type='text' class='form-control' name='precocusto' id='validationCustom01' value='{$produto->Product->cost_price}'placeholder='10.99' required>
                <div class='valid-feedback'>
                    Digite o Preço de Custo
                </div>
            </div>

            <div class='col-md-2'>
                <label for='validationCustom05' class='form-label'>Estoque</label>
                <input type='number' class='form-control' name='estoque' value='{$produto->Product->stock}' id='validationCustom05' required>
                <div class='valid-feedback'>
                   Digite o estoque do produto
                </div>
            </div>

            
            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Ativo</label>
                <select class='form-select' name='condicao' id='validationCustom04'>
                    <option selected  value=''>Selecione..</option>
                    <option value='1'>Ativo</option>
                    <option value='0'>Inativo</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>
            
            <div class='col-md-4'>
                <label for='validationCustom05' class='form-label'>URL IMAGEM PRINCIPAL</label>
                <input type='text' class='form-control' name='url_img_principal'  placeholder='www.site.com.br/imagem.jpg' id='validationCustom05' >
                <div class='valid-feedback'>
                   Digite a url da imagem
                </div>
            </div>

            <!----->
            <div class='col-12'>
                <button class='btn btn-success' type='submit'>Atualizar</button>
            </div>
        </form>
    </div>";
            ?>
            <!-- Bootstrap Bundle with Popper -->

            <!------------------- CRIAÇÂO DA NOVA VARIACAO --------------->
            <script>
                //https://api.jquery.com/click/
                $("#ADD_VARIACAO").click(function() {
                    //https://api.jquery.com/append/
                    $("#form-variacao").append("<hr><div class='col-md-4'><label for='validationCustom05' class='form-label'>URL DA IMAGEM</label><input type='text' class='form-control' name='url_img_principal[]'  placeholder='www.site.com.br/imagem.jpg' id='validationCustom05' ><div class='valid-feedback'>Digite a url da imagem</div></div>");
                });
            </script>

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