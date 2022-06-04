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

    <div class="container-fluid mt-4" id="form-variacao">

        <a href='TelaCreateNotaFiscal.php?'><button class='btn btn-outline-success' type='button'>+ Cadastrar Nova Nota Fiscal</button></a>

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




        echo "<table class='table'>
            <thead>
            <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Número do Pedido</th>
                <th scope='col'>Data</th>
                <th scope='col'>Número</th>
                <th scope='col'>Serie</th>
                <th scope='col'>Valor</th>
                <th scope='col'>Chave</th>
                <th scope='col'>Link</th>
            </tr>
            </thead>
            <tbody>
            <tr>";
            include_once 'TrayNotasFiscal.php';

            $GetNotasFiscais = new GetNotasFiscais($_SESSION['access_token_tray'],$page);
            $NotaFiscal = $GetNotasFiscais->resource();
            //print_r($NotaFiscal);

            // INSTANCIA DO OBJETO DA CLASSE

            if (intval($NotaFiscal->paging->total) <= intval($NotaFiscal->paging->offset)) {
                echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                <a href='TelaListNotaFiscal.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
                <a href='TelaListNotaFiscal.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
                </div>";
            }else if (intval($NotaFiscal->paging->offset) == 0) {
                echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                <a href='TelaListNotaFiscal.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
                <a href='TelaListNotaFiscal.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
                </div>";
            }else {
                echo "<div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                <a href='TelaListNotaFiscal.php?page=" . voltaPagina($page) . "'><button class='btn btn-outline-warning' type='button'>Voltar</button></a>
                <a href='TelaListNotaFiscal.php?page=" . avancaPagina($page) . "'><button class='btn btn-outline-success' type='button'>Próxima</button></a>
                <a href='TelaListNotaFiscal.php?".limpaFiltros()."'><button class='btn btn-outline-danger' type='button'>Limpar Filtros</button></a>
                </div>";
            }

            foreach ($NotaFiscal->OrderInvoices as $NotaFiscal) {
                echo "<tr>";
                echo "<td>{$NotaFiscal->OrderInvoice->id}</td>";
                echo "<td><a href='TelaNotaFiscalIndividual.php?orderid={$NotaFiscal->OrderInvoice->order_id}&invoice={$NotaFiscal->OrderInvoice->id}'>{$NotaFiscal->OrderInvoice->order_id}</a></td>";
                echo "<td>{$NotaFiscal->OrderInvoice->issue_date}</td>";
                echo "<td>{$NotaFiscal->OrderInvoice->number}</td>";
                echo "<td>{$NotaFiscal->OrderInvoice->serie}</td>";
                echo "<td>{$NotaFiscal->OrderInvoice->value}</td>";
                echo "<td>{$NotaFiscal->OrderInvoice->key}</td>";
                echo "<td>{$NotaFiscal->OrderInvoice->link}</td>";
                echo "</tr>";
            }
    echo "
      </tr>
    </tbody>";
    

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
    <!---------------------- -->
    <!----->
    <div class="col-12 mt-4">
        <button class="btn btn-success" type="submit">Pesquisar</button>
    </div>
    <hr>
    </form>
    </div>
    </div>

    <!------------------- CRIAÇÂO DA NOVA VARIACAO --------------->
    <script>
        //https://api.jquery.com/click/
        $("#ADD_VARIACAO").click(function() {
            //https://api.jquery.com/append/
            $("#form-variacao").append('<hr><div class="container mt-4"><div class="col-md-1"> <label for="validationCustom05" class="form-label">ID</label> <input type="text" class="form-control" name="VariantId" placeholder="993213" id="validationCustom05" > <div class="valid-feedback"> Digite a mensagem de disponibilidade </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">EAN - GTIN</label> <input type="text" class="form-control" name="VariantEan" placeholder="789987511452" id="validationCustom05" > <div class="valid-feedback"> Digite o ean da variação </div> </div> <input type="hidden" class="form-control" name="VariantOrder" value="1" placeholder="993213" id="validationCustom05" > <div class="col-md-2"> <label for="validationCustom05" class="form-label">Preço</label> <input type="text" class="form-control" name="VariantPreco" placeholder="19.90" id="validationCustom05" > <div class="valid-feedback"> Digite o ean da variação </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Preço de Custo</label> <input type="text" class="form-control" name="VariantPrecoCusto" placeholder="19.90" id="validationCustom05" > <div class="valid-feedback"> Digite o preço de Custo da variação </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Estoque do Produto</label> <input type="text" class="form-control" name="VariantEstoque" placeholder="100" id="validationCustom05" > <div class="valid-feedback"> Digite o Estoque do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Estoque Mínimo</label> <input type="text" class="form-control" name="VariantEstoqueMinimo" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite o Estoque Minimo do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Referência</label> <input type="text" class="form-control" name="VariantReferencia" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Referencia do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Referência</label> <input type="text" class="form-control" name="VariantReferencia" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Referencia do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Peso (Gramas)</label> <input type="text" class="form-control" name="VariantPeso" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite o peso do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Comprimento (Centímetros)</label> <input type="text" class="form-control" name="VariantComprimento" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite o comprimento do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Largura (Centímetros)</label> <input type="text" class="form-control" name="VariantLargura" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a largura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Altura (Centímetros)</label> <input type="text" class="form-control" name="VariantAltura" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Começo da Promoção</label> <input type="date" class="form-control" name="VariantStartPromocao" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Fim da Promoção</label> <input type="date" class="form-control" name="VariantEndPromocao" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Fim da Promoção</label> <input type="date" class="form-control" name="VariantStartPromocao" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Preço de Promoção</label> <input type="text" class="form-control" name="VariantPrecoPromocao" placeholder="1" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Cor</label> <input type="text" class="form-control" name="VariantCorValue" placeholder="Vermelho" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Tamanho</label> <input type="text" class="form-control" name="VariantTamanhoValue" placeholder="23" id="validationCustom05" > <div class="valid-feedback"> Digite a Altura do produto </div> </div> <div class="col-md-2"> <label for="validationCustom05" class="form-label">Estoque da Variação</label> <input type="text" class="form-control" name="VariantEstoque" placeholder="23" id="validationCustom05"> <div class="valid-feedback"> Digite o estoque da variação </div></div>');
        });
    </script>

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