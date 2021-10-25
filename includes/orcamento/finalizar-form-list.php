<?php

use App\Entidy\Clientes;

if (isset($_GET['cliente_id'])) {
  $value = Clientes::getID('*', 'clientes', $_GET['cliente_id'], null, null);

  $cliente_id = $value->id;
  $cliente = $value->nome;
}

$list = '';

$texto = '';

$total = 0;

foreach ($listar as $item) {

  $total += $item->subtotal;

  switch ($item->desconto) {
    case '0':
      $texto = "Nenhum";
      break;

    default:
      $texto = $item->desconto;
      break;
  }

  $list .= '
  <tr>
  <td style="display:none">' . $item->id  . '</td>
  <td style="display:none">' . $item->produtos_id . '</td>
  <td style="display:none">' . $item->codigo . '</td>
  <td style="display:none">' . $item->qtd  . '</td>
  <td style="display:none">' . $item->subtotal  . '</td>
  <td style="display:none">' . $item->desconto  . '</td>
  <td style="display:none">' . $item->produto . '</td>
  <td style="text-transform:uppercase; font-size:18px">' . $item->produto . '</td>
  <td style="text-transform:uppercase; width:100px;text-align:center">' . $item->qtd . '</td>
  <td style="text-transform:uppercase; font-size:18px;width:100px;text-align:center">' . $texto . '</td>
  <td style="text-transform:uppercase; width:80px;text-align:center">R$ ' . number_format($item->valor, "2", ",", ".") . '</td>
  <td style="text-transform:uppercase; font-size:18px;width:80px; text-align:right">R$ ' . number_format($item->subtotal, "2", ",", ".") . '</td>
  <td style="font-size:18px;text-align:right;width:100px;">
  <a href="orcamento-finalizar.php?acao=del&produtos_id=' . $item->id . '">
  <i class="fa fa-trash" aria-hidden="true"></i>
  </a>
  
  </td>
 
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
    <?php

    ?>


    <div class="card card-success">
      <div class="card-header">
        <h1 class="card-title"><span style="font-size: xx-large; font-weight:600;"> R$ <?= number_format($total,"2",",",".") ?>



          </span></h1>

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

        <div class="row">
          <div class="col-4"><span style="font-size: 18px;">Cliente: <?= $nome ?></span></div>
          <div class="col-4"><span style="font-size: 18px; text-align:left">Email: <?= $email ?></span></div>
          <div class="col-4" style="text-align: left;"><span style="font-size: 18px;">Telefone: <?= $telefone ?></span></div>

        </div>

        <div class="row">

          <div class="col-12"><span style="font-size: 18px;">Endereço: <?= $logradouro ?> Nº <?= $numero ?> , <?= $bairro ?> &nbsp <?= $localidade ?> - <?= $uf ?></span></div>

        </div>
        <br>


        <div class="tab-content p-0 direct-chat-messages" style="height: 200px;">
          <form action="?acao=up" method="post">
            <table class="table table-hover table-striped table-sm">
              <thead>
                <tr>
                  <th style="text-align:left; width:220px"> PRODUTO </th>
                  <th style="text-align:center"> QTD </th>
                  <th style="text-align:center"> DESCONTO % </th>
                  <th style="text-align:center"> VALOR </th>
                  <th style="text-align:right"> SUBTOTAL </th>
                  <th style="width:100px;text-align:right"> AÇÕES </th>
                </tr>
              </thead>
              <tbody>

                <?= $list; ?>


              </tbody>
              <tr>
                  <td style="text-align:right;font-size:18px; font-weight: 700;" colspan="4"> TOTAL </td>
                  <td style="text-align:right;font-size:18px;font-weight: 700;" colspan="1">R$ <?= number_format($total,"2",",",".") ?></td>
                  <td style="text-align:left;" colspan="1"></td>
                
                
                </tr>
            </table>
          </form>

        </div>

        <hr>
        <form action="orcamento-insert.php" method="post">

          <div class="row">

            <div class="col-4">

              <input style="background-color:#313031;color:#fff; font-size:x-large" type="text" class="form-control" name="receber" id="dinheiro" placeholder="R$ 0,00">

            </div>
            <div class="col-4">

            <div class="form-group">
                             
                              <select class="form-control" style="width: 100%;" name="buscar3">
                                 <option value=""> FORMA DE PAGAMENTO</option>
                                 <?php

                                 foreach ($pagamentos  as $item) {
                                    echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                                 }
                                 ?>

                              </select>


                           </div>

            </div>

            <div class="col-4">
              <textarea class="form-control" rows="3" placeholder="Observeções" name="obs"></textarea>
            </div>



          </div>

          <div class="row">


            <div class="col-4">
              <a href="orcamento-adicionar.php?cliente_id=<?= $id_cliente ; ?>" class="btn btn-primary btn-block " style="margin-top: 13px;">
                <span style="font-size: 21px;">ADD PRODUTOS</span>
              </a>
              <a href="orcamento-finalizar.php?acao=del&produtos_id=' . $item->id . '">

            </div>
            <div class="col-4">
              <a href="gerar-ordem.php" class="btn btn-danger btn-block " style="margin-top: 13px;" target="_blank">
                <span style="font-size: 21px;">ORDEM DE SERVIÇO</span>
              </a>

            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-warning btn-lg btn-block" style="margin-top: 10px;">ENVIAR</button>

            </div>


        </form>

      </div>


    </div>


  </div>
  <!-- FIM -->
</div>
</div>