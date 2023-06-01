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
                    header("Location: /main");
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

        $router->render("auth/forgot");
    }

    public static function recover(Router $router){
        //get and post

        $router->render("auth/recover");
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