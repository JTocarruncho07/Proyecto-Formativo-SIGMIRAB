<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevaContrasena = hash('sha256', $_POST['nueva_contrasena']);
    $correo = $_SESSION['correo_recuperacion'];

    try {
        $config = include 'config.php';
        $conexion = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['options']
        );
        $query = "UPDATE usuarios SET contrasena = :contrasena WHERE correo = :correo";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':contrasena', $nuevaContrasena);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        echo "Contrasena actualizada con exito. <a href='login.php'>Iniciar Sesion</a>";
        session_destroy();
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>
