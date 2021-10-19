<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Usuário');
define('BRAND','Cadastrar Usuário');

use App\Entidy\Orcamento;
use App\Entidy\Produtotemp;
use App\Session\Login;

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if (isset($_SESSION['orcamentos-clientes'])) {

    foreach ($_SESSION['orcamentos-clientes'] as $item) {

        $cliente_id           = $item['cliente_id'];
    }

}

if (isset($_SESSION['orcamentos-venda'])) {

    foreach ($_SESSION['orcamentos-venda'] as $item) {

        $nome             = $item['nome'];
        $codigo           = $item['codigo'];
        $valor_venda      = $item['valor_venda'];
        $qtd              = $item['qtd'];
        $subtotal         = $item['subtotal'];
        $desconto         = $item['desconto'];
        $produtos_id      = $item['produtos_id'];

        $item = new Produtotemp;

        $item->qtd                   = $qtd;
        $item->valor                 = $valor_venda;
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
    $item->valor                 = $valor_venda;
    $item->clientes_id           = $cliente_id;
    $item->forma_pagamento_id    = 2;
    $item->status                = 1;
    $item->cadastar();

}

unset($_SESSION['orcamentos-venda']);
unset($_SESSION['orcamentos-clientes']);
unset($_SESSION['carrinho2']);

header('location: orcamento-pagamento.php?status=success');

exit;

