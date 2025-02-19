<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$config = include 'config.php';

try {
    $conexion = new PDO(
        'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['options']
    );

    // Consulta para obtener el total de ingresos y egresos
    $query = "SELECT tipo, SUM(monto) AS total FROM transacciones GROUP BY tipo";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $totales = $stmt->fetchAll();

    $ingresos = 0;
    $egresos = 0;
    foreach ($totales as $fila) {
        if ($fila['tipo'] == 'ingreso') {
            $ingresos = $fila['total'];
        } elseif ($fila['tipo'] == 'egreso') {
            $egresos = $fila['total'];
        }
    }
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <h2>Panel de Control</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Ingresos</div>
                <div class="card-body">
                    <h4 class="card-title">$<?php echo number_format($ingresos, 2); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total Egresos</div>
                <div class="card-body">
                    <h4 class="card-title">$<?php echo number_format($egresos, 2); ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario para agregar ingresos y egresos -->
    <h3>Registrar Ingreso / Egreso</h3>
    <form action="procesar_transaccion.php" method="POST">
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo:</label>
            <select name="tipo" class="form-control" required>
                <option value="ingreso">Ingreso</option>
                <option value="egreso">Egreso</option>
            </select>
        </div>
        <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" step="0.01" name="monto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

    <hr>

    <!-- Formulario para generar reportes -->
    <h3>Generar Reporte de Ingresos y Egresos</h3>
    <form action="generar_reporte.php" method="POST">
        <div class="form-group">
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" name="fecha_fin" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-secondary">Generar Reporte</button>
    </form>

    <hr>
    <a href="logout.php" class="btn btn-danger">Cerrar Sesion</a>
</div>

<?php include 'templates/footer.php'; ?>
