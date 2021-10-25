<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Clientes;
use App\Entidy\FormaPagamento;
use App\Entidy\Produtotemp;
use App\Session\Login;

define('TITLE', 'Finalizar orçamento');
define('BRAND', 'Finaceiro');

Login::requireLogin();

if (isset($_GET['id'])) {

   $id_cliente = $_GET['id'];

   $clientes = Clientes::getID('*', 'clientes', $_GET['id'], null, null);

   $nome = $clientes->nome;
   $telefone = $clientes->telefone;
   $email = $clientes->email;
   $localidade = $clientes->localidade;
   $logradouro = $clientes->logradouro;
   $complemento = $clientes->complemento;
   $numero = $clientes->numero;
   $bairro = $clientes->bairro;
   $cep = $clientes->cep;
   $uf = $clientes->uf;
   $data = $clientes->data;
}

$listar = Produtotemp::getList('pt.id AS id,
pt.produtos_id as produtos_id,
pt.clientes_id as clientes_id,
pt.codigo AS codigo,
pt.qtd AS qtd,
pt.subtotal AS subtotal,
pt.desconto as desconto,
pt.valor as valor,
p.nome as produto', ' produto_temp as pt
INNER JOIN
produtos as p ON (pt.produtos_id = p.id)','pt.clientes_id= '.$id_cliente);

$pagamentos = FormaPagamento::getList('*', 'forma_pagamento');

if (isset($_GET['acao']) == 'del') {

   $value = Produtotemp::getID('*','produto_temp',$_GET['produtos_id'],null,null);
   
   $value->excluir();

   // VOLTAR UMA PAGINA E MANTER O ID

   if (isset($_SERVER["HTTP_REFERER"])) {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

   exit;
}


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/orcamento/finalizar-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';
