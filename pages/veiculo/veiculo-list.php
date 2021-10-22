<?php
require __DIR__ . '../../../vendor/autoload.php';

use  \App\Db\Pagination;
use App\Entidy\Fabricante;
use   \App\Entidy\Veiculo;
use    \App\Session\Login;

define('TITLE', 'Lista de Veículos');
define('BRAND', 'Veículo');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" or 
                       id LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Veiculo::getQtd($where);


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 5);

$listar = Veiculo::getList('v.id as id,
v.fabricante_id as  fabricante_id,
v.nome as veiculo,
v.foto as foto,
f.nome as fabricante', 'veiculo as v INNER JOIN fabricante as f ON (v.fabricante_id = f.id)', $where, 'id desc', $pagination->getLimit());

$fabricantes = Fabricante::getList('*', 'fabricante');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/veiculo/veiculo-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
    $(document).ready(function() {
        $('.editbtn').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);

            $('#id').val(data[0]);
            $('#nome').val(data[1]);
            $('#foto').val(data[2]);
            $('#fabricante_id').val(data[3]);
            $('#veiculo').val(data[4]);
            $('#fabricante').val(data[5]);

        });
    });
</script>