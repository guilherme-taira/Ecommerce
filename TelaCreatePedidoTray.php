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

        <form class="row g-3 needs-validation mt-2" action="TrayCreatePedido.php" method="POST" novalidate>
            <div class="col-md-3">
                <label for="validationCustom01" class="form-label">Local da Venda</label>
                <input type="text" class="form-control" name="localVenda" id="validationCustom01" placeholder="Iphone 6s apple..">
                <div class="valid-feedback">
                    Digite o Título do Anúncio
                </div>
            </div>


            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Tipo de Frete</label>
                <select class='form-select' name='tipofrete' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <option  value='UELLO'>Uello</option>
                    <option  value='Sedex'>Sedex</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Valor do Frete</label>
                <input type="text" class="form-control" name="valorfrete" id="validationCustom01" placeholder="12.99">
                <div class="valid-feedback">
                    Digite o valor unitário
                </div>
            </div>

            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Forma de Pagamento</label>
                <select class='form-select' name='formpagamento' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <option  value='Boleto'>Boleto</option>
                    <option  value='Cartao'>Cartão</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>

            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Tipo de Cliente</label>
                <select class='form-select' name='tipocliente' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <option  value='0'>Física</option>
                    <option  value='1'>Jurídica</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>


            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Nome do Cliente *</label>
                <input type="text" class="form-control" name="nomecliente" id="validationCustom01" placeholder="João maria dos santos">
                <div class="valid-feedback">
                    Digite o Preço Promocional
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">CPF / CNPJ *</label>
                <input type="text" class="form-control" name="cnpj" id="validationCustom01" placeholder="322135454444">
                <div class="valid-feedback">
                    Digite a data inicial da promoção
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom01" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="validationCustom01">
                <div class="valid-feedback">
                    Digite a data Final da promoção
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">RG</label>
                <input type="text" class="form-control" name="rg" placeholder="00.000.000-X" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o RG por favor!
                </div>
            </div>

            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Genero</label>
                <select class='form-select' name='genero' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <option  value='0'>Masculino</option>
                    <option  value='1'>Feminino</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="telefone" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-6">
                <label for="validationCustom05" class="form-label">Endereço</label>
                <input type="text" class="form-control" name="endereco" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Cep</label>
                <input type="text" class="form-control" name="cep" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Número</label>
                <input type="text" class="form-control" name="numero" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Complemento</label>
                <input type="text" class="form-control" name="complemento" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Bairro</label>
                <input type="text" class="form-control" name="bairro" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o modelo do produto
                </div>
            </div>

            <div class='col-md-2'>
                <label for='validationCustom04' class='form-label'>Estado</label>
                <select class='form-select' name='estado' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>

            <div class="col-md-2">
                <label for="validationCustom05" class="form-label">País</label>
                <input type="text" class="form-control" name="pais" id="validationCustom05">
                <div class="valid-feedback">
                    Digite o Páis por favor!
                </div>
            </div>

            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Tipo de Endereço</label>
                <select class='form-select' name='tipoentrega' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <option selected value='0'>Endereço de Cobrança</option>
                    <option selected value='1'>Endereço de Entrega</option>
                    <option selected value='1'>Endereço do Tipo Lista de Presente</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>

            <!--- Chamada da api para pesquisar produto -->
            
            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Produto</label>
                <select class='form-select' name='produto' id='validationCustom04'>
                    <option selected value=''>Selecione..</option>
                    <?php
                    include_once 'TrayProdutosGet.php';
               
                    $GetProdutos = new GetProdutos;
                    $produtos = (object) $GetProdutos->resource($_SESSION['access_token_tray']);
                    echo "<pre>";
                    foreach ($produtos->Products as $product) {
                        //print_r($product);
                        echo "<option value='{$product->Product->id}'>{$product->Product->name}</option>";
                   }
                    ?>
                </select>
                <div class='invalid-feedback'>
                    Selecione a Condição do Produto
                </div>
            </div>


            <div class="col-md-1">
                <label for="validationCustom05" class="form-label">Quantidade</label>
                <input type="number" class="form-control" name="quantidade" id="validationCustom05">
                <div class="valid-feedback">
                    Digite a largura do produto
                </div>
            </div>

            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Local MarketPlace</label>
                <input type="text" class="form-control" name="localmarketplace" id="validationCustom05">
                <div class="valid-feedback">
                    Digite a largura do produto
                </div>
            </div>

            <input type="hidden" class="form-control" name="marketplace_seller_name" value="1234567890" placeholder="993213" id="validationCustom05">
            <input type="hidden" class="form-control" name="marketplace_seller_id" value="273480425" placeholder="993213" id="validationCustom05">
            <input type="hidden" class="form-control" name="marketplace_document" value="1" placeholder="0000000000000" id="validationCustom05">
            <input type="hidden" class="form-control" name="payment_responsible_document" value="0000000000000" placeholder="993213" id="validationCustom05">
            <input type="hidden" class="form-control" name="marketplace_order_id" value="4429804558" placeholder="4429804558" id="validationCustom05">
            <input type="hidden" class="form-control" name="marketplace_shipping_id" value="40457395268" placeholder="40457395268" id="validationCustom05">
            <input type="hidden" class="form-control" name="marketplace_shipping_type" value="me2" placeholder="me2" id="validationCustom05">
            <input type="hidden" class="form-control" name="marketplace_internal_status" value="shipping" placeholder="me2" id="validationCustom05">
            
            <div class="col-md-6">
                <label for="validationCustom05" class="form-label">URL IMAGEM PRINCIPAL</label>
                <input type="text" class="form-control" name="url_img_principal" placeholder="www.site.com.br/imagem.jpg" id="validationCustom05">
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