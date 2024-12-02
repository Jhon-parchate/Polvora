<?php
// PHP/db.php
$host = 'localhost';
$dbname = 'bd_polvora';
$username = 'root'; // Cambiar según tu configuración
$password = '';     // Cambiar según tu configuración

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
