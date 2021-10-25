<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Categoria;
use App\Entidy\Fabricante;
use App\Entidy\Produto;
use App\Entidy\Veiculo;
use App\Session\Login;

define('TITLE','Lista de Produtos');
define('BRAND','Produtos');

Login::requireLogin();

$foto2 = "";

if(isset($_POST['id'])){
    $id= $_POST['id'];

    $veiculos = Veiculo:: getFabricID('*','veiculo',$_POST['id'],null,null );

    foreach ($veiculos as $item) {
        echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
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

$qtd = Produto:: getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 2000);

$listar = Produto::getList('p.id AS id,p.fabricante_id as fabricante_id,p.veiculo_id as veiculo_id,p.codigo AS codigo,
                            p.barra AS barra,p.nome AS nome,p.foto AS foto,p.qtd AS qtd,p.estoque AS estoque,p.aplicacao AS aplicacao,
                            p.valor_compra AS valor_compra,p.valor_venda AS valor_venda,p.categorias_id AS categorias_id,c.nome AS categoria,
                            f.nome AS fabricante,v.nome AS veiculo',
                            //TABELAS
                                'produtos AS p INNER JOIN fabricante AS f ON (p.fabricante_id = f.id)
                                INNER JOIN veiculo AS v ON (p.veiculo_id = v.id)
                                INNER JOIN categorias AS c ON (p.categorias_id = c.id)',$where, 'p.id DESC',$pagination->getLimit());

$categorias = Categoria :: getList('*','categorias',null,'nome ASC');
$fabricantes = Fabricante :: getList('*','fabricante');
$veiculos = Veiculo :: getList('*','veiculo');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/produto/produto-form-list.php';
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
        $('#barra').val(data[1]);
        $('#fabricante').val(data[2]);
        $('#veiculo').val(data[3]);
        $('#nome').val(data[4]);
        $('#foto').val(data[5]);
        $('#usuarios_id').val(data[6]);
        $('#qtd').val(data[7]);
        $('#categorias_id').val(data[8]);
        $('#estoque').val(data[9]);
        $('#aplicacao').val(data[10]);
        $('#valor_compra').val(data[11]);
        $('#valor_venda').val(data[12]);
        $('#fabricante_id').val(data[13]);
        $('#veiculo_id').val(data[14]);
    });
});
</script>


<script type="text/javascript">

    function carregarImg() {

        var target = document.getElementById('target');
        var file = document.querySelector("input[type=file]").files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);


        } else {
            target.src = "";
        }
    }

</script>

<script>

$("#valor_compra1").on("change", function(){

    var idCompra = $("#valor_compra1").val();
    $.ajax({
        url:'produto-list.php',
        type:'POST',
        data:{
            id:idCompra
        },
        success: function(data){
            $('#valor_venda1').val(Number((idCompra) / 0.40).toFixed(2));
        }

    })

});

</script> 

<script>

$("#valor_compra").on("change", function(){

    var idCompra = $("#valor_compra").val();
    $.ajax({
        url:'produto-list.php',
        type:'POST',
        data:{
            id:idCompra
        },
        success: function(data){
            $('#valor_venda').val(Number((idCompra) / 0.40).toFixed(2));
        }

    })

});

</script> 

<script>
$("#fabric").on("change", function(){
   
   var idEstado = $("#fabric").val();
   $.ajax({
       url:'produto-list.php',
       type:'POST',
       data:{id:idEstado},
       beforeSend:function(){
           $("#vei").css({'display':'block'});
           $("#vei").html("carregando....");
       },
       success:function(data){
           $("#vei").css({'display':'block'});
           $("#vei").html(data);
       }
   })

});

</script>

<script>
$("#fabric1").on("change", function(){
   
   var idEstado = $("#fabric1").val();
   $.ajax({
       url:'produto-list.php',
       type:'POST',
       data:{id:idEstado},
       beforeSend:function(){
           $("#vei1").css({'display':'block'});
           $("#vei1").html("carregando....");
       },
       success:function(data){
           $("#vei1").css({'display':'block'});
           $("#vei1").html(data);
       }
   })

});

</script>

<script>
$("#fabricante_id").on("change", function(){
   
   var idEstado = $("#fabricante_id").val();
   $.ajax({
       url:'produto-list.php',
       type:'POST',
       data:{id:idEstado},
       beforeSend:function(){
           $("#vei2").css({'display':'block'});
           $("#vei2").html("carregando....");
       },
       success:function(data){
           $("#vei2").css({'display':'block'});
           $("#vei2").html(data);
       }
   })

});

</script>

