<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Produtotemp
{


 
    public $id ;
    public $qtd ;
    public $valor ;
    public $codigo ;
    public $produtos_id ;
    public $clientes_id;
    public $forma_pagamento_id;
 
    

    public function cadastar()
    {


        $obdataBase = new Database('produto_temp');

        $this->id = $obdataBase->insert([

            'qtd '                   => $this->qtd ,
            'valor '                 => $this->valor ,
            'codigo '                => $this->codigo ,
            'produtos_id '           => $this->produtos_id ,
            'clientes_id'            => $this->clientes_id,
            'desconto'               => $this->desconto,
            'subtotal'               => $this->subtotal,
            'forma_pagamento_id'     => $this->forma_pagamento_id
          

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('produto_temp'))->update('id = ' . $this->id, [
    
            'qtd '                   => $this->qtd ,
            'valor '                 => $this->valor ,
            'codigo '                => $this->codigo ,
            'produtos_id '           => $this->produtos_id ,
            'clientes_id'            => $this->clientes_id,
            'desconto'               => $this->desconto,
            'subtotal'               => $this->subtotal,
            'forma_pagamento_id'     => $this->forma_pagamento_id
          
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('produto_temp'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('produto_temp'))->select('COUNT(*) as qtd', 'produto_temp', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('produto_temp'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

   

    public function excluir()
    {
        return (new Database('produto_temp'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('produto_temp'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
