<?php
/*
Plugin Name: Método de Pago Personalizado
Description: Añade un método de pago que muestra un texto y un enlace.
Version: 1.0
Author: Guillermo
*/



// ██╗   ██╗ █████╗ ██████╗ ███████╗
// ╚██╗ ██╔╝██╔══██╗██╔══██╗██╔════╝
//  ╚████╔╝ ███████║██████╔╝█████╗
//   ╚██╔╝  ██╔══██║██╔═══╝ ██╔══╝
//    ██║   ██║  ██║██║     ███████╗
//    ╚═╝   ╚═╝  ╚═╝╚═╝     ╚══════╝

// Encolar el CSS en el frontend
add_action('wp_enqueue_scripts', 'mpersonalizado_enqueue_styles');
function mpersonalizado_enqueue_styles() {
    if (is_checkout()) {
        wp_enqueue_style(
            'mpersonalizado-styles',
            plugin_dir_url(__FILE__) . 'assets/css/estilos.css',
            array(),
            '1.0',
            'all'
        );
    }
}

// Añade este código al archivo functions.php de tu tema activo o crea un plugin personalizado

// Agrega el método de pago personalizado a WooCommerce
add_filter('woocommerce_payment_gateways', 'agregar_metodo_pago_personalizado');
function agregar_metodo_pago_personalizado($metodos) {
    $metodos[] = 'WC_Metodo_Pago_Personalizado';
    return $metodos;
}

// Inicializa la clase del método de pago personalizado
add_action('plugins_loaded', 'inicializar_metodo_pago_personalizado');
function inicializar_metodo_pago_personalizado() {
    class WC_Metodo_Pago_Personalizado extends WC_Payment_Gateway {
        public function __construct() {
            $this->id = 'pago_personalizado';
            $this->method_title = __('Pago Personalizado', 'woocommerce');
            $this->method_description = __('Método de pago personalizado con texto y enlace', 'woocommerce');
            $this->has_fields = false;

            // Carga la configuración
            $this->init_form_fields();
            $this->init_settings();

            // Define las variables configurables
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');

            // Acciones
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            add_action('woocommerce_thankyou_' . $this->id, array($this, 'pagina_gracias'));
        }

        // Opciones en el administrador
        public function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title'   => __('Activar/Desactivar', 'woocommerce'),
                    'type'    => 'checkbox',
                    'label'   => __('Activar Pago Personalizado', 'woocommerce'),
                    'default' => 'yes'
                ),
                'title' => array(
                    'title'       => __('Título', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Título que se muestra durante el proceso de pago.', 'woocommerce'),
                    'default'     => 'Solicita tu informe por whatsapp',
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => __('Descripción', 'woocommerce'),
                    'type'        => 'textarea',
                    'description' => __('Descripción que se muestra durante el proceso de pago.', 'woocommerce'),
                    'default'     => '<a target="_blank" href="https://api.whatsapp.com/send/?phone=51987431018&amp;text=Hola%2C+quisiera+solicitar+un+informe+de+la+placa&amp;type=phone_number&amp;app_absent=0">Yapea al N° 987431018 A: Grupo Infomotors
Envíanos la constancia por WhatsApp (a este mismo número)
Y obtén en minutos el informe de la placa.</a>',
                ),
                'instrucciones' => array(
                    'title'       => __('Instrucciones', 'woocommerce'),
                    'type'        => 'textarea',
                    'description' => '',
                    'default'     => '',
                ),
                'url_redireccion' => array(
                    'title'       => __('URL de Redirección', 'woocommerce'),
                    'type'        => 'text',
                    'description' => __('Enlace al que se redirigirá al cliente después de realizar el pedido.', 'woocommerce'),
                    'default'     => 'https://api.whatsapp.com/send/?phone=51987431018&text=Hola%2C+quisiera+solicitar+el+informe+de+la+placa+[placa]&type=phone_number&app_absent=0', // Reemplaza con tu enlace
                    'desc_tip'    => true,
                ),
            );
        }

        // Procesa el pago
        public function process_payment($order_id) {
            $order = wc_get_order($order_id);

            // Marca el pedido como en espera
            $order->update_status('on-hold', __('En espera de pago personalizado', 'woocommerce'));

            // Vacía el carrito
            WC()->cart->empty_cart();

            // Redirecciona al cliente
            return array(
                'result'   => 'success',
                'redirect' => str_replace(["&amp;","[placa]"],["&","ABCABC"],$this->get_option('url_redireccion')),
            );
        }

        // Página de agradecimiento
        public function pagina_gracias() {
            if ($this->get_option('instrucciones')) {
                echo wpautop($this->get_option('instrucciones'));
            }
        }
    }
}

