<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Clientes;
use App\Entidy\Orcamento;
use App\Entidy\Produtotemp;
use \App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuarios_nome = $usuariologado['nome'];
$usuarios_email = $usuariologado['email'];

Login::requireLogin();

$desc = 0;
$sub = 0;

$result = "";

$codigo = substr(uniqid(rand()), 0, 6);

$total_venda = 0;
$total_desconto = 0;
$troco = 0;
$desconto = 0;
$subtotal_desconto = 0;
if (isset($_SESSION['orcamentos-clientes'])) {
    foreach ($_SESSION['orcamentos-clientes'] as $item) {
    
        $cliente_id           = $item['cliente_id'];
        $cliente_nome         = $item['cliente_nome'];
    }
   

}

if (isset($_SESSION['orcamentos-venda'])) {

    foreach ($_SESSION['orcamentos-venda'] as $item) {
        $produto            = $item['nome'];
        $codigo_prod        = $item['codigo'];
        $produtos_id        = $item['produtos_id'];
        $qtd                = $item['qtd'];
        $desconto           = $item['desconto'];
        $uni                = $item['valor_venda'];
        $subtotal           = $item['subtotal'];
       
        $sub_venda          = ($qtd *  $uni);


        $subtotal_desconto  = $sub_venda - ($sub_venda * intval($desconto)  / 100);


        $total_venda += $subtotal_desconto;

        if ($desconto == null) {
            $desc = "Nenhum";
        } else {
            $desc = intval($desconto) . " %";

            $total_desconto += intval($desc);
        }

        $result .= '
        <tr>
        <td style="font-size:xx-small">'.$produto.' </td>
        <td style="font-size:xx-small">'.$qtd.' </td>
        <td style="font-size:xx-small"> R$ '.number_format($uni,"2",",",".").' </td>
        <td style="font-size:xx-small; text-align:right"> '.$desc.' </td>
        <td style="font-size:xx-small; text-align:right"> R$ '.number_format($subtotal_desconto,"2",",",".").' </td>
        </tr>
    ';

    $item = new Produtotemp;

    $item->qtd                   = $qtd;
    $item->valor                 = $uni;
    $item->codigo                = $codigo;
    $item->subtotal              = $subtotal ;
    $item->desconto              = $desconto;
    $item->produtos_id           = $produtos_id;
    $item->clientes_id           = $cliente_id;
    $item->forma_pagamento_id    = 2;
    $item->cadastar();

    }

    $item = new Orcamento;

    $item->codigo                = $codigo;
    $item->qtd                   = $qtd;
    $item->valor                 = $uni;
    $item->clientes_id           = $cliente_id;
    $item->forma_pagamento_id    = 2;
    $item->status                = 1;
    $item->cadastar();
}

$clientes   = Clientes :: getID('*','clientes', $cliente_id,null,null);

$clienteId = $clientes->id;
$clienteNome = $clientes->nome;
$clienteEmail = $clientes->email;
$clienteTelefone = $clientes->telefone;
$clienteLogradouro = $clientes->logradouro;
$clienteBairro = $clientes->bairro;
$clienteNumero = $clientes->numero;
$clienteLocalidade = $clientes->localidade;
$clienteUF = $clientes->uf;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem de servi??o</title>
    <style>
      @page {
            margin: 50px 5;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
           
        }

        .header {
            position: fixed;
            top: -70px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            background-color: #555555;
            padding: 10px;
            
        }
    </style>
</head>
<body>

<table style="margin-top: -60px;width: 100%;">
        <tbody>
            <tr style="background-color:#fff;">
               
                <td style="text-align:center;"><img src="../../01.png" style="width: 160px; height:57px;"></td>
               
            </tr>

        </tbody>
</table>
<hr>
<table style="margin-top:0px; width: 100%;">
        <tbody>
            <tr style="color:#000">
                <td style="text-align: left;  font-size: xx-small;">Cliente: <?= $clienteNome ?></td>
                <td style="text-align: center;  font-size: xx-small;">Contato: <?= $clienteTelefone ?></td>
                <td style="text-align: right;  font-size: xx-small;"><span style="font-size: 14px; font-weight: unset;">N?? : <?= $codigo ?></span></td>
            </tr>
            <tr style="color:#000">
                
                <td style="text-align: left; font-size: xx-small;" colspan="3">Email: <?= $clienteEmail ?></td>
            </tr>
            <tr style="color:#000">
                <td style="text-align: left;  font-size: xx-small;" colspan="3">Endere??o: </span>&nbsp; <?= $clienteLogradouro ?> &nbsp; N?? <?= $clienteNumero ?> &nbsp; <?= $clienteBairro ?>
                  &nbsp; <?= $clienteLocalidade ?> &nbsp; - <?= $clienteUF ?></td>
               
            </tr>
         

        </tbody>
</table>



<table style="margin-top:0px; width: 100%; font-size: x-small;">
            <thead>
            <tr>
            <th style="text-align: left; border: 1px solid #000; font-size:xx-small">PRODUTO(S)</th>
            <th style="text-align: left; border: 1px solid #000;font-size:xx-small">QTD</th>
            <th style="text-align: left; border: 1px solid #000;font-size:xx-small">UNI</th>
            <th style="text-align: left; border: 1px solid #000;font-size:xx-small">DESC(S)</th>
            <th style="text-align: right; border: 1px solid #000;font-size:xx-small">SUBTOTAL</th>
            </tr>

            </thead>
            <tbody>

            <?= $result; ?>

            <tr>
            <td colspan="3" style="font-size:xx-small">TOTAL</td>
            <td style="font-size:xx-small;text-align:right"><?= $total_desconto  ?> %</td>
            <td style="font-size:xx-small;text-align:right">R$ <?= number_format($total_venda, "2", ",", ".")  ?></td>

            </tr>

            </tbody>
</table>

</body>
</html>

<?php

unset($_SESSION['orcamentos-venda']);
unset($_SESSION['orcamentos-clientes']);
unset($_SESSION['carrinho2']);

?>