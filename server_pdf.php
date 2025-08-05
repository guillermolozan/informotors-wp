<?php
$pdf_path = '/root';
echo $pdf_path;
if (file_exists($pdf_path)) {
  echo " : la carpeta existe.";
} else {
  echo ": la carpeta no existe.";
}
// exit();
// Este archivo debería estar en algún lugar como /path/to/your/site/serve_pdf.php

// Incluye WordPress para poder usar sus funciones
require_once('wp-load.php');

// Verifica que el usuario esté logueado
if (!is_user_logged_in()) {
  wp_die('No tienes permiso para acceder a este archivo.');
}

// Obtén los parámetros necesarios, como la placa y si se debe forzar la descarga
$placa = $_GET['placa'];
$download = isset($_GET['download']) ? intval($_GET['download']) : 0;

// Ruta completa al archivo PDF
$pdf_path = '/home/guille/proyecto.infomotors/app/public/pdf/reporte-' . $placa . '.pdf';

// Verifica que el archivo exista
if (!file_exists($pdf_path)) {
  wp_die('Archivo no encontrado.');
}

// Envía los encabezados apropiados para el PDF
header('Content-Type: application/pdf');

// Si se ha especificado el parámetro "download=1", fuerza la descarga
if ($download === 1) {
  header('Content-Disposition: attachment; filename="' . basename($pdf_path) . '"');
}

// Establece la longitud del archivo
header('Content-Length: ' . filesize($pdf_path));

// Lee el archivo y envíalo al cliente
readfile($pdf_path);
exit;
