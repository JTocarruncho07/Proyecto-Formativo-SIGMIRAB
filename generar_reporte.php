<?php
require('libs/fpdf.php');
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    try {
        $config = include 'config.php';
        $conexion = new PDO(
            'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['options']
        );

        // Consulta de ingresos y egresos en el rango de fechas
        $query = "SELECT fecha, tipo, monto FROM transacciones WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin ORDER BY fecha";
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->execute();
        $resultados = $stmt->fetchAll();

        if (count($resultados) == 0) {
            die("No hay datos para este rango de fechas.");
        }

        // Crear PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 10, 'Reporte de Ingresos y Egresos', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 10, "Desde: $fecha_inicio - Hasta: $fecha_fin", 0, 1, 'C');
        $pdf->Ln(10);

        // Encabezado de tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(50, 10, 'Fecha', 1);
        $pdf->Cell(70, 10, 'Tipo', 1);
        $pdf->Cell(70, 10, 'Monto', 1);
        $pdf->Ln();

        // Datos
        $pdf->SetFont('Arial', '', 12);
        foreach ($resultados as $fila) {
            $pdf->Cell(50, 10, $fila['fecha'], 1);
            $pdf->Cell(70, 10, ucfirst($fila['tipo']), 1);
            $pdf->Cell(70, 10, "$" . number_format($fila['monto'], 2), 1);
            $pdf->Ln();
        }

        // Salida del PDF
        $pdf->Output();
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}
?>
