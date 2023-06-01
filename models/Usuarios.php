<?php 

namespace Model;

class Usuarios extends Principal{
    protected static $tabla = 'Usuarios';
    protected static $columnasDB = ["id","nombre","apellido","email","telefono","admin","confirmado","token","password"];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;

    public function __construct($initial = []){
        $this->id = $initial["id"] ?? null;
        $this->nombre = $initial["nombre"] ?? "";
        $this->apellido = $initial["apellido"] ?? "";
        $this->email = $initial["email"] ?? "";
        $this->telefono = $initial["telefono"] ?? "";
        $this->admin = $initial["admin"] ?? 0;
        $this->confirmado = $initial["confirmado"] ?? 0;
        $this->token = $initial["token"] ?? "";
        $this->password = $initial["password"] ?? "";
    }

    public function validacionEnLaCreacion(): array{
        $patron = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';     
        $errores = [];
        
        if($this->nombre == "") $errores[] = "El campo nombre es obligatorio";
        else if(strlen($this->nombre) > 60) $errores[] = "El nombre no puede tener mas de 60 caracteres";
        if($this->apellido == "") $errores[] = "El campo apellido es obligatorio";
        else if(strlen($this->apellido) > 60) $errores[] = "El apellido no puede tener mas de 60 caracteres";
        if($this->email == "") $errores[] = "El campo email es obligatorio";
        else if(preg_match($patron, $this->email) == 0) $errores[] = "El email no tiene el formato correspondiente";
        else if($this->includesData("email" , $this->email)) $errores[] = "El email ya esta logeado, use otro o inicie sesion con este";
        if($this->password == "") $errores[] = "El campo password es obligatorio";
        else if(strlen($this->password) < 6) $errores[] = "La contraseña tiene que tener mas de 6 caracteres";
        if($this->telefono == "") $errores[] = "El campo telefono es obligatorio";
        else if(!ctype_digit($this->telefono)) $errores[] = "El telefono solo debe tener valores numericos";
        else if(strlen($this->telefono) != 10) $errores[] = "El telefono tiene que tener 10 caracteres";    
        else if($this->includesData("telefono" , $this->telefono)) $errores[] = "El telefono ya esta logeado, use otro o inicie sesion con este";       
    
        return $errores;
    } 

    public function encriptarPassword(){
        $this->password = password_hash($this->password , PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function verificarLogin():array{
        $errores = [];

        if($this->email != "" && $this->password != ""){
            $idEmail = $this->includesData("email" , $this->email);
            if($idEmail == 0) $errores[] = "Correo no registrado";
            $user = static::find($idEmail);
            $conf = $user->confirmado;
            $pass = $user->password;
            
            if($conf == 0) $errores[] = "Usuario no Verficado";
            if(!password_verify($this->password , $pass)) $errores[] = "Contraseña incorrecta";
        } else $errores[] = "Debe completar todos los campos entes de iniciar sesion";
    
        return [
            "errores" => $errores,
            "user" => $user,
        ];
    }
}