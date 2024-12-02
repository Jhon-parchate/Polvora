<?php
// PHP/registro.php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $password]);
        header("Location: ../login.html?registro=exitoso");
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Error por correo duplicado
            echo "El correo ya está registrado. <a href='../registro.html'>Intentar de nuevo</a>";
        } else {
            die("Error al registrar: " . $e->getMessage());
        }
    }
}
?>
