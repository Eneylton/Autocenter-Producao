<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Produto;
use App\Session\Login;


define('TITLE','Orçamento');
define('BRAND','Finaceiro');


Login::requireLogin();

if(isset($_GET['cliente_id'])){

  $cliente_id = $_GET['cliente_id'];

}


if (!isset($_SESSION['carrinho2'])) {
    $_SESSION['carrinho2'] = array();
  }
 
  if(isset($_GET['acao'])){

  if ($_GET['acao'] == 'add') {
  $id = intval($_GET['id']);
  
  if (!isset($_SESSION['carrinho2'][$id])) {
  
    $_SESSION['carrinho2'][$id] = 1;
  } else {
    $_SESSION['carrinho2'][$id] += 1;
  }
  }
  }

  if(isset($_GET['acao'])){

    if ($_GET['acao'] == 'up') {
  
      if (is_array($_POST['prod'])) {
  
         foreach ($_POST['prod'] as $id => $qtd) {
  
            $id = intval($id);
            $qtd = intval($qtd);
  
            if (!empty($qtd) || $qtd != 0) {
  
               $_SESSION['carrinho2'][$id] = $qtd;
            } else {
  
               unset($_SESSION['carrinho2'][$id]);
            }
         }
      }
  
      if (is_array($_POST['val'])) {
  
         foreach ($_POST['val'] as $id => $valor) {
  
            $item = Produto::getID('*','produtos',$id,null,null);
            $val1              = $valor;
            $val2              = str_replace(".", "", $val1);
            $preco             = str_replace(",", ".",$val2);
  
            $item->valor_venda = $preco;
            $item->atualizar();
         }
      }

     
   }
  
   if ($_GET['acao'] == 'del') {
      $id = intval($_GET['id']);
  
      if (isset($_SESSION['carrinho2'][$id])) {
         unset($_SESSION['carrinho2'][$id]);
      }
   }
  
  }
  
  if (isset($_POST['submit'])) {
              
   if (isset($_POST['id'])) {
 
     foreach ($_POST['id'] as $id) {
 
       if (isset($_POST['id'])) {
     
         $id  = intval($id);
 
         if (!isset($_SESSION['carrinho2'][$id])) {
 
             $_SESSION['carrinho2'][$id] = 1;
             
         } else {
 
             $_SESSION['carrinho2'][$id] += 1;
         }
       
     }
 
   }
 }

}



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/orcamento/caixa-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

