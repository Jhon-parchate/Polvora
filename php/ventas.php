<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd_polvora");

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener lista de vendedores
$query_vendedores = "SELECT id, nombre, producto FROM vendedores";
$resultado_vendedores = mysqli_query($conexion, $query_vendedores);

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vendedor_id = $_POST['vendedor'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    
    $sql = "INSERT INTO ventas (vendedor_id, cantidad, precio, fecha) 
            VALUES ('$vendedor_id', '$cantidad', '$precio', NOW())";
    
    if (mysqli_query($conexion, $sql)) {
        echo "<p class='success'>Venta registrada exitosamente</p>";
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conexion) . "</p>";
    }
}

// Obtener todas las ventas con información del vendedor
$query_ventas = "
    SELECT 
        v.id,
        vend.nombre AS vendedor,
        vend.producto,
        v.cantidad,
        v.precio,
        (v.cantidad * v.precio) AS total,
        v.fecha
    FROM ventas v
    JOIN vendedores vend ON v.vendedor_id = vend.id
    ORDER BY v.fecha DESC
";
$resultado_ventas = mysqli_query($conexion, $query_ventas);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Ventas</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/ventas.css">
</head>
<body>
<header class="header">
        <nav class="nav-container">
            <div class="nav-left">
                <button >
                    
                </button>
            </div>
            <div class="logo">El Carbonero</div>
            <button>
            </button>
        </nav>
    </header>

    <div class="menu_mejorado" >
        <ul>
            <li><a href="../principal.html">Inicio</a></li>
            <li><a href="vendedores.php">Vendedores</a></li>
            <li><a href="ventas.php">Ventas</a></li>
        </ul>
    </div>

    <div class="overlay" id="overlay"></div>



    <h2>Registro de Ventas</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
        <label for="vendedor"><i class="fas fa-user"></i> Seleccionar Vendedor:</label>
        <select id="vendedor" name="vendedor" required>
            <option value="">Seleccione un vendedor</option>
            <?php while ($row = mysqli_fetch_assoc($resultado_vendedores)) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['nombre'] . " - " . $row['producto']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="cantidad"><i class="fas fa-boxes"></i> Cantidad Vendida:</label>
        <input type="number" id="cantidad" name="cantidad" min="1" required>
    </div>
    
    <div class="form-group">
        <label for="precio"><i class="fas fa-dollar-sign"></i> Precio por Unidad:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" required>
    </div>
    
    <button type="submit" class="main-button">
        <i class="fas fa-fire"></i> Registrar Venta
    </button>
</form>
    
    <h3>Registro de Ventas</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vendedor</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado_ventas)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['vendedor']; ?></td>
                    <td><?php echo $row['producto']; ?></td>
                    <td><?php echo $row['cantidad']; ?></td>
                    <td>$<?php echo number_format($row['precio'], 2); ?></td>
                    <td>$<?php echo number_format($row['total'], 2); ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td>
                        <form action="eliminar_venta.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <p><a href="vendedores.php">Ir al formulario de vendedores</a></p>
    <script src="../js/script.js"></script>
</body>
</html>
