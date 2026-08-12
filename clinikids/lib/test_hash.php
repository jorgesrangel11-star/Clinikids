<?php
// Genera el hash de una contraseña
$password_plana = "tu_password_aqui";
$hash_generado = password_hash($password_plana, PASSWORD_DEFAULT);

echo "Copia este hash y pégalo en el campo 'pass' de tu base de datos:<br>";
echo "<strong>" . $hash_generado . "</strong>";
?>