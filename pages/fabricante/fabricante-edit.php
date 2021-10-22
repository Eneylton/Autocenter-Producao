<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Fabricante');
define('BRAND', 'Fabricante');

use \App\Entidy\Fabricante;
use  \App\Session\Login;
use   \App\File\Upload;


Login::requireLogin();

if (!isset($_POST['id']) or !is_numeric($_POST['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Fabricante:: getID('*','fabricante',$_POST['id'],null,null);


if (!$value instanceof Fabricante) {
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

            $value->nome = $_POST['nome'];
            $value->foto = $obUpload->getBasename();
            $value->atualizar();

            header('location: fabricante-list.php?status=success');

            exit;


        } 
        }else {

            if (isset($_POST['nome'])) {

                $value->nome = $_POST['nome'];
                $value->atualizar();

                header('location: fabricante-list.php?status=success');

                exit;
            }
    }
}

