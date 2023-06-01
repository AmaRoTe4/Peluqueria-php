<?php 

namespace Model;

class Citas extends Principal{
    protected static $tabla = 'Citas';
    protected static $columnasDB = ["id" , "fecha" , "hora" , "id_usuario"];

    public $id;
    public $fecha;
    public $hora;
    public $id_usuario;

    public function __construct($initial = []){
        $this->id = $initial["id"] ?? null;
        $this->fecha = $initial["fecha"] ?? "";
        $this->hora = $initial["hora"] ?? "";
        $this->id_usuario = $initial["id_usuario"] ?? null;
    }
}