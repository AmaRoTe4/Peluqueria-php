<?php 

namespace Controllers;

use Model\Usuarios;
use MVC\Router;
use Classes\Email;

class LoginController{

    public static function login(Router $router){
        $usuario = new Usuarios;
        $errores = [];
        
        if($_SERVER["REQUEST_METHOD"]  == "POST"){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $usuario->email = $email;
            $usuario->password = $password;

            $ver = $usuario->verificarLogin();
            $errores = $ver["errores"];
            $user = $ver["user"];

            if(isset($errores)){
                session_start();

                $_SESSION['id'] = $user->id;
                $_SESSION['nombre'] = $user->nombre . " " . $user->apellido;
                $_SESSION['email'] = $user->email ;
                $_SESSION['login'] = true;

                if($user->admin === 1){
                    $_SESSION['admin'] = 1;
                    header("Location: /admin");
                }else{
                    header("Location: /citas");
                }

            }
        }

        $router->render("auth/login" , [
            "errores" => $errores,
            "usuario" => $usuario
        ]);
    }

    public static function logout(Router $router){
        //get

        $router->render("auth/logout");
    }

    public static function forgot(Router $router){
        //get and post
        $errores = [];
        $usuario = new Usuarios;

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST["email"] != ""){
                $usuario->email = $_POST["email"];
                $resp = $usuario->verEmail();
    
                $id = $resp["id"];
                $errores = $resp["errores"];
    
                if(empty($errores)) {
                    $usuario = $usuario->find($id);
                    $usuario->crearToken();
                    $usuario->guardar();

                    Header("Location: /recover?token=$usuario->token");
                }
            }
        }

        $router->render("auth/forgot" , [
            "errores" => $errores
        ]);
    }

    public static function recover(Router $router){
        //get and post
        $errores = [];
        $usuario = new Usuarios;
        $recover = false;
        $token = $_GET['token'];
        $id = $usuario->includesData("token" , $token);

        if($id != 0){
            $recover = true;
            $usuario = $usuario->find($id);
        }else $errores[] = "el token es invalido";

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $password = $_POST['password'];
            
            if(!$password) $errores[] = "Tiene que escribir una contraseña, es obligatoria";
            else if(strlen($password) >= 6){
                $usuario->password = $password;
                $usuario->encriptarPassword();
                $usuario->confirmado = 1;
                $usuario->token = null;
                $resultado = $usuario->guardar();
                
                if($resultado) header("location: /login");
            }else $errores[] = "la contraseña tiene que tener como minimo 6 digitos";
        }

        $router->render("auth/recover" , [
            "errores" => $errores,
            "recover" => $recover,
            "token" => $token
        ]);
    }

    public static function create(Router $router){
        $usuario = new Usuarios;
        $errores = [];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $usuario = new Usuarios($_POST);

            $errores = $usuario->validacionEnLaCreacion();

            if(!$errores[0]){
                $usuario->encriptarPassword();
                $usuario->crearToken();

                $email = new Email($usuario->nombre , $usuario->email , $usuario->token);
                $email->enviarConfirmacion();

                $resultado = $usuario->guardar();

                if($resultado){
                    header("location: /mensaje?token=$usuario->token");
                } 
            }
        }
        
        $router->render("auth/create" , [
            "usuario" => $usuario,
            "errores" => $errores
        ]);
    }

    public static function confirmar(){
        $token = s($_GET["token"]);
        $usuario = new Usuarios;
        $id = (int)$usuario->includesData("token" , $token);

        if($id == 0) {
            header("Location: /login");
            return;
        }
        
        $usuario = $usuario->find($id);
        $usuario->confirmado = 1;
        $usuario->token = null;

        $resultado = $usuario->actualizar();
        
        if($resultado) header("Location: /login?estado=1");
        else header("Location: /create=1");
    }

    public static function mensaje(Router $router){
        $token = $_GET["token"];

        $router->render("auth/mensaje" , [
            "token" => $token
        ]);
    }
}