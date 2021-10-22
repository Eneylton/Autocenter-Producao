<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Veiculo
{


    public $id;
    public $foto;
    public $nome;
    public $fabricante_id;
  

    public function cadastar()
    {


        $obdataBase = new Database('veiculo');

        $this->id = $obdataBase->insert([

            'foto'              => $this->foto,
            'nome'              => $this->nome,
            'fabricante_id'     => $this->fabricante_id
            

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('veiculo'))->update('id = ' . $this->id, [

            'foto'              => $this->foto,
            'nome'              => $this->nome,
            'fabricante_id'     => $this->fabricante_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('veiculo'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('veiculo'))->select('COUNT(*) as qtd', 'veiculo', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('veiculo'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

 

    public function excluir()
    {
        return (new Database('veiculo'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('veiculo'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
