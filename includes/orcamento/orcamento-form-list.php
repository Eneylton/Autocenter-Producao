<?php

$list = '';

if (isset($_GET['status'])) {

   switch ($_GET['status']) {
      case 'success':
         $icon  = 'success';
         $title = 'Parabéns';
         $text = 'Ordem de serviço enviada !!!!';
         break;

         case 'del':
            $icon  = 'error';
            $title = 'Parabéns';
            $text = 'Esse usuário foi excluido !!!';
            break;

            case 'edit':
               $icon  = 'warning';
               $title = 'Parabéns';
               $text = 'Cadastro atualizado com sucesso !!!';
               break;
   

      default:
         $icon  = 'error';
         $title = 'Opss !!!';
         $text = 'Algo deu errado entre em contato com admin !!!';
         break;
   }

   function alerta($icon, $title, $text)
   {
      echo "<script type='text/javascript'>
      Swal.fire({
        type:'type',  
        icon: '$icon',
        title: '$title',
        text: '$text'
       
      }) 
      </script>";
   }

   alerta($icon, $title, $text);

}

$resultados = '';

foreach ($listar as $item) {

   $resultados .= '<tr>
                      <td style="display:none" >' . $item->id . '</td>
                      <td style="display:none" >' . $item->nome . '</td>
                      <td style="display:none" >' . $item->telefone . '</td>
                      <td style="display:none" >' . $item->email . '</td>
                      <td style="display:none" >' . $item->localidade . '</td>
                      <td style="display:none" >' . $item->logradouro . '</td>
                      <td style="display:none" >' . $item->numero . '</td>
                      <td style="display:none" >' . $item->bairro . '</td>
                      <td style="display:none" >' . $item->cep . '</td>
                      <td style="display:none" >' . $item->uf . '</td>
                      <td style="display:none" >' . $item->complemento . '</td>

                      <td>' . $item->id . '</td>
                      <td>' . $item->nome . '</td>
                      <td>' . $item->telefone . '</td>
                      <td>' . $item->email . '</td>
                    
                      <td style="text-align: center; width:300px">

                      <a href="orcamento-produto.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-default"> <i class="fas fa-plus"></i>&nbsp Add produtos</button>
                       </a>
                       &nbsp;
                      
                      <button type="submit" class="btn btn-success editbtn" > <i class="fas fa-paint-brush"></i> </button>
                      &nbsp;

                       <a href="orcamento-delete.php?id=' . $item->id . '">
                       <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                       </a>


                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="5" class="text-center" > Nenhum Cliente Encontrado !!!!! </td>
                                                     </tr>';


unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
   $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  </a>';
}

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-purple">
               <div class="card-header">

                  <form method="get">
                     <div class="row ">
                        <div class="col-4">

                           <label>Buscar por Nome</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>">

                        </div>


                        <div class="col d-flex align-items-end">
                           <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>

                        </div>


                     </div>

                  </form>
               </div>

               <div class="table-responsive">

                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>
                        <tr>
                           <td colspan="5">
                              <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Nova</button>
                           </td>
                        </tr>
                        <tr>
                           <th style="text-align: left; width:80px"> CÓDIGO </th>
                           <th> NOME </th>
                           <th> TELEFONE </th>
                           <th> EMAIL </th>
                          
                           <th style="text-align: center; width:200px"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog modal-lg">
      <div class="modal-content bg-light">
         <form action="./orcamento-cliente.php" method="post">

            <div class="modal-header">
               <h4 class="modal-title">Orçamento
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label>Nome</label>
                     <input type="text" class="form-control" name="nome" >
                  </div>

               </div>

            </div>

            <div class="row">
               <div class="col-8">
               <div class="form-group">
                     <label>Email</label>
                     <input type="text" class="form-control" name="email" >
                  </div>

               </div>
               <div class="col-4">

               <div class="form-group">
                     <label>Telefone</label>
                     <input type="text" class="form-control" name="telefone" id="cel" >
                  </div>

               </div>

            </div>
            <div class="row">
               <div class="col-2">
               <div class="form-group">
                     <label>CEP</label>
                     <input type="text" class="form-control" name="cep" id="cep1">
                  </div>
               </div>
               <div class="col-6">
               <div class="form-group">
                     <label>Logradouro</label>
                     <input type="text" class="form-control" name="logradouro" id="logradouro1">
                  </div>
               </div>
               <div class="col-4">
               <div class="form-group">
                     <label>Bairro</label>
                     <input type="text" class="form-control" name="bairro" id="bairro1">
                  </div>
               </div>
            </div>

            <div class="row">

            <div class="col-2">
            <div class="form-group">
                     <label>Nº</label>
                     <input type="text" class="form-control" name="numero" id="numero1">
                  </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                     <label>Complemento</label>
                     <input type="text" class="form-control" name="complemento">
                  </div>
            </div>

            <div class="col-3">
            <div class="form-group">
                     <label>Cidade</label>
                     <input type="text" class="form-control" name="localidade" id="cidade1">
                  </div>
            </div>
            <div class="col-3">

            <div class="form-group">
                     <label>Estado</label>
                     <input type="text" class="form-control" name="uf" id="uf1">
                  </div>

            </div>

            </div>


            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- EDITAR -->

<div class="modal fade" id="editmodal">
   <div class="modal-dialog modal-lg">
      <form action="./orcamento-edit.php" method="get">
         <div class="modal-content bg-light">
            <div class="modal-header">
               <h4 class="modal-title">Orçamento
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id" id="id">
            <div class="row">
               <div class="col-12">
                  <div class="form-group">
                     <label>Nome</label>
                     <input type="text" class="form-control" name="nome" id="nome" >
                  </div>

               </div>

            </div>

            <div class="row">
               <div class="col-8">
               <div class="form-group">
                     <label>Email</label>
                     <input type="text" class="form-control" name="email" id="email" >
                  </div>

               </div>
               <div class="col-4">

               <div class="form-group">
                     <label>Telefone</label>
                     <input type="text" class="form-control" name="telefone" id="telefone" >
                  </div>

               </div>

            </div>
            <div class="row">
               <div class="col-2">
               <div class="form-group">
                     <label>CEP</label>
                     <input type="text" class="form-control" name="cep" id="cep">
                  </div>
               </div>
               <div class="col-6">
               <div class="form-group">
                     <label>Logradouro</label>
                     <input type="text" class="form-control" name="logradouro" id="logradouro">
                  </div>
               </div>
               <div class="col-4">
               <div class="form-group">
                     <label>Bairro</label>
                     <input type="text" class="form-control" name="bairro" id="bairro">
                  </div>
               </div>
            </div>

            <div class="row">

            <div class="col-2">
            <div class="form-group">
                     <label>Nº</label>
                     <input type="text" class="form-control" name="numero" id="numero">
                  </div>
            </div>
            <div class="col-4">
            <div class="form-group">
                     <label>Complemento</label>
                     <input type="text" class="form-control" name="complemento" id="complemento">
                  </div>
            </div>

            <div class="col-3">
            <div class="form-group">
                     <label>Cidade</label>
                     <input type="text" class="form-control" name="localidade" id="localidade">
                  </div>
            </div>
            <div class="col-3">

            <div class="form-group">
                     <label>Estado</label>
                     <input type="text" class="form-control" name="uf" id="uf">
                  </div>

            </div>

            </div>


            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Salvar
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>