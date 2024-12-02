<?php
$conexion = mysqli_connect("localhost", "root", "", "bd_polvora");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM ventas WHERE id = '$id'";
    if (mysqli_query($conexion, $sql)) {
        echo "Venta eliminada con éxito.";
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}
header("Location: ventas.php");
exit;
?>
