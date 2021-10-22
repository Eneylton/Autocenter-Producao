<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

use \App\Entidy\Produto;
use  \App\Session\Login;
use   \App\File\Upload;

$usuariologado = Login::getUsuarioLogado();

$usuarios_id = $usuariologado['id'];
$usuarios_nome = $usuariologado['nome'];

$foto = "";

Login::requireLogin();

if (!isset($_POST['id']) or !is_numeric($_POST['id'])) {

    header('location: index.php?status=error');

    exit;
}

$foto = $_POST['foto'];

$value = Produto::getID('*','produtos',$_POST['id'],null,null);


if (!$value instanceof Produto) {
    header('location: index.php?status=error');

    exit;
}

if (isset($_FILES['arquivo'])) {
    $obUpload = new Upload($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__ . '../../../imgs', false);
    $obUpload->gerarNovoNome();

    if ($sucesso) {

        echo 'Arquivo Enviado ' . $obUpload->getBasename() . "com Sucesso";

        if (isset($_POST['nome'])) {

            $value->codigo          = $_POST['codigo'];
            $value->barra           = $_POST['barra'];
            $value->nome            = $_POST['nome'];
            $value->qtd             = 1;
            $value->status          = 0;
            $value->estoque         = $_POST['estoque'];
            $value->valor_compra    = $_POST['valor_compra'];
            $value->valor_venda     = $_POST['valor_venda'];
            $value->aplicacao       = $_POST['aplicacao'];
            $value->fabricante_id   = $_POST['fabricante_id'];
            $value->veiculo_id      = $_POST['veiculo_id'];
            $value->foto            = $obUpload->getBasename();
            $value->categorias_id   = $_POST['categorias_id'];
            $value->usuarios_id     = $usuarios_id;
            
            $value->atualizar();

            header('location: produto-list.php?status=success');

            exit;
        } 
        }else {

            if (isset($_POST['nome'])) {

                
                $value->barra           = $_POST['barra'];
                $value->nome            = $_POST['nome'];
                $value->qtd             = 1;
                $value->status          = 0;
                $value->estoque         = $_POST['estoque'];
                $value->valor_compra    = $_POST['valor_compra'];
                $value->valor_venda     = $_POST['valor_venda'];
                $value->categorias_id   = $_POST['categorias_id'];
                $value->aplicacao       = $_POST['aplicacao'];
                $value->usuarios_id     = $usuarios_id;
                $value->fabricante_id   = $_POST['fabricante_id'];
                $value->veiculo_id      = $_POST['veiculo_id'];
                $value->atualizar();

                header('location: produto-list.php?status=success');

                exit;
            }
    }
}


