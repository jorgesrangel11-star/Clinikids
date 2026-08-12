<?php
session_start();
// 1. Seguridad: Solo el Admin (Tipo 1) entra aquí
if(!isset($_SESSION['id_usr']) || $_SESSION['tip_usu'] != 1){
    die("Acceso denegado. Solo administradores.");
}

// 2. Importar la librería FPDF y la conexión
// ../../ sube dos niveles (sale de admin, luego de public) para llegar a la raíz
require_once('../../lib/fpdf/fpdf.php'); 
require_once('../../config/db.php');     

class PDF extends FPDF {
    // Cabecera del PDF
    function Header() {
        $this->SetFont('Arial','B',16);
        $this->SetTextColor(0, 123, 255); // Azul Clinikids
        $this->Cell(0,10, utf8_decode('CLINIKIDS - REPORTE DE CITAS'), 0, 1, 'C');
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(100);
        $this->Cell(0,10, 'Generado el: '.date('d/m/Y H:i'), 0, 1, 'C');
        $this->Ln(10);
        
        // Encabezados de la tabla
        $this->SetFillColor(230, 230, 230);
        $this->SetFont('Arial','B',10);
        $this->Cell(45,10,'Paciente',1,0,'C',true);
        $this->Cell(45,10,'Pediatra',1,0,'C',true);
        $this->Cell(40,10,'Fecha/Hora',1,0,'C',true);
        $this->Cell(30,10,'Estado',1,0,'C',true);
        $this->Cell(30,10,'Tutor',1,1,'C',true);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// 3. Consulta SQL (Traemos los nombres reales con JOIN)
$sql = "SELECT p.nom_paciente, u_doc.nom_usr AS nom_doctor, c.fecha_cita, c.estado_cita, u_tut.nom_usr AS nom_tutor
        FROM citas c
        JOIN pacientes p ON c.id_paciente = p.id_paciente
        JOIN usuarios u_doc ON c.id_pediatra = u_doc.id_usr
        JOIN usuarios u_tut ON p.id_tutor = u_tut.id_usr
        ORDER BY c.fecha_cita DESC";
$res = mysqli_query($conn, $sql);

// 4. Crear el objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);

// 5. Llenar la tabla
if (mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_assoc($res)) {
        $pdf->Cell(45, 10, utf8_decode($row['nom_paciente']), 1);
        $pdf->Cell(45, 10, utf8_decode($row['nom_doctor']), 1);
        $pdf->Cell(40, 10, $row['fecha_cita'], 1);
        $pdf->Cell(30, 10, $row['estado_cita'], 1);
        $pdf->Cell(30, 10, utf8_decode($row['nom_tutor']), 1, 1);
    }
} else {
    $pdf->Cell(190, 10, 'No hay citas registradas.', 1, 1, 'C');
}

// 6. Salida (Descarga automática)
$pdf->Output('D', 'Reporte_Clinikids_'.date('Y-m-d').'.pdf');
?>