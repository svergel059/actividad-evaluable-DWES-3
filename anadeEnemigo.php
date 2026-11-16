<?php


require_once("./bbdd.php");   // Conexion $conecta

// Mensaje por defecto al abrir la pagina
$msg = "Añada los datos del enemigo.";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $isBOSS = $_POST["isBOSS"];
    $health = $_POST["health"];
    $strength = $_POST["strength"];
    $defense = $_POST["defense"];


    $imagen = $_FILES["imagen"];

    $uploadDir = "assets/images/";                 
    $fileName = basename($imagen["name"]);         
    $nombreImagen = uniqid() . "_" . $fileName;     
    $targetFile = $uploadDir . $nombreImagen;      

    // Mueve el archivo de la carpeta temporal a la carpeta definitiva
    move_uploaded_file($imagen["tmp_name"], $targetFile);

    // SQL de insercion con huecos (:nombre, :descripcion...)
    $query = "INSERT INTO enemigos (name, description, isBoss, health, strength, defense, img) VALUES (:nombre, :descripcion, :isBOSS, :health, :strength, :defense, :img)";
    $consulta = $conecta->prepare($query);

    // bindParam rellenamos cada hueco con su variable
    $consulta->bindParam(":nombre", $nombre);
    $consulta->bindParam(":descripcion", $descripcion);
    $consulta->bindParam(":isBOSS", $isBOSS);
    $consulta->bindParam(":health", $health);
    $consulta->bindParam(":strength", $strength);
    $consulta->bindParam(":defense", $defense);
    // En la BD guardamos SOLO el nombre del archivo, no la ruta ni la imagen
    $consulta->bindParam(":img", $nombreImagen);

    // execute() devuelve true si salio bien y false si fallo
    if ($consulta->execute()) {
        $msg = "El enemigo $nombre se ha añadido correctamente.";
    } else {
        $msg = "No se ha podido añadir $nombre al listado. Inténtelo de nuevo más tarde.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir enemigo</title>
</head>

<body>
    <h1>Añadir enemigo</h1>
    <p><?= ($msg) ?></p> 
    <form action="" method="post" enctype="multipart/form-data">

        <label for="nombre">Nombre:
            <input type="text" name="nombre" id="nombre">
        </label>
        <br>
        <label for="descripcion">Descripcion:
            <textarea name="descripcion" id="descripcion"></textarea>
        </label>
        <br>
        <label for="isBOSS">isBOSS (0 = no, 1 = si):
            <input type="text" name="isBOSS" id="isBOSS">
        </label>
        <br>
        <label for="health">Health:
            <input type="text" name="health" id="health">
        </label>
        <br>
        <label for="strength">Strength:
            <input type="text" name="strength" id="strength">
        </label>
        <br>
        <label for="defense">Defense:
            <input type="text" name="defense" id="defense">
        </label>
        <br>
        <label for="imagen">Imagen:
            <input type="file" name="imagen" id="imagen">
        </label>
        <br>
        <input type="submit" name="submit" id="submit" value="Añadir">
    </form>
    <p><a href="./index.php">Volver al inicio</a></p>
</body>

</html>
