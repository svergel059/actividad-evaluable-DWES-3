<?php


require_once("./bbdd.php");   // Conexión $conecta

$id = $_GET["id"];            // id del enemigo a borrar
$borrado = false;             

// Buscamos el enemigo para conocer su nombre y su imagen
$query = "SELECT * FROM enemigos WHERE id=:id";
$consulta = $conecta->prepare($query);
$consulta->bindParam(":id", $id);
$consulta->execute();

// fetch() coge UNA fila Si no hay ninguna con ese id, devuelve false.
$row = $consulta->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $nombreEnemigo = $row["name"];
    $nombreImagen = $row["img"];
} else {
    $nombreEnemigo = "Enemigo no encontrado";
}

if ($row && isset($_GET["borrar"]) && $_GET["borrar"] == 1) {

    $uploadDir = "assets/images/";
    if (is_file($uploadDir . $nombreImagen)) {
        unlink($uploadDir . $nombreImagen);
    }

    $query = "DELETE FROM enemigos WHERE id = :id";
    $consulta = $conecta->prepare($query);
    $consulta->bindParam(":id", $id);

    if ($consulta->execute()) {
        $borrado = true; 
        if ($consulta->rowCount() > 0) {
            $msg = "Borrado realizado correctamente.";
        } else {
            $msg = "El borrado no afecto ninguna fila.";
        }
    } else {
        $msg = "Error al ejecutar el borrado.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina enemigo</title>
    <style>
        img {
            width: 200px;
        }
    </style>
</head>

<body>
    <h1>Eliminar enemigo: <?= ($nombreEnemigo) ?></h1>
    <?php
    if ($borrado) {
    ?>
        <p><?= $msg ?></p>
        <p><a href="./index.php">Volver al inicio</a></p>
    <?php
    } elseif ($row) {
    ?>
        <p>Esta seguro de que quiere eliminar a <b><?= ($nombreEnemigo) ?></b>?</p>
        <img src="./assets/images/<?= $nombreImagen ?>" alt="<?= ($nombreEnemigo) ?>">
        <p><a href="./eliminaEnemigo.php?id=<?= $id ?>&borrar=1">Borrar</a></p>
        <p><a href="./enemigo.php?id=<?= $id ?>">No borrar</a></p>
    <?php } else { ?>
        <p><a href="./index.php">Volver al inicio</a></p>
    <?php } ?>
</body>

</html>