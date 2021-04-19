<?php

//INICIAR LA SESION Y LA CONEXION A LA BASE DE DATOS
require_once 'includes/conexion.php';

//RECOJER DATOS DEL FORMULARIO

if(isset($_POST)){

    //BORAR ERROR ANTIGUO
    if (isset($_SESSION ['error_login'])){
        $_SESSION ['error_login'] = null;
        }
    //RECOJO DATOS DEL FORMULARIO
$email = trim($_POST['email']);
$password = $_POST['password'];
}

//CONSULTA PARA COMPROBAR LAS CREDENCIALES DEL USUARIO

$sql = "SELECT * FROM usuarios WHERE email = '$email'";

$login = mysqli_query($db, $sql);

if ($login && mysqli_num_rows($login) == 1) {
    //COMPROBAR CONTRASEÑA cifrandola de nuevo
    $usuario = mysqli_fetch_assoc($login);

   $verify= password_verify($password, $usuario['password']);

   if ($verify){
       //UTILIZAR UNA SESION PARA GUARDAR LOS DATOS DEL USUARIO LOGEADO
       $_SESSION['usuario'] = $usuario;


   }else{
       //SI ALGO FALLA ENVIAR UNA SESION CON EL FALLO
       $_SESSION['error_login'] = "Login incorrecto";
   }
}else {
    //MENSAJE DE ERROR
    $_SESSION['error_login'] = "Login incorrecto";
}


//REDIRIGIR AL INDEX.PHP

header('Location: index.php');