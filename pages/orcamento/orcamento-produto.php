<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Clientes;
use App\Entidy\Produto;
use App\Session\Login;

$value = Clientes:: getID('*','clientes',$_GET['id'],null,null);

$cliente_id = $value->id;
$cliente = $value->nome;

define('TITLE','Cliente: '.$cliente);
define('BRAND','Finaceiro');

Login::requireLogin();


$foto2 = "";

$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);
$buscar2 = filter_input(INPUT_GET, 'buscar2', FILTER_SANITIZE_STRING);
$buscar3 = filter_input(INPUT_GET, 'buscar3', FILTER_SANITIZE_STRING);

$id = (int)$buscar2;

$condicoes = [
    strlen($buscar) ? 'p.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null,

    strlen($buscar2) ? 'p.categorias_id = ' . str_replace(' ', '', $id) . '' : null,

    strlen($buscar3) ? 'p.barra LIKE "%'  . str_replace(' ', '%', $buscar3) . '%"' : null

];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);


$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Produto:: getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 200);

$listar = Produto::getList('p.id as id,
                            p.codigo as codigo,
                            p.barra as barra,
                            p.nome as nome,
                            p.foto as foto,
                            p.qtd as  qtd,
                            p.estoque as estoque,
                            p.aplicacao as aplicacao,
                            p.valor_compra as valor_compra,
                            p.valor_venda as valor_venda,
                            p.categorias_id as categorias_id,
                            c.nome as categoria',
                            //TABELAS
                            'produtos AS p
                             INNER JOIN
                             categorias AS c ON (p.categorias_id = c.id)',$where, 'p.id DESC',$pagination->getLimit());


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/orcamento/produto-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
$(document).ready(function(){
    $('.editbtn').on('click', function(){
        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id').val(data[0]);
        $('#nome').val(data[1]);
        $('#telefone').val(data[2]);
        $('#email').val(data[3]);
        $('#localidade').val(data[4]);
        $('#logradouro').val(data[5]);
        $('#numero').val(data[6]);
        $('#bairro').val(data[7]);
        $('#cep').val(data[8]);
        $('#uf').val(data[9]);
       
    });
});
</script>

<script>

$("#cep1").on("change", function(){

    var idCEP = $("#cep1").val();
    $.ajax({
        url: 'https://viacep.com.br/ws/'+idCEP +'/json/unicode/',
        dataType: 'json',
        success: function(resposta){
			
				$("#logradouro1").val(resposta.logradouro);
				$("#bairro1").val(resposta.bairro);
				$("#cidade1").val(resposta.localidade);
				$("#uf1").val(resposta.uf);
				$("#numero1").focus();
			}

    })

});

</script> 


<script>

$("#cep").on("change", function(){

    var idCEP = $("#cep").val();
    $.ajax({
        url: 'https://viacep.com.br/ws/'+idCEP +'/json/unicode/',
        dataType: 'json',
        success: function(resposta){
			
				$("#logradouro").val(resposta.logradouro);
				$("#bairro").val(resposta.bairro);
				$("#localidade").val(resposta.localidade);
				$("#uf").val(resposta.uf);
				$("#numero").focus();
			}

    })

});

</script> 