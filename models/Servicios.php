<?php 

namespace Model;

class Servicios extends Principal{
    protected static $tabla = 'Servicios';
    protected static $columnasDB = ["id" , "nombre" , "precio"];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($initial = []){
        $this->id = $initial["id"] ?? null;
        $this->nombre = $initial["nombre"] ?? "";
        $this->precio = $initial["precio"] ?? "";
    }
}