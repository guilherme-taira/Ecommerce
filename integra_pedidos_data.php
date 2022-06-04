<!DOCTYPE html>
<html lang="en">
<?php
include_once 'Partials/_header.php';
?>

<body>

<?php
include_once 'Partials/_navbar.php';
?>
<div class="container-md mt-4">
<img src="shopee-logo.png" id="logo_shopee" alt="logo shoppe">
<form action="recebe_pedidos.php" method="POST">
  
        <p class="h5 mt-4">Coloque a data para filtrar os Clientes</p>

        <label> Data Inicial </label>
        <div class="input-group date" data-provide="datepicker">
            <input type="date" class="form-control" name="data_inicial" required>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>

        <label> Data Final </label>
        <div class="input-group date" data-provide="datepicker">
            <input type="date" class="form-control" name="data_final" required>
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
        <br>
        
        <input type="hidden" name="pagina" class="form-control" value='1'>

        <input type="submit" value="Pesquisar" class="btn btn-success mt-2">
    </form>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
   