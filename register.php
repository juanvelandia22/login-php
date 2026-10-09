<?php
require __DIR__ . '/config/db.php';

if (isset($_SESSION['usuario_id'])) { header('Location: dashboard.php'); exit; }

$errores = [];
$nombre = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valido()) {
        $errores[] = 'Sesión inválida, recarga la página.';
    } else {
        $nombre   = trim($_POST['nombre'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';

        if ($nombre === '' || mb_strlen($nombre) > 100) $errores[] = 'Escribe un nombre válido.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'El correo no es válido.';
        if (strlen($password) < 8) $errores[] = 'La contraseña debe tener mínimo 8 caracteres.';
        if ($password !== $confirmar) $errores[] = 'Las contraseñas no coinciden.';

        if (!$errores) {
            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $errores[] = 'Ese correo ya está registrado.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)');
                $stmt->execute([$nombre, $email, $hash]);
                $_SESSION['ok'] = 'Cuenta creada. Ya puedes iniciar sesión.';
                header('Location: login.php');
                exit;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="card">
    <h1>Crear cuenta</h1>
    <?php foreach ($errores as $err): ?>
        <div class="alert error"><?= e($err) ?></div>
    <?php endforeach; ?>
    <form method="post" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label>Nombre
            <input type="text" name="nombre" value="<?= e($nombre) ?>" required>
        </label>
        <label>Correo
            <input type="email" name="email" value="<?= e($email) ?>" required>
        </label>
        <label>Contraseña
            <input type="password" name="password" minlength="8" required>
        </label>
        <label>Confirmar contraseña
            <input type="password" name="confirmar" minlength="8" required>
        </label>
        <button type="submit">Registrarme</button>
    </form>
    <p class="link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</main>
</body>
</html>
