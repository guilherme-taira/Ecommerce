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

        <a href='TelaAdicionarCategoriaTray.php?'><button class='btn btn-outline-success' type='button'>+ Adicionar Nova Categoria</button></a>

        <form class="row g-3 needs-validation mt-2" action="TrayCreateProduct.php" method="POST" novalidate>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Titulo do Anunúcio</label>
                <input type="text" class="form-control" name="name" id="validationCustom01" placeholder="Iphone 6s apple..">
                <div class="valid-feedback">
                    Digite o Título do Anúncio
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">EAN - GTIN</label>
                <input type="text" class="form-control" name="ean" id="validationCustom01" placeholder="78978985554">
                <div class="valid-feedback">
                    Digite o Título do Anúncio
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Valor Unitário</label>
                <input type="text" class="form-control" name="valor_unit" id="validationCustom01" placeholder="12.99">
                <div class="valid-feedback">
                    Digite o valor unitário
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Preço de Custo</label>
                <input type="text" class="form-control" name="precocusto" id="validationCustom01" placeholder="10.99">
                <div class="valid-feedback">
                    Digite o Preço de Custo
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Preço Pormocional</label>
                <input type="text" class="form-control" name="precopromocional" id="validationCustom01" placeholder="10.99">
                <div class="valid-feedback">
                    Digite o Preço Promocional
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Data Inicial Preço Pormocional</label>
                <input type="date" class="form-control" name="iniciopromocao" id="validationCustom01">
                <div class="valid-feedback">
                    Digite a data inicial da promoção
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Data Final Preço Pormocional</label>
                <input type="date" class="form-control" name="finalpromocao" id="validationCustom01">
                <div class="valid-feedback">
                    Digite a data Final da promoção
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Marca</label>
                <input type="text" class="form-control" name="marca" placeholder="Apple" id="validationCustom05">
                <div class="valid-feedback">
                    Data a Marca do Produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Modelo</label>
                <input type="text" class="form-control" name="modelo"  id="validationCustom05" >
                <div class="valid-feedback">
                   Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Peso</label>
                <input type="text" class="form-control" name="peso"  id="validationCustom05" >
                <div class="valid-feedback">
                   Digite o Peso do Produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Comprimento</label>
                <input type="text" class="form-control" name="comprimento"  id="validationCustom05" >
                <div class="valid-feedback">
                   Digite o comprimento do produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Largura</label>
                <input type="text" class="form-control" name="largura"  id="validationCustom05" >
                <div class="valid-feedback">
                   Digite a largura do produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Altura</label>
                <input type="text" class="form-control" name="altura"  id="validationCustom05" >
                <div class="valid-feedback">
                   Digite a altura do produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Estoque</label>
                <input type="number" class="form-control" name="estoque"  id="validationCustom05" >
                <div class="valid-feedback">
                   Digite o estoque do produto
                </div>
            </div>

            
            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Ativo</label>
                <select class='form-select' name='condicao' id='validationCustom04'>
                    <option selected  value=''>Selecione..</option>
                    <option selected  value='1'>Ativo</option>
                    <option selected  value='0'>Inativo</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>
            
            <div class="col-md-6">
                <label for="validationCustom05" class="form-label">Mensagem de Disponibilidade</label>
                <input type="text" class="form-control" name="msgdisponivel"  placeholder="Disponível em 3 dias.." id="validationCustom05" >
                <div class="valid-feedback">
                   Digite a mensagem de disponibilidade
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Dias de Disponibilidade</label>
                <input type="number" class="form-control" name="diadisponivel"  placeholder="3 dias" id="validationCustom05" >
                <div class="valid-feedback">
                   Digite dias para disponibilidade
                </div>
            </div>

            <div class="col-md-1">
                <label for="validationCustom05" class="form-label">Referência</label>
                <input type="text" class="form-control" name="referencia"  placeholder="993213" id="validationCustom05" >
                <div class="valid-feedback">
                   Digite a mensagem de disponibilidade
                </div>
            </div>

      
            <input type="hidden" class="form-control" name="botaoadicional" value="1" placeholder="993213" id="validationCustom05" >
            <input type="hidden" class="form-control" name="data_release" value="<?php echo date('Y-m-d');?>" placeholder="993213" id="validationCustom05" >
            <input type="hidden" class="form-control" name="virtualProduct" value="1" placeholder="993213" id="validationCustom05" >
  

            <?php
            include_once 'TrayListProduto.php';
            $ListCategoriaTray = new TrayListProduto;
            $categoria = $ListCategoriaTray->resource($_SESSION['access_token_tray'],8000);

            echo "
            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Categoria</label>
                <select class='form-select' name='categoria' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>";
                    foreach ($categoria->Categories as $categoria) {
                        echo "<option value='{$categoria->Category->id}'>{$categoria->Category->name}</option>";        
                    }
                echo "</select>
                <div class='invalid-feedback'>
                    Please select a valid state.
                </div>
            </div>";
            
            ?>

            <?php
            include_once 'TrayListProduto.php';
            $ListCategoriaTray2 = new TrayListProduto;
            $categoria2 = $ListCategoriaTray->resource($_SESSION['access_token_tray'],8000);

            echo "
            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Categoria Relacionada</label>
                <select class='form-select' name='categoriaRelacionada' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>";
                    foreach ($categoria2->Categories as $categoria) {
                        echo "<option value='{$categoria->Category->id}'>{$categoria->Category->name}</option>";        
                    }
                echo "</select>
                <div class='invalid-feedback'>
                    Please select a valid state.
                </div>
            </div>";
            ?>

            <div class="col-md-6">
                <label for="validationCustom05" class="form-label">URL IMAGEM PRINCIPAL</label>
                <input type="text" class="form-control" name="url_img_principal"  placeholder="www.site.com.br/imagem.jpg" id="validationCustom05" >
                <div class="valid-feedback">
                   Digite a url da imagem
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