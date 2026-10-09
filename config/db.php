<?php
// Configuración de la base de datos (valores por defecto de XAMPP)
$host = 'localhost';
$db   = 'login_db';
$user = 'root';
$pass = '';

session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die('Error de conexión a la base de datos. Revisa config/db.php');
}

// Escapar texto para mostrarlo en HTML (evita XSS)
function e($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Token CSRF
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_valido() {
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}
