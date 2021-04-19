<?php


if (isset($_POST)) {
//CONEXION BASE DE DATOS
    require_once 'includes/conexion.php';

    //RECOJER LOS VALORES DEL FORMULARIO DE ACTUALIZACION
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['nombre']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

    //ARRAY DE ERRORES
    $errores = array();

    //VALIDAR LOS DATOS ANTES DE GUARDARLOS EN LA BASE DE DATOS

    //VALIDAR CAMPO NOMBRE

    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validadado = true;
    } else {
        $nombre_validadado = false;
        $errores['nombre'] = "El nombre no es valido";
    }

    //VALIDAR APELLIDOS

    if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
        $apellidos_validadado = true;
    } else {
        $apellidos_validadado = false;
        $errores['apellidos'] = "El apellido no es valido";
    }

    //VALIDAR EMAIL

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_validadado = true;
    } else {
        $email_validadado = false;
        $errores['email'] = "El email no es valido";
    }





    //ACTUALIZAR EL USUARIO EN LA TABLA DE USUARIOS DE LA DB


    if (count($errores) == 0) {
        $usuario = $_SESSION['usuario'];
        $guardar_usuario = true;

        //COMPROBRAR SI EL EMAIL YA EXISTE
        $sql = "SELECT id, email FROM usuarios WHERE email = '$email'";
        $isset_email = mysqli_query($db, $sql);
        $isset_user = mysqli_fetch_assoc($isset_email);


        if ($isset_user['id'] == $usuario['id'] || empty($isset_user)) {


            $usuario = $_SESSION['usuario'];
            $sql = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', email= '$email' WHERE id = " . $_SESSION['usuario']['id'];
            $guardar = mysqli_query($db, $sql);


            if ($guardar) {
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;

                $_SESSION['completado'] = "Tus datos se han actualizado con exito";
            } else {
                $_SESSION['errores']['general'] = "Fallo al actualizar tus datos!";
            }
        } else {
            $_SESSION['errores']['general'] =  "El usuario ya existe!";

        }
    }else{
        $_SESSION['errores'] = $errores;
    }


}

header('Location: mis-datos.php');





