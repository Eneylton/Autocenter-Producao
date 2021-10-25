<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Produto;
use App\Entidy\Produtotemp;
use App\Session\Login;

Login::requireLogin();

if (isset($_POST['cliente_id'])) {

    $cliente_id = $_POST['cliente_id'];

    $itemProduto  = Produtotemp::getClientID('*', 'produto_temp', $cliente_id, null, null);
    $codigo =  $itemProduto->codigo;
} else {
}

if (isset($_POST['submit'])) {

    if (isset($_POST['all'])) {

        foreach ($_POST['all'] as $id) {
            if (isset($_POST['all'])) {

                $value  = Produto::getID('*', 'produtos', $id, null, null);
                $valor = $value->valor_venda;

                $item = new Produtotemp;

                $item->codigo               = $codigo;
                $item->qtd                  = 1;
                $item->desconto             = 0;
                $item->valor                = $valor;
                $item->subtotal             = $valor;
                $item->produtos_id          = $id;
                $item->forma_pagamento_id   = 2;
                $item->clientes_id          = $cliente_id;

                $item->cadastar();
            }
        }


       
    
        exit;

    }
}
