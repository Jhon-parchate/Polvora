<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd_polvora");

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM vendedores WHERE id = $id";
    if (mysqli_query($conexion, $sql)) {
        echo "<p class='success'>Vendedor eliminado exitosamente</p>";
    } else {
        echo "<p class='error'>Error al eliminar: " . mysqli_error($conexion) . "</p>";
    }
}

// Variables para el formulario de edición
$editando = false;
$edit_id = "";
$edit_nombre = "";
$edit_telefono = "";
$edit_categoria = "";
$edit_producto = "";

// Cargar datos para edición
if (isset($_GET['editar'])) {
    $editando = true;
    $id = $_GET['editar'];
    $query = "SELECT * FROM vendedores WHERE id = $id";
    $resultado = mysqli_query($conexion, $query);
    if ($row = mysqli_fetch_assoc($resultado)) {
        $edit_id = $row['id'];
        $edit_nombre = $row['nombre'];
        $edit_telefono = $row['telefono'];
        $edit_categoria = $row['categoria_polvora'];
        $edit_producto = $row['producto'];
    }
}

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $categoria = $_POST['categoria'];
    $producto = $_POST['producto'];
    
    if (isset($_POST['editar_id'])) {
        // Actualizar registro existente
        $id = $_POST['editar_id'];
        $sql = "UPDATE vendedores SET 
                nombre = '$nombre',
                telefono = '$telefono',
                categoria_polvora = '$categoria',
                producto = '$producto'
                WHERE id = $id";
        
        if (mysqli_query($conexion, $sql)) {
            echo "<p class='success'>Vendedor actualizado exitosamente</p>";
            $editando = false;
        } else {
            echo "<p class='error'>Error: " . mysqli_error($conexion) . "</p>";
        }
    } else {
        // Insertar nuevo registro
        $sql = "INSERT INTO vendedores (nombre, telefono, categoria_polvora, producto) 
                VALUES ('$nombre', '$telefono', '$categoria', '$producto')";
        
        if (mysqli_query($conexion, $sql)) {
            echo "<p class='success'>Vendedor registrado exitosamente</p>";
        } else {
            echo "<p class='error'>Error: " . mysqli_error($conexion) . "</p>";
        }
    }
}

// Obtener todos los vendedores
$query = "SELECT * FROM vendedores ORDER BY fecha_registro DESC";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Vendedores</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/vendedores.css">
</head>
<body>

<header class="header">
        <nav class="nav-container">
            <div class="nav-left">

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


    <h2><?php echo $editando ? 'Editar Vendedor' : 'Registro de Vendedores de Pólvora'; ?></h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <?php if ($editando) { ?>
        <input type="hidden" name="editar_id" value="<?php echo $edit_id; ?>">
    <?php } ?>
    
    <div class="form-group">
        <label for="nombre"><i class="fas fa-user"></i> Nombre del Vendedor:</label>
        <input type="text" id="nombre" name="nombre" required 
               value="<?php echo $editando ? $edit_nombre : ''; ?>"
               placeholder="Ingrese el nombre completo">
    </div>
    
    <div class="form-group">
        <label for="telefono"><i class="fas fa-phone"></i> Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required
               value="<?php echo $editando ? $edit_telefono : ''; ?>"
               placeholder="Ingrese el número telefónico">
    </div>
    
    <div class="form-group">
        <label for="categoria"><i class="fas fa-fire"></i> Categoría de Pólvora:</label>
        <select id="categoria" name="categoria" required>
            <option value="">Seleccione una categoría</option>
            <option value="Categoría 1" <?php echo ($editando && $edit_categoria == 'Categoría 1') ? 'selected' : ''; ?>>
                Categoría 1 - Pirotecnia Básica
            </option>
            <option value="Categoría 2" <?php echo ($editando && $edit_categoria == 'Categoría 2') ? 'selected' : ''; ?>>
                Categoría 2 - Pirotecnia Intermedia
            </option>
            <option value="Categoría 3" <?php echo ($editando && $edit_categoria == 'Categoría 3') ? 'selected' : ''; ?>>
                Categoría 3 - Pirotecnia Avanzada
            </option>            <option value="Categoría 1" <?php echo ($editando && $edit_categoria == 'Categoría 1') ? 'selected' : ''; ?>>
                Categoría 1 - Tortas Básica
            </option>
            <option value="Categoría 2" <?php echo ($editando && $edit_categoria == 'Categoría 2') ? 'selected' : ''; ?>>
                Categoría 2 - Tortas Intermedia
            </option>
            <option value="Categoría 3" <?php echo ($editando && $edit_categoria == 'Categoría 3') ? 'selected' : ''; ?>>
                Categoría 3 - Tortas Avanzada
            </option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="producto"><i class="fas fa-box"></i> Producto:</label>
        <input type="text" id="producto" name="producto" required
               value="<?php echo $editando ? $edit_producto : ''; ?>"
               placeholder="Nombre del producto">
    </div>
    
    <button type="submit">
        <?php echo $editando ? '<i class="fas fa-save"></i> Actualizar Vendedor' : '<i class="fas fa-plus"></i> Registrar Vendedor'; ?>
    </button>
    <?php if ($editando) { ?>
        <a href="vendedores.php" class="btn-cancelar">
            <i class="fas fa-times"></i> Cancelar
        </a>
    <?php } ?>
</form>
    
    <h3>Vendedores Registrados</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Categoría</th>
                <th>Producto</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['telefono']; ?></td>
                    <td><?php echo $row['categoria_polvora']; ?></td>
                    <td><?php echo $row['producto']; ?></td>
                    <td><?php echo $row['fecha_registro']; ?></td>
                    <td class="acciones">
                        <a href="?editar=<?php echo $row['id']; ?>" class="btn-editar">Editar</a>
                        <a href="?eliminar=<?php echo $row['id']; ?>" 
                           onclick="return confirm('¿Está seguro de que desea eliminar este vendedor?')"
                           class="btn-eliminar">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <p><a href="ventas.php">Ir al formulario de ventas</a></p>
    <script src="../js/venta_vende.js"></script>
</body>
</html>