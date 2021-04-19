<?php
//VAMOS A REALIZAR LA CONEXION

$servidor = 'localhost';
$usuario= 'root';
$password= '';
$basededatos='blog_master';

$db = mysqli_connect($servidor, $usuario, $password, $basededatos );
$db->set_charset("utf8");
mysqli_query($db, "SET NAMES 'UTF8");

//INICIAR LA SESSION
if (!isset($_SESSION)){
    session_start();
}
