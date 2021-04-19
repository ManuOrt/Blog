<?php

if (isset($_POST)){
//CONEXION BASE DE DATOS
            require_once 'includes/conexion.php';

          $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;


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

        if (count($errores) == 0) {
            $sql = "INSERT INTO categorias VALUES(NULL, '$nombre');";
            $guardar = mysqli_query($db, $sql);
        }


}

header("Location: index.php");