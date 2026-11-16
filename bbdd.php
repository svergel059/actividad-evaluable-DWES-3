<?php


$servidor = "localhost";   
$ddbb = "enemigos";        
$usuario = "root";         
$contrasena = "";          

try {
    $conecta = new PDO("mysql:host=$servidor;dbname=$ddbb;charset=utf8mb4",
        $usuario,
        $contrasena);
} catch (PDOException $e) {
    // Si la conexión falla mostramos el error
    echo "Error de conexión: " . $e->getMessage();
}
