<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
include '../config.php';

try {
    $conexion = new PDO(
        'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
        $config['db']['user'],
        $config['db']['pass'],
        $config['db']['options']
    );
    // Se asume que existe la tabla "maquinas"
    $stmt = $conexion->query("SELECT * FROM maquinas");
    $maquinas = $stmt->fetchAll();
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-5">
    <h2>Gastos por Maquina</h2>
    <form action="../procesar_gasto_maquina.php" method="POST">
        <div class="form-group">
            <label for="maquina_id">Maquina:</label>
            <select name="maquina_id" class="form-control" required>
                <?php foreach ($maquinas as $maquina): ?>
                    <option value="<?php echo $maquina['id']; ?>"><?php echo $maquina['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="combustible">Combustible:</label>
            <input type="number" step="0.01" name="combustible" class="form-control" value="0">
        </div>
        <div class="form-group">
            <label for="grasa">Grasa:</label>
            <input type="number" step="0.01" name="grasa" class="form-control" value="0">
        </div>
        <div class="form-group">
            <label for="repuestos">Repuestos:</label>
            <input type="number" step="0.01" name="repuestos" class="form-control" value="0">
        </div>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Gastos</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
