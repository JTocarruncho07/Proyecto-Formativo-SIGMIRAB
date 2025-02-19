<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoIngresado = $_POST['codigo'];

    if ($codigoIngresado == $_SESSION['codigo_recuperacion']) {
        // Mostrar formulario para cambiar la contrasena
        echo '<form action="actualizar_contrasena.php" method="POST">
                <div class="form-group">
                    <label for="nueva_contrasena">Nueva Contrasena:</label>
                    <input type="password" name="nueva_contrasena" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Contrasena</button>
              </form>';
    } else {
        echo "Codigo incorrecto.";
    }
}
?>
