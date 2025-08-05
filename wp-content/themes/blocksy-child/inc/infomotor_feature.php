<?php

if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

// add_action( 'wp_enqueue_scripts', function () {
// 	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
// });




// ___ ____ ____  _ ____ ___ ____
//  |  |__| |__/  | |___  |  |__|
//  |  |  | |  \ _| |___  |  |  |


/*
function agregar_texto_metodos_pago_checkout() {
	echo '<div class="custom-payment-text" style="background-color:#fffed7;padding:1rem">
	<div><span>12/25 123</span><input style="background-color:white;" type="text" value="5031 7557 3453 0604"  readonly></div>
	</div>';
}
add_action('woocommerce_review_order_before_payment', 'agregar_texto_metodos_pago_checkout');

*/


// ____ _  _ ____ ____ ___ ____ ____ ___  ____
// [__  |__| |  | |__/  |  |    |  | |  \ |___
// ___] |  | |__| |  \  |  |___ |__| |__/ |___


// Shortcode que añade el formulario personalizado en la pagina del informe
function add_custom_form_shortcode() {
  // if (is_page('nombre-de-tu-pagina')) { // Reemplaza 'nombre-de-tu-pagina' con el slug de tu página
	ob_start();
	?>
	<form id="custom-add-to-cart-form" method="post">
		<label for="placa">Ingrese la placa:</label>
		<input type="text" name="placa" id="placa" placeholder="ABC123" required >
		<button type="submit" style="margin-top:1rem;">Solicitar Informe</button>
	</form>

	<script>
	jQuery(document).ready(function($) {
		$('#custom-add-to-cart-form').on('submit', function(e) {
			e.preventDefault();
			var placa = $('#placa').val();

			// ID del producto digital
			var product_id = 783; // Reemplaza 123 con el ID de tu producto digital

			$.ajax({
				type: 'POST',
				url: wc_add_to_cart_params.ajax_url,
				data: {
						action: 'custom_add_to_cart',
						product_id: product_id,
						placa: placa
				},
				success: function(response) {
						if (response.success) {
								window.location.href = response.data.checkout_url;
						} else {
								alert('Hubo un error. Por favor, inténtelo de nuevo.');
						}
				}
			});
		});
	});
	</script>
	<?php
	return ob_get_clean();
    // }
}
add_shortcode('custom_form', 'add_custom_form_shortcode');


// Manejar la solicitud AJAX para añadir al carrito y obtener la URL del checkout
add_action('wp_ajax_custom_add_to_cart', 'handle_custom_add_to_cart');
// add_action('wp_ajax_nopriv_custom_add_to_cart', 'handle_custom_add_to_cart');
function handle_custom_add_to_cart() {
    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $placa = sanitize_text_field($_POST['placa']);

    // Limpiar el carrito antes de añadir el nuevo producto
    WC()->cart->empty_cart();

    // Añadir el producto al carrito
    $added = WC()->cart->add_to_cart($product_id, 1);

    if ($added) {
        // Guardar el valor de la placa en los metadatos del carrito
        WC()->session->set('placa', $placa);

        wp_send_json_success(array(
            'checkout_url' => wc_get_checkout_url()
        ));
    } else {
        wp_send_json_error();
    }

    wp_die();
}

// Añadir el valor de la placa a los metadatos del pedido
add_action('woocommerce_checkout_create_order', 'add_placa_to_order_meta');
function add_placa_to_order_meta($order) {
    $placa = WC()->session->get('placa');
    if (!empty($placa)) {
        $order->update_meta_data('placa', $placa);
        WC()->session->__unset('placa');
    }
}

// ___  ____ ____ ___  _  _ ____ ____    ___  ____ _       ____ _  _ ____ ____ _  _ ____ _  _ ___
// |  \ |___ [__  |__] |  | |___ [__     |  \ |___ |       |    |__| |___ |    |_/  |  | |  |  |
// |__/ |___ ___] |    |__| |___ ___]    |__/ |___ |___    |___ |  | |___ |___ | \_ |__| |__|  |

// Redirigir a una página personalizada después del checkout

