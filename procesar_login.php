<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    try {
        $config = include 'config.php';
        $conexion = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['options']
        );

        $query = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario && hash('sha256', $contrasena) === $usuario['contrasena']) {
            $_SESSION['usuario'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Correo o contrasena incorrectos.";
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>

