<?php
/*
Plugin Name: Page Bloquer
Description: Bloquea el acceso a todas las páginas del sitio y muestra una página de bloqueo con un campo para ingresar el código de desbloqueo. No olvidar que es necesario desactivar LiteSpeed Cache

Version: 1.0
Author: Guille
*/

// Evitar acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Función para mostrar la página de bloqueo
function show_block_page() {
    $plugin_url = plugin_dir_url(__FILE__);
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bloqueado</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-900 text-white flex justify-center min-h-screen">
        <div class="w-full max-w-md p-8 space-y-6">
            <img src="' . esc_url($plugin_url . 'logo_blanco-1.svg') . '" alt="Logo" class="mx-auto mb-20">
            <div class="text-center">
                <h1 class="text-2xl font-semibold">Estamos Trabajando</h1>
                <p class="mt-2">Ingrese el código de desbloqueo</p>
            </div>
            <form method="post" class="space-y-4">
                <div>
                    <input type="text" name="unlock_code" id="unlock_code" placeholder="Ingresa el código de desbloqueo" class="w-full px-4 py-2 bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <input type="submit" value="Desbloquear" class="w-full px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </form>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("unlock_code").focus();
            });
        </script>
    </body>
    </html>';
    return $html;
}

// Función para verificar el código de desbloqueo
function verify_unlock_code() {
    if (isset($_POST['unlock_code'])) {
        $unlock_code = sanitize_text_field($_POST['unlock_code']);
        if ($unlock_code === 'infomotors') {
            setcookie('page_bloquer_unlocked', 'true', time() + (30 * 24 * 60 * 60), '/'); // Cookie válida por 30 días
            wp_redirect(home_url());
            exit;
        }
    }
}

// Función para verificar si el sitio está desbloqueado
function is_site_unlocked() {
    return isset($_COOKIE['page_bloquer_unlocked']) && $_COOKIE['page_bloquer_unlocked'] === 'true';
}

// Función para bloquear el acceso al sitio
function block_site_access() {
    if (!is_site_unlocked() && !is_admin() && !current_user_can('manage_options')) {
        verify_unlock_code();
        echo show_block_page();
        exit;
    }
}

// Agregar acción para bloquear el acceso al sitio
add_action('template_redirect', 'block_site_access');