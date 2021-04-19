<?php

if(isset($_POST)) {
//CONEXION BASE DE DATOS
    require_once 'includes/conexion.php';
//INICIAR SESSION
    if (!isset($_SESSION)){
        session_start();
    }

    //RECOJER LOS VALORES DEL FORMULARIO
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['nombre']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($db, $_POST['password']) : false;

    //ARRAY DE ERRORES
    $errores = array();

    //VALIDAR LOS DATOS ANTES DE GUARDARLOS EN LA BASE DE DATOS

    //VALIDAR CAMPO NOMBRE

    if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
        $nombre_validadado = true;
    }else {
        $nombre_validadado = false;
        $errores['nombre']="El nombre no es valido";
    }

    //VALIDAR APELLIDOS

    if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
        $apellidos_validadado = true;
    }else {
        $apellidos_validadado = false;
        $errores['apellidos']="El apellido no es valido";
    }

    //VALIDAR EMAIL

    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_validadado = true;
    }else {
        $email_validadado = false;
        $errores['email']="El email no es valido";
    }

    //VALIDAR CONTRASEÑA

    if(!empty($password)){
        $password_validadado = true;
    }else {
        $password_validadado = false;
        $errores['password']="La contraseña no es valida";
    }
//INSERTAR USUARIOS EN LA TABLA DE USUARIOS DE LA DB


    if (count($errores) == 0){
        $guardar_usuario= true;

        //CIFRAR CONTRASEÑA
        $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost'=>4]);


        $sql = "INSERT INTO usuarios VALUES(null, '$nombre', '$apellidos', '$email', '$password_segura', CURDATE());";
        $guardar = mysqli_query($db, $sql);


        if($guardar){
            $_SESSION['completado'] = "El registro se ha completado con exito";
        }else{
            $_SESSION['errores']['general'] = "Fallo al guardar el usuario";
        }
    }else {
        $_SESSION['errores'] = $errores;

    }
}

header('Location: index.php');





