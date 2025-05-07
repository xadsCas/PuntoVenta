<?php

$servidor ="localhost";
$user ="root";
$pass="";
$basedatos="puntodeventa";

$conn= mysqli_connect( $servidor, $user, $pass, $basedatos) ;

if(!$conn)
{
    die("Connection failed: " .mysqli_connect_error());
    
}







?>