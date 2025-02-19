<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
include '../config.php';
?>

<?php include '../templates/header.php'; ?>

<div class="container mt-5">
    <h2>Ingresos Diarios</h2>
    <form action="../procesar_ingreso_diario.php" method="POST">
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto Total:</label>
            <input type="number" step="0.01" name="monto" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Ingreso Diario</button>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
