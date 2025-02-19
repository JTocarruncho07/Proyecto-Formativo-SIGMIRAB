<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $metodo = $_POST['metodo'];
    $codigo = rand(100000, 999999); // Codigo de 6 digitos

    try {
        $config = include 'config.php';
        $conexion = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['options']
        );
        $query = "SELECT id FROM usuarios WHERE correo = :correo";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['codigo_recuperacion'] = $codigo;
            $_SESSION['correo_recuperacion'] = $correo;

            // Aquí se integraría la API para enviar el codigo mediante el metodo seleccionado
            echo "Se ha enviado un codigo de verificacion a su " . $metodo . ".";
            echo "<br><a href='verificar_codigo.php'>Ingresar Codigo</a>";
        } else {
            echo "El correo no esta registrado.";
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>
