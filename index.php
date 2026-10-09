<?php
require __DIR__ . '/config/db.php';
header('Location: ' . (isset($_SESSION['usuario_id']) ? 'dashboard.php' : 'login.php'));
exit;
