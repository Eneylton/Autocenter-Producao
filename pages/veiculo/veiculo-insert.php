<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Veiculos');
define('BRAND','Cadastrar Veiculos');

use \App\Entidy\Veiculo;
use  \App\Session\Login;
use   \App\File\Upload;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();


Login::requireLogin();

if(isset($_FILES['arquivo'])){
    $obUpload = new Upload ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../imgs',false);
    $obUpload->gerarNovoNome();

    if($sucesso){

        echo 'Arquivo Enviado ' .$obUpload->getBasename(). "com Sucesso" ;

        if(isset($_POST['nome'])){


            $item = new Veiculo;
            $item->nome = $_POST['nome'];
            $item->fabricante_id = $_POST['fabricante_id'];
            $item->foto = $obUpload->getBasename();
            $item->cadastar();
    
            header('location: veiculo-list.php?status=success');
            exit;
        }

    }

}



include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/categoria/categoria-form-insert.php';
include __DIR__.'../../../includes/layout/footer.php';