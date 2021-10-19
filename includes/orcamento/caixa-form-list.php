<?php

use App\Entidy\Clientes;
use App\Entidy\Produto;

if (isset($_GET['cliente_id'])) {
  $value = Clientes::getID('*', 'clientes', $_GET['cliente_id'], null, null);

  $cliente_id = $value->id;
  $cliente = $value->nome;
}

?>

<div class="row" style="margin-top:10px">

  <!-- LISTA DE PRODUTOS -->

  <div class="col-2">


  </div>

  <!-- CAIXA -->

  <div class="col-8">
    <?php

     //VOLTAR PARA PAGINA ANTERIOR SEM PERDER O ID DA SESSÃO
    $previous = "javascript:history.go(-1)";
    if (isset($_SERVER['HTTP_REFERER'])) {
      $previous = $_SERVER['HTTP_REFERER'];
    }

    $_SESSION['orcamentos-venda'] = array();

    $listItem = '';
    $total = 0;
    $total1 = 0;
    $total2 = 0;
    $valor = 0;
    $porcentagem = 0;
    $porcento = 0;
    $valor_porcento = 0;

    $codigo = substr(uniqid(rand()), 0, 6);

    foreach ($_SESSION['carrinho2'] as $id => $qtd) {

      if (isset($_POST['porcent'][$id])) {

        $porcento = $_POST['porcent'][$id];
      }

      if ($porcento != null) {

        $item = Produto::getID('*', 'produtos', $id, null, null);

        $valor1 = $item->valor_venda;

        $valor2 = str_replace(".", ",", $valor1);

        $nome = $item->nome;

        $valor_porcento  = $qtd * $valor1;

        $sub  = $valor_porcento  - ($valor_porcento  * $porcento / 100);

        $total += $sub;
      } else {

        $item = Produto::getID('*', 'produtos', $id, null, null);

        $valor1 = $item->valor_venda;

        $valor2 = str_replace(".", ",", $valor1);

        $nome = $item->nome;

        $sub = $qtd * $valor1;

        $total += $sub;
      }

      $listItem .= '
            <tr>
            <td style="text-transform:uppercase; font-size:small">' . $nome . '</td>
            <td style="width:80px">
            <input type="text" size="1" name="prod[' . $id . ']" value="' . $qtd . '" style="width:50px" />
            </td>
            
            <td style="width:150px">R$
            <input type="text" size="2" id="dinheiro2" name="val[' . $id . ']" value="' . $valor2 . '" />
            </td>
            <td style="text-align:left">
            <select name="porcent[' . $id . ']">
            <option value=""></option>
            <option value="5">5%</option>
            <option value="10">10%</option>
            <option value="15">15%</option>
            <option value="20">20%</option>
          </select>
          
          </td>
            <td> R$ ' . number_format($sub, "2", ",", ".") . '</td>
            <td style="text-align:right">
            <button type="submit"><i class="fas fa-pen"></i></button>
            &nbsp;&nbsp;
            <a href="?acao=del&id=' . $id . '"
            <i class="fas fa-times" style="color:#ff0000"></i>
            </a></td>
            </tr>
            ';

      array_push(
        $_SESSION['orcamentos-venda'],

        array(
          'nome'         => $nome,
          'codigo'       => $codigo,
          'qtd'          => $qtd,
          'valor_venda'  => $valor1,
          'subtotal'     => $sub,
          'desconto'     => $porcento,
          'produtos_id'  => $id



        )
      );
    }

    ?>


    <div class="card card-danger">
      <div class="card-header">
        <h1 class="card-title"><span style="font-size: xx-large; font-weight:600;">R$ &nbsp;

            <?= number_format($total, "2", ",", ".") ?>

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

        <div class="tab-content p-0 direct-chat-messages" style="height: 200px;">
          <form action="?acao=up" method="post">
            <table class="table table-hover table-dark table-striped table-sm">
              <thead>
                <tr>
                  <th style="text-align:left; width:220px"> PRODUTO </th>
                  <th> QTD </th>
                  <th style="text-align:left"> VALOR </th>
                  <th style="text-align:center"> DES % </th>
                  <th> SUBTOTAL </th>
                  <th style="width:100px;text-align:right"> AÇÕES </th>
                </tr>
              </thead>
              <tbody>

                <?= $listItem ?>

              </tbody>
            </table>
          </form>

        </div>

        <hr>
        <form action="orcamento-insert.php" method="post">

          <div class="row">

            <div class="col-4">

              <input style="background-color:#313031;color:#fff; font-size:x-large" type="text" class="form-control" name="receber" id="dinheiro" placeholder="R$ 0,00">

            </div>

            <div class="col-8">
              <textarea class="form-control" rows="3" placeholder="Observeções" name="obs"></textarea>
            </div>



          </div>

          <div class="row">


            <div class="col-4">
              <a href="<?= $previous ?>" class="btn btn-primary btn-block " style="margin-top: 13px;">
                <span style="font-size: 21px;">ADD PRODUTOS</span>
              </a>


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