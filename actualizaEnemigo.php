<?php


require_once("./bbdd.php");   // Conexión $conecta

$id = $_GET["id"];           

//Leemos el enemigo actual 

$query = "SELECT * FROM enemigos WHERE id=:id";
$consulta = $conecta->prepare($query);
$consulta->bindParam(":id", $id);
$consulta->execute();

foreach ($consulta as $enemigo) {
    $nameEnemigo = $enemigo["name"];
    $descripcionEnemigo = $enemigo["description"];
    $isBOSSEnemigo = $enemigo["isBoss"];
    $healthEnemigo = $enemigo["health"];
    $strengthEnemigo = $enemigo["strength"];
    $defenseEnemigo = $enemigo["defense"];
    $imgEnemigo = $enemigo["img"];          // name de la imagen actual
}

//Si se envió el formulario POST guardamos los cambios 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $descripcion = $_POST["descripcion"];
    $isBOSS = $_POST["isBOSS"];
    $health = $_POST["health"];
    $strength = $_POST["strength"];
    $defense = $_POST["defense"];
    $imagen = $_FILES["imagen"]; // datos del archivo 
    if ($imagen["name"] == "") {
        // Mantenemos la imagen que ya tenia
        $nameImagen = $imgEnemigo;
    } else {
        // Si eligio imagen nueva: la subimos igual que al crear
        $uploadDir = "assets/images/";
        $fileName = basename($imagen["name"]);
        $nameImagen = uniqid() . "_" . $fileName;
        $targetFile = $uploadDir . $nameImagen;
        move_uploaded_file($imagen["tmp_name"], $targetFile);   // guardamos la nueva
        if (is_file($uploadDir . $imgEnemigo)) {
            unlink($uploadDir . $imgEnemigo);
        }
    }

    $query = "UPDATE enemigos SET name=:name, description=:descripcion, isBoss=:isBOSS, health=:health, strength=:strength, defense=:defense, img=:img WHERE id=:id";
    $consulta = $conecta->prepare($query);
    $consulta->bindParam(":name", $name);
    $consulta->bindParam(":descripcion", $descripcion);
    $consulta->bindParam(":isBOSS", $isBOSS);
    $consulta->bindParam(":health", $health);
    $consulta->bindParam(":strength", $strength);
    $consulta->bindParam(":defense", $defense);
    $consulta->bindParam(":img", $nameImagen);
    $consulta->bindParam(":id", $id);

    if ($consulta->execute()) {
        $msg = "El enemigo $name se ha modificado correctamente.";
    } else {
        $msg = "No se ha podido modificar $name. Inténtelo de nuevo más tarde.";
    }
}

//Volvemos a leer el enemigo para que el formulario muestre los datos ya actualizados 
$query = "SELECT * FROM enemigos WHERE id=:id";
$consulta = $conecta->prepare($query);
$consulta->bindParam(":id", $id);
$consulta->execute();

foreach ($consulta as $enemigo) {
    $nameEnemigo = $enemigo["name"];
    $descripcionEnemigo = $enemigo["description"];
    $isBOSSEnemigo = $enemigo["isBoss"];
    $healthEnemigo = $enemigo["health"];
    $strengthEnemigo = $enemigo["strength"];
    $defenseEnemigo = $enemigo["defense"];
    $imgEnemigo = $enemigo["img"];
}

// Si solo estamos abriendo la pagina  mensaje inicial
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $msg = "Modificar el enemigo $nameEnemigo.";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar enemigo</title>
    <style>
        img {
            width: 200px;
        }
    </style>
</head>

<body>
    <h1>Actualizar enemigo</h1>
    <p><?= ($msg) ?></p>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">name:
            <input type="text" name="name" id="name" value="<?= ($nameEnemigo) ?>">
        </label>
        <br>
        <label for="descripcion">Descripcion:
            <textarea name="descripcion" id="descripcion"><?= ($descripcionEnemigo) ?></textarea>
        </label>
        <br>
        <label for="isBOSS">isBOSS (0 = no, 1 = sí):
            <input type="text" name="isBOSS" id="isBOSS" value="<?= $isBOSSEnemigo ?>">
        </label>
        <br>
        <label for="health">Health:
            <input type="text" name="health" id="health" value="<?= $healthEnemigo ?>">
        </label>
        <br>
        <label for="strength">Strength:
            <input type="text" name="strength" id="strength" value="<?= $strengthEnemigo ?>">
        </label>
        <br>
        <label for="defense">Defense:
            <input type="text" name="defense" id="defense" value="<?= $defenseEnemigo ?>">
        </label>
        <br>
        <label for="imagen">Imagen 
            <br>
            <img src="./assets/images/<?= $imgEnemigo ?>" alt="<?= ($nameEnemigo) ?>">
            <br>
            <input type="file" name="imagen" id="imagen">
        </label>
        <br>
        <input type="submit" name="submit" id="submit" value="Actualizar">
    </form>
    <p><a href="./enemigo.php?id=<?= $id ?>">Volver a la ficha</a></p>
    <p><a href="./index.php">Volver al inicio</a></p>
</body>

</html>