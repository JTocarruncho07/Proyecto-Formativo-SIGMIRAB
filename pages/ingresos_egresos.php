<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
include '../config.php';

$transacciones = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filtro = $_POST['filtro'];  // 'dia', 'semana', 'mes' o 'anio'
    $fecha = $_POST['fecha'];    // Fecha de referencia

    try {
        $conexion = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['options']
        );
        switch ($filtro) {
            case 'dia':
                $query = "SELECT * FROM transacciones WHERE fecha = :fecha ORDER BY fecha";
                break;
            case 'semana':
                $query = "SELECT * FROM transacciones WHERE WEEK(fecha) = WEEK(:fecha) AND YEAR(fecha) = YEAR(:fecha) ORDER BY fecha";
                break;
            case 'mes':
                $query = "SELECT * FROM transacciones WHERE MONTH(fecha) = MONTH(:fecha) AND YEAR(fecha) = YEAR(:fecha) ORDER BY fecha";
                break;
            case 'anio':
                $query = "SELECT * FROM transacciones WHERE YEAR(fecha) = YEAR(:fecha) ORDER BY fecha";
                break;
            default:
                $query = "SELECT * FROM transacciones ORDER BY fecha";
        }
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        $transacciones = $stmt->fetchAll();
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-5">
    <h2>Ingresos y Egresos</h2>
    <form action="ingresos_egresos.php" method="POST">
        <div class="form-group">
            <label for="filtro">Filtro:</label>
            <select name="filtro" class="form-control" required>
                <option value="dia">Dia</option>
                <option value="semana">Semana</option>
                <option value="mes">Mes</option>
                <option value="anio">Anio</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha de Referencia:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <?php if (!empty($transacciones)): ?>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transacciones as $transaccion): ?>
                    <tr>
                        <td><?php echo $transaccion['fecha']; ?></td>
                        <td><?php echo ucfirst($transaccion['tipo']); ?></td>
                        <td>$<?php echo number_format($transaccion['monto'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../templates/footer.php'; ?>
