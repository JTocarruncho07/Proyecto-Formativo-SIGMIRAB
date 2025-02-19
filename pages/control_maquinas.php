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
    // Consulta de las maquinas (se asume que existe la tabla "maquinas")
    $stmt = $conexion->query("SELECT * FROM maquinas");
    $maquinas = $stmt->fetchAll();
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-5">
    <h2>Control de Maquinas</h2>
    <form action="../procesar_actividad_maquina.php" method="POST">
        <div class="form-group">
            <label for="maquina_id">Maquina:</label>
            <select name="maquina_id" class="form-control" required>
                <?php foreach ($maquinas as $maquina): ?>
                    <option value="<?php echo $maquina['id']; ?>"><?php echo $maquina['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion de la Actividad:</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="horas_trabajadas">Horas Trabajadas:</label>
            <input type="number" step="0.1" name="horas_trabajadas" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Actividad</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