/*
add_action('woocommerce_thankyou', 'redirect_after_checkout', 10, 1);
function redirect_after_checkout($order_id) {
    $order = wc_get_order($order_id);
    $placa = $order->get_meta('placa');

    if (!empty($placa)) {
        wp_redirect(home_url('/pagina-personalizada/?placa=' . urlencode($placa)));
        exit;
    }
}
*/
// Mostrar el valor de la placa en la página personalizada
add_shortcode('mostrar_placa', 'display_placa_shortcode');
function display_placa_shortcode() {
    if (isset($_GET['placa'])) {
        $placa = sanitize_text_field($_GET['placa']);
        return "La placa ingresada es: " . $placa;
    }
    return "No se encontró información de la placa.";
}


add_action('woocommerce_thankyou', 'redirect_after_checkout', 10, 1);


function redirect_after_checkout($order_id) {
    $order = wc_get_order($order_id);
    $placa = $order->get_meta('placa');

    if (!empty($placa)) {
        // URL de tu aplicación Node.js
        $node_url = 'http://infomotors.pe:3000/generar-informe';

        // Datos para enviar a la aplicación Node.js
        $data = array(
            'order_id' => $order_id,
            'placa' => $placa
        );

        wp_remote_post($node_url, array(
            'method'    => 'POST',
            'body'      => wp_json_encode($data),
            'headers'   => array(
                'Content-Type' => 'application/json',
            ),
            'timeout'   => 5, // Tiempo de espera corto ya que no esperamos la respuesta
        ));

        // Redirigir al usuario a una página personalizada
        wp_redirect(home_url('/informe-en-progreso/?order_id=' . urlencode($order_id)));
        exit;
    }
}



// ___  ____ ___  _ ___  ____
// |__] |___ |  \ | |  \ |  |
// |    |___ |__/ | |__/ |__|

// Cambiar el nombre de "Pedidos" a "Informes" en la página de "Mi cuenta"
add_filter('woocommerce_account_menu_items', 'rename_my_account_orders_to_reports', 10, 1);
function rename_my_account_orders_to_reports($items) {
    if (isset($items['orders'])) {
        $items['orders'] = __('Informes', 'woocommerce');
    }
    return $items;
}


// Añadir la columna "Placa" a la lista de pedidos en "Mi cuenta"
add_filter('woocommerce_account_orders_columns', 'add_placa_column_to_my_account_orders');
function add_placa_column_to_my_account_orders($columns) {
    $new_columns = array();

    foreach ($columns as $key => $column) {
        $new_columns[$key] = $column;
        if ('order-total' === $key) {
            $new_columns['order-placa'] = __('Placa', 'woocommerce');
        }
    }

    return $new_columns;
}

// Rellenar la columna "Placa" en la lista de pedidos en "Mi cuenta"
add_action('woocommerce_my_account_my_orders_column_order-placa', 'display_placa_in_my_account_orders');
function display_placa_in_my_account_orders($order) {
    $placa = $order->get_meta('placa');
    if ($placa) {
        echo esc_html($placa);
    } else {
        echo '-';
    }
}



// Crear una Ruta en WordPress para Obtener el Progreso del Informe
// Crea una ruta personalizada en WordPress para devolver el progreso del informe.

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/progress/(?P<order_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_progress',
    ));
});

function get_progress($data) {

    $order_id = $data['order_id'];
    $order = wc_get_order($order_id);
    $progress = $order->get_meta('progreso_informe');

    return new WP_REST_Response(array('progress' => $progress), 200);
}


// Actualizar la Página de Progreso en WooCommerce mediante AJAX
// Usa JavaScript para hacer solicitudes periódicas a la nueva ruta y actualizar el progreso en la página.


add_shortcode('mostrar_progreso', 'display_progress_shortcode');
function display_progress_shortcode() {
    if (isset($_GET['order_id'])) {
        ?>
        <div id="progress-container">
            <p>Progreso del informe: <span id="progress-value">0</span>%</p>
        </div>
        <script>
        jQuery(document).ready(function($) {
            function checkProgress() {
                var orderId = '<?php echo $_GET['order_id']; ?>';
                $.get('/wp-json/custom/v1/progress/' + orderId, function(data) {
                    console.log(data)
                    const progreso = data.progress==='' ? '0' : data.progress ;
                    $('#progress-value').text(progreso);
                    if (data.progress < 100) {
                        setTimeout(checkProgress, 1000);
                    } else {
                        // Redirigir o mostrar un mensaje cuando el informe esté completo
                        window.location.href = '/informe-listo/?order_id=' + orderId;
                    }
                });
            }

            checkProgress();
        });
        </script>
        <?php
    }
}
