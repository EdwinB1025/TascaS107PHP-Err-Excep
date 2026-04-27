<?php
include 'Functions.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>
    <div>
        <form class="container" action="index.php" method="post">
            <h3 style="font-weight: bold;">Consultar Datos</h3>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name">
            <label for="age">Edad:</label>
            <input type="number" id="age" name="age">
            <label for="course">Curso:</label>
            <input type="text" id="course" name="course">
            <button type="submit">Ver datos</button>
        </form>
    </div>
    <div>
        <?php
        echo getResult();
        ?>
    </div>

</body>

</html>