<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Fabricante
{


    public $id;
    public $foto;
    public $nome;
  

    public function cadastar()
    {


        $obdataBase = new Database('fabricante');

        $this->id = $obdataBase->insert([

            'foto'              => $this->foto,
            'nome'              => $this->nome
            

        ]);

        return true;
    }

    public function atualizar()
    {
        return (new Database('fabricante'))->update('id = ' . $this->id, [

            'foto'              => $this->foto,
            'nome'              => $this->nome
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('fabricante'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('fabricante'))->select('COUNT(*) as qtd', 'fabricante', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('fabricante'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

 

    public function excluir()
    {
        return (new Database('fabricante'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('fabricante'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
