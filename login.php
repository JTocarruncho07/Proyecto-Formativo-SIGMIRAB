<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <h2>Iniciar Sesion</h2>
    <form action="procesar_login.php" method="POST">
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="contrasena">Contrasena:</label>
            <input type="password" name="contrasena" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
    <a href="recuperar_contrasena.php" class="btn btn-link">Olvidaste tu contrasena?</a>
</div>

<?php include 'templates/footer.php'; ?>
