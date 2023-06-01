<?php 

namespace Classes;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email , $nombre , $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        echo "http://localhost:3000/confirmar?token='" . $this->token . "'";
    }

}