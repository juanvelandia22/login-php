<?php
require __DIR__ . '/config/db.php';

if (!isset($_SESSION['usuario_id'])) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="card">
    <h1>¡Hola, <?= e($_SESSION['nombre']) ?>! 👋</h1>
    <p>Has iniciado sesión correctamente. Esta página solo la ven los usuarios autenticados.</p>
    <a class="btn" href="logout.php">Cerrar sesión</a>
</main>
</body>
</html>
