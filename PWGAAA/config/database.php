<?php

function conectarDB(): PDO
{
    $db= new PDO("mysql:host=localhost;dbname=PWGAAA;",username:"root",password:"232425");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function realizarquery($conexion,$texto,$argumentos=null,$isfetch=false)
{
    $comand=$conexion->prepare($texto);
    $comand->execute($argumentos);
    if($isfetch) return $comand->fetchAll();
}
?>