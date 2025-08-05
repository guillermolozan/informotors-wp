<?php
/*
Template Name: Procesar Informe
*/

get_header();

$placa = isset($_GET['placa']) ? sanitize_text_field($_GET['placa']) : '';

if ($placa) {
    // Aquí se procesa el informe y se genera el archivo descargable
    // Supongamos que generamos un archivo PDF llamado informe-$placa.pdf

    // Simulación de la generación del informe
    sleep(120); // Simulamos un retraso en la generación

    // Guardamos el enlace del informe en la cuenta del usuario
    $user_id = get_current_user_id();
    update_user_meta($user_id, 'informe_' . $placa, '/path/to/informe-' . $placa . '.pdf');

    // Redirigimos de vuelta a la cuenta del usuario
    wp_redirect(home_url('/mi-cuenta'));
    exit;
}

get_footer();
