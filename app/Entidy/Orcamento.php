<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Orcamento
{

    public $id ;
    public $codigo;
    public $clientes_id;
    public $forma_pagamento_id;
    public $qtd;
    public $status;
    public $valor;
    

    public function cadastar()
    {


        $obdataBase = new Database('orcamento');

        $this->id = $obdataBase->insert([

            'id '                      => $this->id ,
            'codigo'                   => $this->codigo,
            'clientes_id'              => $this->clientes_id,
            'forma_pagamento_id'       => $this->forma_pagamento_id,
            'qtd'                      => $this->qtd,
            'status'                   => $this->status,
            'valor'                    => $this->valor
            

        ]);

        return true;
    }


    public function atualizar()
    {
        return (new Database('orcamento'))->update('id = ' . $this->id, [

            'id'                      => $this->id,
            'codigo'                   => $this->codigo,
            'clientes_id'              => $this->clientes_id,
            'forma_pagamento_id'       => $this->forma_pagamento_id,
            'qtd'                      => $this->qtd,
            'status'                   => $this->status,
            'valor'                    => $this->valor
        ]);
    }

    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('orcamento'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('orcamento'))->select('COUNT(*) as qtd', 'orcamento', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('orcamento'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

  

    public function excluir()
    {
        return (new Database('orcamento'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('orcamento'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
