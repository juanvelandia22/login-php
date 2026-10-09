<?php
require __DIR__ . '/config/db.php';

if (isset($_SESSION['usuario_id'])) { header('Location: dashboard.php'); exit; }

$error = '';
$ok = $_SESSION['ok'] ?? '';
unset($_SESSION['ok']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valido()) {
        $error = 'Sesión inválida, recarga la página.';
    } else {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare('SELECT id, nombre, password FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre']     = $usuario['nombre'];
            header('Location: dashboard.php');
            exit;
        }
        $error = 'Correo o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="card">
    <h1>Iniciar sesión</h1>
    <?php if ($ok): ?><div class="alert ok"><?= e($ok) ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label>Correo
            <input type="email" name="email" required>
        </label>
        <label>Contraseña
            <input type="password" name="password" required>
        </label>
        <button type="submit">Entrar</button>
    </form>
    <p class="link">¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
</main>
</body>
</html>
