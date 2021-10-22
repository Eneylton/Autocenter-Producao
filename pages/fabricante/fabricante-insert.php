<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Fabricante');
define('BRAND','Cadastrar Fabricante');

use \App\Entidy\Fabricante;
use  \App\Session\Login;
use   \App\File\Upload;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuarios = Fabricante::getList('*','fabricante');

Login::requireLogin();

if(isset($_FILES['arquivo'])){
    $obUpload = new Upload ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../imgs',false);
    $obUpload->gerarNovoNome();

    if($sucesso){

        echo 'Arquivo Enviado ' .$obUpload->getBasename(). "com Sucesso" ;

        if(isset($_POST['nome'])){


            $item = new Fabricante;
            $item->nome = $_POST['nome'];
            $item->foto = $obUpload->getBasename();
            $item->cadastar();
    
            header('location: fabricante-list.php?status=success');
            exit;
        }

    }

}



include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/fabricante/fabricante-form-insert.php';
include __DIR__.'../../../includes/layout/footer.php';