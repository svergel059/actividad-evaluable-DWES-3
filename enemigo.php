<?php

require_once("./bbdd.php");   // Conexión $conecta

$id = $_GET["id"];

// Consulta preparada con un id 
$query = "SELECT * FROM enemigos WHERE id=:id";
$consulta = $conecta->prepare($query);
$consulta->bindParam(":id", $id);   // rellenamos el hueco con $id
$consulta->execute();

// coge UNA fila como array asociativo
// Si no existe ningún enemigo con ese id, devuelve false.
$row = $consulta->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver enemigo</title>
    <style>
        img {
            width: 200px;
        }
    </style>
</head>
<body>
    <?php if ($row) { ?>
        <h1>Ver enemigo: <?= ($row["name"]) ?></h1>
        <p>Id: <?= $row["id"] ?></p>
        <p>Nombre: <?= ($row["name"]) ?></p>
        <p>Descripcin: <?= ($row["description"]) ?></p>
        <p>isBOSS: <?= $row["isBoss"] ?></p>
        <p>Health: <?= $row["health"] ?></p>
        <p>Strength: <?= $row["strength"] ?></p>
        <p>Defense: <?= $row["defense"] ?></p>
        <p>Imagen: <?= $row["img"] ?></p>   
        <img src="./assets/images/<?= $row["img"] ?>" alt="<?= ($row["name"]) ?>">  
        <br>

        
        <p><a href="./actualizaEnemigo.php?id=<?= $id ?>">Modificar</a></p>
        <p><a href="./eliminaEnemigo.php?id=<?= $id ?>">Borrar</a></p>
    <?php } else { ?>
        <h1>Enemigo no encontrado</h1>
    <?php } ?>
</body>
</html>
