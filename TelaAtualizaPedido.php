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

        <form class="row g-3 needs-validation mt-2" action="TrayPutPedido.php" method="POST" novalidate>
            <?php

            echo "
            <div class='col-md-3'>
            <label for='validationCustom01' class='form-label'>ID PRODUTO</label>
            <input type='text' class='form-control' name='id_pedido' id='validationCustom01' value='{$_REQUEST['id']}' required>
            <div class='valid-feedback'>
                Digite o valor unitário
            </div>
            </div>
            
            <div class='col-md-1'>
                <label for='validationCustom01' class='form-label'>Taxas</label>
                <input type='text' class='form-control' name='Taxas' id='validationCustom01' placeholder='1.39'>
                <div class='valid-feedback'>
                    Digite o Título do Anúncio
                </div>
            </div>

            <div class='col-md-3'>
                <label for='validationCustom04' class='form-label'>Tipo de Frete</label>
                <select class='form-select' name='tpFrete' id='validationCustom04'>
                    <option selected  value=''>Selecione..</option>
                    <option  value='Sedex'>Sedex</option>
                    <option  value='UELLO'>Uello Rápido</option>
                    <option  value='Mandae'>Mandaê</option>
                </select>
                <div class='invalid-feedback'>
                    Selecione o tipo de Transporte
                </div>
            </div>


            <div class='col-md-2'>
                <label for='validationCustom01' class='form-label'>Valor do Frete</label>
                <input type='text' class='form-control' name='valor_frete' id='validationCustom01' placeholder='12.99' required>
                <div class='valid-feedback'>
                    Digite o valor unitário
                </div>
            </div>
        
            <div class='col-md-2'>
                <label for='validationCustom01' class='form-label'>Desconto</label>
                <input type='text' class='form-control' name='desconto' id='validationCustom01'placeholder='10.99' required>
                <div class='valid-feedback'>
                    Digite o Preço de Custo
                </div>
            </div>

            <div class='col-md-2'>
                <label for='validationCustom05' class='form-label'>Código de Envio</label>
                <input type='text' class='form-control' name='codEnvio' id='validationCustom05' placeholder='12313245454' required>
                <div class='valid-feedback'>
                   Digite o estoque do produto
                </div>
            </div>

            <div class='col-md-2'>
                <label for='validationCustom05' class='form-label'>Data de Envio</label>
                <input type='date' class='form-control' name='dataEnvio' id='validationCustom05' required>
                <div class='valid-feedback'>
                Digite o estoque do produto
                </div>
            </div>

            <div class='col-md-2'>
                <label for='validationCustom05' class='form-label'>Código do Parceiro</label>
                <input type='number' class='form-control' name='parceiroCod' id='validationCustom05' placeholder='3233'>
                <div class='valid-feedback'>
                Digite o codigo do parceiro
                </div>
            </div>

            <div class='col-md-3'>
            <label for='validationCustom04' class='form-label'>Tipo de Frete</label>
            <select class='form-select' name='Status' id='validationCustom04'>
                <option selected  value=''>Selecione..</option>
                <option  value='124117'>Entregue</option>
                <option  value='124113'>Aguarando Pagamento</option>
                <option  value='124009'>Em Transito</option>
                <option  value='124141'>Enviado</option>
                <option  value='124123'>Aprovado</option>
                <option  value='124255'>A ENVIAR YAPAY</option>
                <option  value='124313'>AGUARDANDO ENVIO</option>
            </select>
            <div class='invalid-feedback'>
                Selecione o tipo de Transporte
            </div>
        </div>
            
            <div class='mb-3'>
            <label for='validationTextarea' class='form-label'>Observação do Pedido</label>
            <textarea class='form-control is-invalid' id='validationTextarea' name='observacao' placeholder='Observação do pedido' required></textarea>
            <div class='invalid-feedback'>
               Insira a observação do pedido.
            </div>
          </div>

            <!----->
            <div class='col-12'>
                <button class='btn btn-success' type='submit'>Atualizar</button>
            </div>
        </form>
    </div>";

    
    //*****TABELA DE PEDIDOS STATUS ****//
// 124117 -> ENTREGUE
// 124113 -> AGUARDANDO PAGAMENTO
// 124009 -> EM TRANSITO
// 124141 -> ENVIADO
// 124123 -> APROVADO


// "Order": {
//     "status": "A ENVIAR YAPAY",
//     "id": "1301773",
//     "date": "2022-01-07",
//     "customer_id": "1293",
//     "partial_total": "36.67",
//     "taxes": "0.00",
//     "discount": "0.00",
//     "point_sale": "LOJA VIRTUAL",
//     "shipment": "Uello",
//     "shipment_value": "0.00",
//     "shipment_date": "2022-01-07",
//     "store_note": "ENVIAR ",
//     "discount_coupon": "",
//     "payment_method_rate": "0.00",
//     "value_1": "0.00",
//     "payment_form": "Boleto - Yapay",
//     "sending_code": "UELLO434324",
//     "session_id": "lh9oobnff57pio1imjk85gka76",
//     "total": "36.67",
//     "payment_date": "2022-01-07",
//     "access_code": "D39481567698FE3",
//     "progressive_discount": "0.00",
//     "shipping_progressive_discount": "0.00",
//     "shipment_integrator": "UELLO",
//     "modified": "2022-01-07 09:53:54",
//     "printed": "",
//     "interest": "0.00",
//     "cart_additional_values_discount": "0.00",
//     "cart_additional_values_increase": "0.00",
//     "id_quotation": "1111",
//     "estimated_delivery_date": "2022-01-07",
//     "external_code": "",
//     "has_payment": "1",
//     "has_shipment": "1",
//     "has_invoice": "0",
//     "total_comission_user": "0.00",
//     "total_comission": "0.00",
//     "is_traceable": "",
//     "OrderStatus": {
//         "id": "124255",
//         "default": "1",
//         "type": "open",
//         "show_backoffice": "1",
//         "allow_edit_order": "1",
//         "description": "",
//         "status": "A ENVIAR YAPAY",
//         "show_status_central": "",
//         "background": "",
//         "display_name": "A ENVIAR YAPAY",
//         "font_color": ""
//     },

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