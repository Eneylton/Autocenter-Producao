<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Categoria;
use App\Entidy\Fabricante;
use App\Entidy\Produto;
use App\Entidy\Produtotemp;
use App\Entidy\Veiculo;
use App\Session\Login;

define('TITLE', 'Finalizar orçamento');
define('BRAND', 'Finaceiro');

Login::requireLogin();

if(isset($_POST['id'])){
    $id= $_POST['id'];

    $veiculos = Veiculo:: getFabricID('*','veiculo',$_POST['id'],null,null );

    foreach ($veiculos as $item) {
        echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
     }
    
}


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

        header('location: orcamento-finalizar.php?id='.$cliente_id);

        exit;

    }
}



$buscar2 = filter_input(INPUT_GET, 'buscar2', FILTER_SANITIZE_STRING);
$buscar3 = filter_input(INPUT_GET, 'buscar3', FILTER_SANITIZE_STRING);
$buscar5 = filter_input(INPUT_GET, 'buscar5', FILTER_SANITIZE_STRING);

$id2 = (int)$buscar2;
$id3 = (int)$buscar3;
$id5 = (int)$buscar5;

$condicoes = [

    strlen($buscar2) ? 'p.categorias_id = ' . str_replace(' ', '', $id2) . '' : null,
    strlen($buscar3) ? 'p.fabricante_id = ' . str_replace(' ', '', $id3) . '' : null,
    strlen($buscar5) ? 'p.veiculo_id = ' . str_replace(' ', '', $id5) . '' : null,

];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Produtotemp::getQtd($where);

$listar = Produtotemp::getList('p.id AS id,p.fabricante_id as fabricante_id,p.veiculo_id as veiculo_id,p.codigo AS codigo,
p.barra AS barra,p.nome AS produto,p.foto AS foto,p.qtd AS qtd,p.estoque AS estoque,p.aplicacao AS aplicacao,
p.valor_compra AS valor_compra,p.valor_venda AS valor_venda,p.categorias_id AS categorias_id,c.nome AS categoria,
f.nome AS fabricante,v.nome AS veiculo', 'produtos AS p INNER JOIN fabricante AS f ON (p.fabricante_id = f.id)
INNER JOIN veiculo AS v ON (p.veiculo_id = v.id)
INNER JOIN categorias AS c ON (p.categorias_id = c.id)', $where, 'c.nome ASC');

$categorias = Categoria::getList('*', 'categorias', null, 'nome ASC');
$fabricantes = Fabricante::getList('*', 'fabricante', null, 'nome ASC');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/orcamento/adicionar-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';


?>

<script>
    $("#fabric").on("change", function() {

        var idEstado = $("#fabric").val();
        $.ajax({
            url: 'orcamento-adicionar.php',
            type: 'POST',
            data: {
                id: idEstado
            },
            beforeSend: function() {
                $("#vei").css({
                    'display': 'block'
                });
                $("#vei").html("carregando....");
            },
            success: function(data) {
                $("#vei").css({
                    'display': 'block'
                });
                $("#vei").html(data);
            }
        })

    });
</script>