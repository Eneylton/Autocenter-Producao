<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Produtotemp;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Produtotemp::getID('*','produto_temp',$_GET['id'],null,null);

if(!$value instanceof Produtotemp){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: orcamento-finalizar.php?status=del');

    exit;
}

