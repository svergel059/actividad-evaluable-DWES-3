<?php

require_once("./bbdd.php");   

// todas las columnas de todas las filas de enemigos
$query = "SELECT * FROM enemigos";
$consulta = $conecta->prepare($query);   
$consulta->execute();                   

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>actividad evaluativa</title>
    <style>
        img {
            width: 200px;
        }
    </style>
</head>

<body>
    <h1>Enemigos</h1>
    <p><a href="./anadeEnemigo.php">Crear enemigo</a></p>
    <table border="1" cellpadding="10" cellspacing="10">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>isBOSS</th>
                <th>Health</th>
                <th>Strength</th>
                <th>Defense</th>
                <th>Imagen</th>
                <th>Ver enemigo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // en cada vuelta $row contiene UNA fila de la base de datos
            foreach ($consulta as $row) {
            ?>
            <tr>
                <td><?= $row["name"]; ?></td>
                <td><?= $row["description"]; ?></td>
                <td><?= $row["isBoss"]; ?></td>
                <td><?= $row["health"]; ?></td>
                <td><?= $row["strength"]; ?></td>
                <td><?= $row["defense"]; ?></td>
                <td><img src="./assets/images/<?= $row["img"]; ?>" alt="<?= $row["name"]; ?>"></td>
                <td><a href="./enemigo.php?id=<?= $row["id"] ?>">Mostrar</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>
