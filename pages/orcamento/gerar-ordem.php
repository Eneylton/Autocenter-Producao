<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\FormaPagamento;
use Dompdf\Dompdf;
use Dompdf\Options;

if(isset($_POST['formaPagamento_id'])){

$pagamento_id = $_POST['formaPagamento_id'];

$value = FormaPagamento:: getID('*','forma_pagamento',$_POST['formaPagamento_id'],null,null);

$pagamento = $value->nome;

$receber_id = $_POST['receber'];

}

$dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true);
$options-> set ('isHtml5ParserEnabled', true);

ob_start();



require __DIR__."/ordem-pdf.php";

$dompdf->loadHtml(ob_get_clean());

// echo $pdf;

$dompdf->setPaper("A7","landscape");

$dompdf->render();

$dompdf->stream("recibo.pdf", ["Attachment"=> false]);


