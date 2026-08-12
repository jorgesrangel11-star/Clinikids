<?php
$host = "localhost";
$user = "root";
$pass = ""; // Tu contraseña de MySQL
$db   = "clinikids_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
// Set de caracteres para evitar problemas con tildes y la Ñ
mysqli_set_charset($conn, "utf8mb4"); 
?>