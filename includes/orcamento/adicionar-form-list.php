<?php

use App\Entidy\Clientes;

if (isset($_GET['cliente_id'])) {
  $value = Clientes::getID('*', 'clientes', $_GET['cliente_id'], null, null);

  $cliente_id = $value->id;
  $cliente = $value->nome;
}

$list = '';

foreach ($listar as $item) {


  $list .= '
  <tr>
  <td>
  <div class="icheck-red ">
  <input type="checkbox" value="' . $item->id . '" name="all[]" id="[' . $item->id . ']">
  <label for="[' . $item->id . ']"></label>
  </div>
  </td>
  
  <td style="text-transform:uppercase; font-size:18px">' . $item->categoria . '</td>
  <td style="text-transform:uppercase; font-size:18px">' . $item->fabricante . '</td>
  <td style="text-transform:uppercase; font-size:18px">' . $item->veiculo . '</td>
  <td style="text-transform:uppercase; font-size:18px">' . substr($item->produto, 0, 20) . '</td>
  <td style="text-transform:uppercase; font-size:18px">' . $item->qtd . '</td>
  <td style="text-transform:uppercase; font-size:18px">' . $item->valor_venda . '</td>
  <td style="text-align:right; font-size:18px;color:#ff0000"><i class="fa fa-plus-circle" aria-hidden="true"></i></td>
 
  </tr>
  ';
}

?>

<div class="row" style="margin-top:10px">

  <!-- LISTA DE PRODUTOS -->

  <div class="col-2">


  </div>

  <!-- CAIXA -->

  <div class="col-8">


    <form method="get">
      <div class="card card-success">

        <div class="card-header">
          <h1 class="card-title"><span style="font-size: xx-large; font-weight:600;"> Listar Produtos </span></h1>

          <div class="card-tools">
            <span style="text-transform: uppercase;">
              <?php
              setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
              date_default_timezone_set('America/Sao_Paulo');
              echo strftime('%A, %d de %B de %Y', strtotime('today'));
              ?>
            </span>

          </div>
        </div>

        <div class="card-body">
          <div class="card-header">

            <div class="row ">
              <div class="col-3">
                <div class="form-group">
                  <label>Categorias</label>
                  <select class="form-control" style="width: 100%;" name="buscar2">
                    <option value=""> Selecione uma categoria </option>
                    <?php

                    foreach ($categorias as $item) {
                      echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                    }
                    ?>

                  </select>


                </div>

              </div>

              <div class="col-3">

                <div class="form-group">
                  <label>Fabricantes</label>
                  <select class="form-control select" style="width: 100%;" name="buscar3" id="fabric">
                    <option value=""> Selecione um fabricante </option>
                    <?php

                    foreach ($fabricantes as $item) {
                      echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                    }
                    ?>

                  </select>
                </div>


              </div>
              <div class="col-3">
                <label>Veiculos</label>
                <div class="form-group">
                  <select class="form-control" name="buscar5" id="vei"></select>

                </div>

              </div>
              <div class="col-3">
                <button style="margin-top: 30px;" type="submit" class="btn btn-warning" name="">
                  <i class="fas fa-search"></i>

                  Pesquisar

                </button>

              </div>


    </form>
  </div>
  <form id="form1" action="orcamento-adicionar.php" method="post">
    <div class="tab-content p-0 direct-chat-messages" style="height: 300px;">
      <table class="table table-hover table-striped table-sm">
        <thead>
          <tr>
            <th>
              <input type="hidden" value="<?= $cliente_id  ?>" name="cliente_id">
              <div class="icheck-warning d-inline">
                <input type="checkbox" id="select-all">
                <label for="select-all">
                </label>
              </div>

            </th>

            <th style="text-align:left; width:220px"> CATEGORIA </th>
            <th style="text-align:left; width:220px"> FABRICANTE </th>
            <th style="text-align:left; width:220px"> VEÍCULO </th>
            <th style="text-align:left; width:220px"> PRODUTO </th>
            <th style="text-align:left; width:220px"> QTD </th>
            <th style="text-align:left; width:220px"> VALOR </th>
            <th style="text-align:right;width:220px"> AÇÕES </th>

          </tr>
        </thead>
        <tbody>

          <?= $list; ?>


        </tbody>


      </table>


    </div>


</div>
<div class="card-header">
  <button type="submit" name="submit" class="btn btn-flat btn-danger "> <i class="fas fa-chevron-left"></i> &nbsp; Adicionar todos</button>
</div>

</div>
</form>


</div>
<!-- FIM -->
</div>
</div>