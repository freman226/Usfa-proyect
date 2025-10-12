<?php
// filepath: d:\Programación\Php\Proyecto USFA\tienda-guitarras\src\includes\test_db.php
require_once 'db.php';

if (isset($pdo)) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión.";
}
?>