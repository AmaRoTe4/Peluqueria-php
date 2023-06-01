<?php 

namespace Model;

class Citas_Servicios extends Principal{
    protected static $tabla = 'Citas_Servicios';
    protected static $columnasDB = ["id" , "id_cita" , "id_servicio"];

    public $id;
    public $id_cita;
    public $id_servicio;

    public function __construct($initial = []){
        $this->id = $initial["id"] ?? null;
        $this->id_cita = $initial["id_cita"] ?? null;
        $this->id_servicio = $initial["id_servicio"] ?? null;
    }
}