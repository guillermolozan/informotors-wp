<?php

// DESACTIVA TODOS LOS EMAILS DE WOOCOMMERCE EN ENTORNO LOCAL (solo para pruebas)
add_filter('woocommerce_email_enabled_new_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_processing_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_completed_order', '__return_false');
add_filter('woocommerce_email_enabled_cancelled_order', '__return_false');
add_filter('woocommerce_email_enabled_failed_order', '__return_false');
add_filter('woocommerce_email_enabled_on_hold_order', '__return_false');
add_filter('woocommerce_email_enabled_refunded_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_refunded_order', '__return_false');
add_filter('woocommerce_email_enabled_customer_invoice', '__return_false');
add_filter('woocommerce_email_enabled_customer_note', '__return_false');
add_filter('woocommerce_email_enabled_customer_new_account', '__return_false');
add_filter('woocommerce_email_enabled_customer_reset_password', '__return_false');

$MODO_PRUEBA=true;

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

// ███████╗ ██████╗ ██╗     ██╗ ██████╗██╗████████╗ █████╗     ████████╗██╗   ██╗    ██╗███╗   ██╗███████╗ ██████╗ ██████╗ ███╗   ███╗███████╗
// ██╔════╝██╔═══██╗██║     ██║██╔════╝██║╚══██╔══╝██╔══██╗    ╚══██╔══╝██║   ██║    ██║████╗  ██║██╔════╝██╔═══██╗██╔══██╗████╗ ████║██╔════╝
// ███████╗██║   ██║██║     ██║██║     ██║   ██║   ███████║       ██║   ██║   ██║    ██║██╔██╗ ██║█████╗  ██║   ██║██████╔╝██╔████╔██║█████╗
// ╚════██║██║   ██║██║     ██║██║     ██║   ██║   ██╔══██║       ██║   ██║   ██║    ██║██║╚██╗██║██╔══╝  ██║   ██║██╔══██╗██║╚██╔╝██║██╔══╝
// ███████║╚██████╔╝███████╗██║╚██████╗██║   ██║   ██║  ██║       ██║   ╚██████╔╝    ██║██║ ╚████║██║     ╚██████╔╝██║  ██║██║ ╚═╝ ██║███████╗
// ╚══════╝ ╚═════╝ ╚══════╝╚═╝ ╚═════╝╚═╝   ╚═╝   ╚═╝  ╚═╝       ╚═╝    ╚═════╝     ╚═╝╚═╝  ╚═══╝╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝╚══════╝

// ____ ____ ____ _  _ _  _ _    ____ ____ _ ____
// |___ |  | |__/ |\/| |  | |    |__| |__/ | |  |
// |    |__| |  \ |  | |__| |___ |  | |  \ | |__|

// Shortcode que añade el formulario personalizado en la pagina del FORMULARIO DE SOLICITUD DEL INFORME
add_shortcode('solicita_tu_informe', 'display_solicita_tu_informe');
function display_solicita_tu_informe() {

    global $MODO_PRUEBA;

    /*
	ob_start();
    echo "<div style='font-weight:bold;color:red;display:block;'>En Revisión</div>";
    return ob_get_clean();
    */
    
    $disabled=false;
    $mensaje_temporal='';
    $disabled_temporal='';
    if($disabled){
        $mensaje_temporal='<div class="temporal">Temporalmente no se pueden solicitar informes.<br>Estamos trabajando para solucionarlo.</div>';
        $disabled_temporal='disabled';
    }
	ob_start();
    $default='';
    echo $mensaje_temporal;
	?>
	<form id="custom-add-to-cart-form" method="post">
        <label for="placa">Ingrese la placa:</label>
        <input type="text" name="placa" id="placa" placeholder="ABC123" required <?php echo $disabled_temporal; ?> value="<?php echo $MODO_PRUEBA ? 'F6D418' : ''; ?>" >
        <button type="submit" class="ct-button" style="margin-top:1rem;" <?php echo $disabled_temporal; ?> >Solicitar Informe</button>
	</form>
	<style>
        .temporal {
            background:yellow;
            padding:1rem;
        }
		#custom-add-to-cart-form {
			label {
				display:block;
			}
    	    input { 
				max-width: 100px;
				display: block;
			}
			 button {
				display: block;
			}
 		}
	</style>
	<script>
	jQuery(document).ready(function($) {
        // Enfocar el input al cargar la página
        $('#placa').focus();
        // Validar el input según las reglas específicas
        $('#placa').on('input', function() {
            var value = $(this).val().toUpperCase();
            var newValue = '';

            // Aplicar reglas específicas para cada posición
            if (value.length > 0 && /^[A-Z]$/.test(value[0])) {
                newValue += value[0];
            } else if (value.length > 0) {
                newValue += '';
            }

            if (value.length > 1 && /^[A-Z0-9]$/.test(value[1])) {
                newValue += value[1];
            } else if (value.length > 1) {
                newValue += '';
            }

            if (value.length > 2 && /^[A-Z]$/.test(value[2])) {
                newValue += value[2];
            } else if (value.length > 2) {
                newValue += '';
            }

            for (var i = 3; i < 6; i++) {
                if (value.length > i && /^[0-9]$/.test(value[i])) {
                    newValue += value[i];
                } else if (value.length > i) {
                    newValue += '';
                }
            }

            $(this).val(newValue);

            // Habilitar/deshabilitar el botón de envío
            if (newValue.length === 6) {
                $('button[type="submit"]').prop('disabled', false);
            } else {
                $('button[type="submit"]').prop('disabled', true);
            }
        });

        // Enviar el formulario al presionar Enter
        $('#placa').on('keypress', function(e) {
            if (e.which === 13 && $(this).val().length === 6) {
                $('#custom-add-to-cart-form').submit();
            }
        });

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
        // $('#placa').val('<?php echo $default;?>');
	});
	</script>
	<?php
	return ob_get_clean();
}

// ____  _ ____ _  _
// |__|  | |__|  \/
// |  | _| |  | _/\_


// Manejar la solicitud AJAX para añadir al carrito y obtener la URL del checkout
add_action('wp_ajax_custom_add_to_cart', 'handle_custom_add_to_cart');
add_action('wp_ajax_nopriv_custom_add_to_cart', 'handle_custom_add_to_cart');
function handle_custom_add_to_cart() {
    //    
    $placa = sanitize_text_field($_POST['placa']);

    if (empty($placa)) {
        wp_send_json_error(array('message' => 'El campo de placa es obligatorio.'));
        wp_die();
    }

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));

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
// ___  ____ ____ ___  _  _ ____ ____    ___  ____ _       ____ _  _ ____ ____ _  _ ____ _  _ ___
// |  \ |___ [__  |__] |  | |___ [__     |  \ |___ |       |    |__| |___ |    |_/  |  | |  |  |
// |__/ |___ ___] |    |__| |___ ___]    |__/ |___ |___    |___ |  | |___ |___ | \_ |__| |__|  |

// Añadir el valor de la placa a los metadatos del pedido
add_action('woocommerce_checkout_create_order', 'add_placa_to_order_meta');
function add_placa_to_order_meta($order) {
    try {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('ENTRANDO A add_placa_to_order_meta. SESSION: ' . print_r(WC()->session, true));
        }
        $placa = WC()->session->get('placa');
        if (!empty($placa)) {
            $order->update_meta_data('placa', $placa);
            WC()->session->__unset('placa');
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('PLACA GUARDADA CORRECTAMENTE EN EL PEDIDO: ' . $placa);
            }
        } else {
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('FALTA PLACA EN LA SESIÓN AL CREAR PEDIDO. SESSION: ' . print_r(WC()->session, true));
            }
            wc_add_notice('Error: Falta la placa del vehículo. Por favor, vuelve a ingresar la placa antes de finalizar la compra.', 'error');
            throw new Exception('Falta la placa del vehículo en la sesión.');
        }
    } catch (Exception $e) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('EXCEPCIÓN EN add_placa_to_order_meta: ' . $e->getMessage());
        }
        wc_add_notice('Error inesperado al guardar la placa del vehículo: ' . $e->getMessage(), 'error');
        throw $e;
    }
}
// Validacion en el carrito // agosto 24
/*
add_action('woocommerce_check_cart_items', 'check_cart_for_placa');
function check_cart_for_placa() {
  if (is_cart() || is_checkout()) {
    $placa = WC()->session->get('placa');
    if (empty($placa)) {
      wc_add_notice('Debe ingresar una placa para continuar con el proceso de compra.', 'error');
    }
  }
}
*/

// Validacion en el checkout // setiembre 24
// product_id = 783; 
// Forzar los valores correctos en el POST antes de la validación de WooCommerce
add_action('woocommerce_checkout_process', function() {
    $_POST['billing_state'] = 'Lima Metropolitana';
    $_POST['billing_city'] = 'Lima';
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('CAMPOS ENVIADOS EN CHECKOUT: ' . print_r($_POST, true));
    }
});

add_action('woocommerce_checkout_process', 'validate_placa_at_checkout');
function validate_placa_at_checkout() {
  // ID del producto que deseas validar
  $product_id_to_validate = 783;
  
  // Obtener productos del carrito
  $cart = WC()->cart->get_cart();
  
  // Variable para saber si el producto 783 está en el carrito
  $is_product_in_cart = false;
  
  foreach ($cart as $cart_item) {
    $product_id = $cart_item['product_id'];
    if ($product_id == $product_id_to_validate) {
      $is_product_in_cart = true;
      break;
    }
  }

  if ($is_product_in_cart) {
    $placa = WC()->session->get('placa');
    if (defined('WP_DEBUG') && WP_DEBUG) {
      error_log('VALIDACIÓN PLACA CHECKOUT: Valor de placa en sesión: ' . print_r($placa, true));
    }
    if (empty($placa)) {
      wc_add_notice('Error: Falta la placa del vehículo en la sesión al validar el checkout. Por favor, vuelve a ingresar la placa.', 'error');
    }
  }
}


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
/*
add_shortcode('mostrar_placa', 'display_placa_shortcode');
function display_placa_shortcode() {
    if (isset($_GET['placa'])) {
        $placa = sanitize_text_field($_GET['placa']);
        return "La placa ingresada es: " . $placa;
    }
    return "No se encontró información de la placa.";
}
*/

//  █████╗  ██████╗████████╗██╗ ██████╗ ███╗   ██╗     ██████╗ ███████╗███╗   ██╗███████╗██████╗  █████╗ ██████╗     ██╗███╗   ██╗███████╗ ██████╗ ██████╗ ███╗   ███╗███████╗
// ██╔══██╗██╔════╝╚══██╔══╝██║██╔═══██╗████╗  ██║    ██╔════╝ ██╔════╝████╗  ██║██╔════╝██╔══██╗██╔══██╗██╔══██╗    ██║████╗  ██║██╔════╝██╔═══██╗██╔══██╗████╗ ████║██╔════╝
// ███████║██║        ██║   ██║██║   ██║██╔██╗ ██║    ██║  ███╗█████╗  ██╔██╗ ██║█████╗  ██████╔╝███████║██████╔╝    ██║██╔██╗ ██║█████╗  ██║   ██║██████╔╝██╔████╔██║█████╗
// ██╔══██║██║        ██║   ██║██║   ██║██║╚██╗██║    ██║   ██║██╔══╝  ██║╚██╗██║██╔══╝  ██╔══██╗██╔══██║██╔══██╗    ██║██║╚██╗██║██╔══╝  ██║   ██║██╔══██╗██║╚██╔╝██║██╔══╝
// ██║  ██║╚██████╗   ██║   ██║╚██████╔╝██║ ╚████║    ╚██████╔╝███████╗██║ ╚████║███████╗██║  ██║██║  ██║██║  ██║    ██║██║ ╚████║██║     ╚██████╔╝██║  ██║██║ ╚═╝ ██║███████╗
// ╚═╝  ╚═╝ ╚═════╝   ╚═╝   ╚═╝ ╚═════╝ ╚═╝  ╚═══╝     ╚═════╝ ╚══════╝╚═╝  ╚═══╝╚══════╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝  ╚═╝    ╚═╝╚═╝  ╚═══╝╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝╚══════╝

// Añadir una nueva acción al menú de acciones de la administración del pedido
add_filter('woocommerce_order_actions', 'agregar_accion_personalizada');

function agregar_accion_personalizada($actions) {
  $actions['trigger_generar_informe'] = __('Generar Informe (reintento)', 'woocommerce');
  return $actions;
}

// Ejecutar la función cuando la acción personalizada es seleccionada
add_action('woocommerce_order_action_trigger_generar_informe', 'trigger_generar_informe');

// ____ ___  _
// |__| |__] |
// |  | |    |

add_action('rest_api_init', function () {
    register_rest_route('wc/v3', '/orders/(?P<id>\d+)/trigger_generar_informe', array(
      'methods' => 'POST',
      'callback' => 'trigger_generar_informe_via_rest',
      'permission_callback' => '__return_true', // Cambia esta función por una verificación de permisos si es necesario
    ));
  });
  
  function trigger_generar_informe_via_rest($data) {
    $order_id = $data['id'];
  
    if (!$order_id) {
      return new WP_Error('no_order', 'Pedido no especificado', array('status' => 400));
    }
  
    $order = wc_get_order($order_id);
  
    if (!$order) {
      return new WP_Error('invalid_order', 'Pedido no válido', array('status' => 404));
    }
  
    // Aquí ejecutamos la acción personalizada que ya tienes registrada
    do_action('woocommerce_order_action_trigger_generar_informe', $order);
  
    return new WP_REST_Response('Informe generado para el pedido ' . $order_id, 200);
  }
  

//  ██████╗██╗  ██╗███████╗ ██████╗██╗  ██╗ ██████╗ ██╗   ██╗████████╗
// ██╔════╝██║  ██║██╔════╝██╔════╝██║ ██╔╝██╔═══██╗██║   ██║╚══██╔══╝
// ██║     ███████║█████╗  ██║     █████╔╝ ██║   ██║██║   ██║   ██║
// ██║     ██╔══██║██╔══╝  ██║     ██╔═██╗ ██║   ██║██║   ██║   ██║
// ╚██████╗██║  ██║███████╗╚██████╗██║  ██╗╚██████╔╝╚██████╔╝   ██║
//  ╚═════╝╚═╝  ╚═╝╚══════╝ ╚═════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝    ╚═╝

// ____ ____ ____ _  _ _  _ _    ____ ____ _ ____    ___  ____    ___  ____ ____ ____
// |___ |  | |__/ |\/| |  | |    |__| |__/ | |  |    |  \ |___    |__] |__| | __ |  |
// |    |__| |  \ |  | |__| |___ |  | |  \ | |__|    |__/ |___    |    |  | |__] |__|
#region formulario de pago

// modificar labels de los campos
add_filter( 'woocommerce_default_address_fields', 'customizar_fields' );

function customizar_fields( $fields ) {
	$fields['country']['label'] = 'País'; 
	$fields['state']['label'] = 'Destino / Distrito'; 
	$fields['city']['label'] = 'Localidad';
	$fields['city']['required'] = false;
	$fields['state']['priority'] = 45;
	$fields['city']['priority'] = 46; 



	
	return $fields;
}


add_filter( 'woocommerce_checkout_fields', 'customizar_checkout_fields' );

function customizar_checkout_fields( $fields ) {
	
    global $MODO_PRUEBA;

    if($MODO_PRUEBA){

        $fields['billing']['billing_first_name']['default'] = "Cheddar";
        $fields['shipping']['shipping_first_name']['default'] = "Cheddar";

        $fields['billing']['billing_last_name']['default'] = "Cheddar";
        $fields['shipping']['shipping_last_name']['default'] = "Cheddar";

        $fields['billing']['billing_phone']['default'] = "999888777";
        $fields['shipping']['shipping_phone']['default'] = "999888777";

        $fields['billing']['billing_email']['default'] = "cheddar@w.p";
        $fields['shipping']['shipping_email']['default'] = "cheddar@w.p";

    }

	$fields['billing']['billing_first_name']['label'] = "Nombres";
	$fields['shipping']['shipping_first_name']['label'] = "Nombres";

	$fields['billing']['billing_phone']['label'] = "Celular";
	$fields['shipping']['shipping_phone']['label'] = "Celular";

	$fields['billing']['billing_email']['label'] = "Correo electrónico";
	$fields['shipping']['shipping_email']['label'] = "Correo electrónico";

	$fields['billing']['billing_email']['priority'] = 35;
	$fields['billing']['billing_phone']['priority'] = 36;

	$fields['billing']['billing_email']['class'] = array( 'form-row-first');
	$fields['billing']['billing_phone']['class'] = array( 'form-row-last');

	unset($fields['billing']['billing_company']); 
	unset($fields['shipping']['shipping_company']); 

	$fields['billing']['billing_country']['class'][] = 'ocultar_campo';
	$fields['shipping']['shipping_country']['class'][] = 'ocultar_campo';

	$fields['billing']['billing_postcode']['required'] = false;
	$fields['shipping']['shipping_postcode']['required'] = false;

	unset($fields['billing']['billing_postcode']); 
	unset($fields['shipping']['shipping_postcode']); 



    // NO eliminar address_1 ni country, solo ocultar y dar valor por defecto
    $fields['billing']['billing_address_1']['class'][] = 'ocultar_campo';
    $fields['billing']['billing_address_1']['default'] = '-';
    $fields['billing']['billing_country']['class'][] = 'ocultar_campo';
    $fields['billing']['billing_country']['default'] = 'PE'; // Perú

    unset($fields['billing']['billing_address_2']);
    // NO eliminar city ni state, solo ocultar y poner valor por defecto
    $fields['billing']['billing_city']['class'][] = 'ocultar_campo';
    $fields['billing']['billing_city']['default'] = 'Lima';
    $fields['billing']['billing_state']['class'][] = 'ocultar_campo';
    $fields['billing']['billing_state']['default'] = 'Lima Metropolitana';
    // Forzar value también para el POST
    add_filter('woocommerce_checkout_posted_data', function($data) {
        $data['billing_state'] = 'Lima Metropolitana';
        $data['billing_city'] = 'Lima';
        return $data;
    }, 99); // prioridad ALTA para sobrescribir

    // Forzar valor en el objeto Order antes de guardar
    add_action('woocommerce_checkout_create_order', function($order) {
        $order->set_billing_state('Lima Metropolitana');
        $order->set_billing_city('Lima');
    }, 99);


  return $fields;
}

// ██████╗ ███╗   ██╗██╗
// ██╔══██╗████╗  ██║██║
// ██║  ██║██╔██╗ ██║██║
// ██║  ██║██║╚██╗██║██║
// ██████╔╝██║ ╚████║██║
// ╚═════╝ ╚═╝  ╚═══╝╚═╝

// Agregar el campo DNI en la página de finalizar compra
add_action( 'woocommerce_after_order_notes', 'agregar_campo_dni_finalizar_compra' );
function agregar_campo_dni_finalizar_compra( $checkout ) {

    global $MODO_PRUEBA;

    $checkout_values= array(
        'type'        => 'text',
        'class'       => array('form-row-first'),
        'label'       => __('DNI'),
        'placeholder' => __('Ingresa tu DNI'),
        'required'    => true,
    );
    if($MODO_PRUEBA){
        $checkout_values['default'] = '12345678';
    }

    woocommerce_form_field( 'dni', $checkout_values , $checkout->get_value( 'dni' ));
    
}

// Guardar el campo DNI al completar el pedido
add_action( 'woocommerce_checkout_update_order_meta', 'guardar_dni_en_pedido' );
function guardar_dni_en_pedido( $order_id ) {
  if ( ! empty( $_POST['dni'] ) ) {
    update_post_meta( $order_id, 'dni', sanitize_text_field( $_POST['dni'] ) );
  }
}

// Mostrar el campo DNI en la página de edición de pedidos en el admin
add_action( 'woocommerce_admin_order_data_after_billing_address', 'mostrar_dni_en_admin_pedido', 10, 1 );
function mostrar_dni_en_admin_pedido( $order ) {
  $dni = get_post_meta( $order->get_id(), 'dni', true );
  if ( $dni ) {
    echo '<p><strong>' . __( 'DNI' ) . ':</strong> ' . esc_html( $dni ) . '</p>';
  }
}

// Mostrar el campo DNI en los detalles del pedido en la cuenta del cliente
add_action( 'woocommerce_order_details_after_customer_details', 'mostrar_dni_en_detalle_pedido' );
function mostrar_dni_en_detalle_pedido( $order ) {
  $dni = get_post_meta( $order->get_id(), 'dni', true );
  if ( $dni ) {
    echo '<p><strong>' . __( 'DNI' ) . ':</strong> ' . esc_html( $dni ) . '</p>';
  }
}


//

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

// cambiar el titulo del formulario


function cambios_en_el_footer() {
	if ( is_checkout() ) {
        ?>
        <script type="text/javascript">
        jQuery( document ).ready(function( $ ) {
            // $('.woocommerce-billing-fields h3' ).text('Detalles de Envio y Boleta Electrónica'); // Asegúrate de que este es el selector correcto para tu tema.
        });
        </script>
        <style>
            .ocultar_campo {
                display: none !important;
            }
        </style>
        <?php
	}
}
add_action( 'wp_footer', 'cambios_en_el_footer' );

add_filter( 'woocommerce_states', 'custom_woocommerce_states' );

function custom_woocommerce_states( $states ) {
    $nuevos_estados= array(
			'LIPO' => __('--- Destinos en Callao---','woocommerce'),
			'BLLV' => __('Callao - Bellavista','woocommerce'),
			'CLLO' => __('Callao - Callao','woocommerce'),
			'CLGR' => __('Callao - Carmen de la Legua','woocommerce'),
			'LPER' => __('Callao - La Perla','woocommerce'),
			'LPUN' => __('Callao - La Punta','woocommerce'),
			'VENT' => __('Callao - Ventanilla','woocommerce'),
			'MIPE' => __('Callao - Mi Perú','woocommerce'),
			'LIOL' => __('--- Destinos en Lima---','woocommerce'),
			'ANNC' => __('Lima - Ancón','woocommerce'),
			'ATEE' => __('Lima - Ate','woocommerce'),
			'BARR' => __('Lima - Barranco','woocommerce'),
			'BREN' => __('Lima - Breña','woocommerce'),
			'CARY' => __('Lima - Carabayllo','woocommerce'),
			'CHCL' => __('Lima - Chaclacayo','woocommerce'),
			'CHOR' => __('Lima - Chorrillos','woocommerce'),
			'CNGL' => __('Lima - Cieneguilla','woocommerce'),
			'COMA' => __('Lima - Comas','woocommerce'),
			'EAGT' => __('Lima - El Agustino','woocommerce'),
			'INDE' => __('Lima - Independencia','woocommerce'),
			'JMAR' => __('Lima - Jesus María','woocommerce'),
			'LMIN' => __('Lima - La Molina','woocommerce'),
			'LVIC' => __('Lima - La Victoria','woocommerce'),
			'LCER' => __('Lima - Lima Cercado','woocommerce'),
			'LNCE' => __('Lima - Lince','woocommerce'),
			'LOLI' => __('Lima - Los Olivos','woocommerce'),
			'LURG' => __('Lima - Lurigancho','woocommerce'),
			'LURN' => __('Lima - Lurín','woocommerce'),
			'MGDM' => __('Lima - Magdalena del Mar','woocommerce'),
			'MIRA' => __('Lima - Miraflores','woocommerce'),
			'PCHM' => __('Lima - Pachacámac','woocommerce'),
			'PCSN' => __('Lima - Pucusana','woocommerce'),
			'PLIB' => __('Lima - Pueblo Libre','woocommerce'),
			'PNTP' => __('Lima - Puente Piedra','woocommerce'),
			'PNTH' => __('Lima - Punta Hermosa','woocommerce'),
			'PNTN' => __('Lima - Punta Negra','woocommerce'),
			'RIMA' => __('Lima - Rímac','woocommerce'),
			'SBRT' => __('Lima - San Bartolo','woocommerce'),
			'SBOR' => __('Lima - San Borja','woocommerce'),
			'SISI' => __('Lima - San Isidro','woocommerce'),
			'SJMI' => __('Lima - San Juan de Miraflores','woocommerce'),
			'SJLU' => __('Lima - San Juan de Lurigancho','woocommerce'),
			'SLUI' => __('Lima - San Luis','woocommerce'),
			'SMPO' => __('Lima - San Martín de Porres','woocommerce'),
			'SMIG' => __('Lima - San Miguel','woocommerce'),
			'SANT' => __('Lima - Santa Anita','woocommerce'),
			'SMDM' => __('Lima - Santa María del Mar','woocommerce'),
			'SNTR' => __('Lima - Santa Rosa','woocommerce'),
			'SURC' => __('Lima - Santiago de Surco','woocommerce'),
			'SRQU' => __('Lima - Surquillo','woocommerce'),
			'VESL' => __('Lima - Villa El Salvador','woocommerce'),
			'VLLM' => __('Lima - Villa María del Triunfo','woocommerce'),
    );

		$states['PE'] = array_merge($states['PE'], $nuevos_estados);

    return $states;
}

// ___  ____ ____ ___  _  _ ____ ____    ___  ____ _       ____ _  _ ____ ____ _  _ ____ _  _ ___
// |  \ |___ [__  |__] |  | |___ [__     |  \ |___ |       |    |__| |___ |    |_/  |  | |  |  |
// |__/ |___ ___] |    |__| |___ ___]    |__/ |___ |___    |___ |  | |___ |___ | \_ |__| |__|  |

add_action('woocommerce_thankyou', 'trigger_generar_informe_page', 10, 1);
function trigger_generar_informe_page($order_id) {
    $order = wc_get_order($order_id);
    trigger_generar_informe($order);
}

function trigger_generar_informe($order) {
    //
    $order_id=$order->get_id();
    $placa = $order->get_meta('placa');
    // poner el meta status = progress
    $order->update_meta_data('status', 'progress');
    if (!empty($placa)) {
        // URL de tu aplicación Node.js
        if($_SERVER['HTTP_HOST']==='localhost:10160'){
            $dominio_scraper='http://localhost:3000';
        } else {
            $dominio_scraper='http://infomotors.pe:3000';
            // $dominio_scraper='http://srv543773.hstgr.cloud:3000';
        }
        $node_url = $dominio_scraper.'/generar-informe';

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
        wp_redirect(home_url('/informe-en-progreso/?order_id=' . urlencode($order_id).'&r='.rand(1, 1000000)));
        exit;
    }
}





// Crear una Ruta en WordPress para Obtener el Progreso del Informe
// Crea una ruta personalizada en WordPress para devolver el progreso del informe.

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/progress/(?P<order_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_progress',
        'permission_callback' => '__return_true', // Agrega esta línea para rutas públicas
    ));
});

function get_progress($data) {

    $order_id = $data['order_id'];
    $order = wc_get_order($order_id);
    $progress = $order->get_meta('progreso_informe');
    $message = $order->get_meta('message');
    $status = $order->get_meta('status');

    return new WP_REST_Response(array('progress' => $progress,'message' => $message,'status' => $status), 200);
}


// Actualizar la Página de Progreso en WooCommerce mediante AJAX
// Usa JavaScript para hacer solicitudes periódicas a la nueva ruta y actualizar el progreso en la página.

// ██╗███╗   ██╗███████╗ ██████╗ ██████╗ ███╗   ███╗███████╗    ███████╗███╗   ██╗    ██████╗ ██████╗  ██████╗  ██████╗ ██████╗ ███████╗███████╗ ██████╗
// ██║████╗  ██║██╔════╝██╔═══██╗██╔══██╗████╗ ████║██╔════╝    ██╔════╝████╗  ██║    ██╔══██╗██╔══██╗██╔═══██╗██╔════╝ ██╔══██╗██╔════╝██╔════╝██╔═══██╗
// ██║██╔██╗ ██║█████╗  ██║   ██║██████╔╝██╔████╔██║█████╗      █████╗  ██╔██╗ ██║    ██████╔╝██████╔╝██║   ██║██║  ███╗██████╔╝█████╗  ███████╗██║   ██║
// ██║██║╚██╗██║██╔══╝  ██║   ██║██╔══██╗██║╚██╔╝██║██╔══╝      ██╔══╝  ██║╚██╗██║    ██╔═══╝ ██╔══██╗██║   ██║██║   ██║██╔══██╗██╔══╝  ╚════██║██║   ██║
// ██║██║ ╚████║██║     ╚██████╔╝██║  ██║██║ ╚═╝ ██║███████╗    ███████╗██║ ╚████║    ██║     ██║  ██║╚██████╔╝╚██████╔╝██║  ██║███████╗███████║╚██████╔╝
// ╚═╝╚═╝  ╚═══╝╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝╚══════╝    ╚══════╝╚═╝  ╚═══╝    ╚═╝     ╚═╝  ╚═╝ ╚═════╝  ╚═════╝ ╚═╝  ╚═╝╚══════╝╚══════╝ ╚═════╝


add_shortcode('informe_en_progreso', 'display_informe_en_progreso');
function display_informe_en_progreso() {


    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);
        $order = wc_get_order($order_id);   
        ?>
        <h2>
            <span style="color:black;">El informe de la placa</span>
            <span style="color:#ff5005;"><?php echo esc_html($order->get_meta('placa')); ?></span>
            <span style="color:black;">se está generando</span>
        </h2>
        <div class="progress-bar-container">
            <div id="progress-bar" class="progress-bar">
                <h2 id="progress-value" class="progress-value">0%</h2>
            </div>
        </div>
        <style>
            .progress-bar-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 25px;
            overflow: hidden;
            height: 50px;
            margin: 20px 0;
            display:none;
            }

            .progress-bar {
            width: 0%;
            height: 100%;
            background-color: #2e72d1;
            border-radius: 25px 0 0 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: width 0.3s ease;
            }

            .progress-value {
            color: white;
            font-weight: bold;
            margin:0px;
            }
            @media (max-width: 700px) {

                .progress-bar-container { width:100% !important; border-radius: 0; }
                .progress-bar { border-radius: 0; }
                .progress-bar h2 { font-size:20px; }
                embed { display: none; }
                
            }
        </style>
        <script>
        jQuery(document).ready(function($) {
            let percentage
            function checkProgress() {
                var orderId = '<?php echo $_GET['order_id']; ?>';
                $.get('/wp-json/custom/v1/progress/' + orderId + '?r=' + Math.random(), function(data) {
                    percentage = data.progress ? ( (data.progress==='' || data.progress==='0') ? '5' : data.progress ) : 5;
                    console.log(percentage)
                    const progressBar = document.getElementById('progress-bar');
                    const progressValue = document.getElementById('progress-value');
                    progressBar.style.width = percentage + '%';
                    progressValue.textContent = Math.round(percentage) + '%';
                    if(parseFloat(percentage)>5){
                        document.querySelector('.progress-bar-container').style.display = 'block';
                    }                    if(data.message==='no existe'){
                        window.location.href = '/placa-no-existe/?order_id=' + orderId;
                    }
                    else if(data.status==='failed'){
                        window.location.href = '/informe-pendiente/?order_id=' + orderId;
                    }
                    else if (percentage === '100') {
                        setTimeout(()=>{
                            // Redirigir o mostrar un mensaje cuando el informe esté completo
                            window.location.href = '/informe-listo/?order_id=' + orderId;
                        }, 4*1000);
                    } else {
                        setTimeout(checkProgress, 5*1000);
                    }
                });
            }


            // Definir un temporizador de 2 minutos (120,000 ms)
            // setTimeout(function() {
            //     console.log('mostrar barra?')
            //     if(parseFloat(percentage)>5){
            //         document.querySelector('.progress-bar-container').style.display = 'block';
            //     }
            // }, 30 * 1000);
            setTimeout(function() {
                if(parseFloat(percentage)<10){
                    window.location.href = '/informe-pendiente/?order_id=' + '<?php echo $_GET['order_id']; ?>';
                }
            }, 1 * 60 * 1000);

            setTimeout(function() {
                if(parseFloat(percentage)<70){
                    window.location.href = '/informe-pendiente/?order_id=' + '<?php echo $_GET['order_id']; ?>';
                }
            }, 2 * 60 * 1000);      
            
            setTimeout(function() {
                window.location.href = '/informe-pendiente/?order_id=' + '<?php echo $_GET['order_id']; ?>';
            }, 3 * 60 * 1000);

            checkProgress();


        });
        </script>
        <?php
    }
}

// ██╗███╗   ██╗███████╗ ██████╗ ██████╗ ███╗   ███╗███████╗    ██╗     ██╗███████╗████████╗ ██████╗
// ██║████╗  ██║██╔════╝██╔═══██╗██╔══██╗████╗ ████║██╔════╝    ██║     ██║██╔════╝╚══██╔══╝██╔═══██╗
// ██║██╔██╗ ██║█████╗  ██║   ██║██████╔╝██╔████╔██║█████╗      ██║     ██║███████╗   ██║   ██║   ██║
// ██║██║╚██╗██║██╔══╝  ██║   ██║██╔══██╗██║╚██╔╝██║██╔══╝      ██║     ██║╚════██║   ██║   ██║   ██║
// ██║██║ ╚████║██║     ╚██████╔╝██║  ██║██║ ╚═╝ ██║███████╗    ███████╗██║███████║   ██║   ╚██████╔╝
// ╚═╝╚═╝  ╚═══╝╚═╝      ╚═════╝ ╚═╝  ╚═╝╚═╝     ╚═╝╚══════╝    ╚══════╝╚═╝╚══════╝   ╚═╝    ╚═════╝


add_shortcode('informe_listo', 'display_informe_listo');
function display_informe_listo() {
    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);
        $order = wc_get_order($order_id);   
        if ($order) {
            $file_show = $order->get_meta('file_show');
            $file_download = $order->get_meta('file_download');
            
            ob_start();
            ?>
            <div>
                <h2>
                    <span style="color:black;">El informe de la placa</span>
                    <span style="color:#ff5005;"><?php echo esc_html($order->get_meta('placa')); ?></span>
                    <span style="color:black;">se ha generado exitosamente</span>
                </h2>
                <div style="display:flex; justify-content:end; margin-bottom:1em;">
                    <!-- <div><h3>Orden : <?php echo esc_html($order_id); ?></h3></div> -->
                    <!-- <div><h3>Placa : <?php echo esc_html($order->get_meta('placa')); ?></h3></div> -->
                    <?php // if ($file_download): ?>
                        <div class="ct-header-cta">
                            <a class="ct-button" data-size="small" href="<?php echo esc_url($file_download); ?>" download>DESCARGAR</a>
                        </div>
                    <?php // endif; ?>
                </div>
                
                <?php //if ($file_show): ?>
                    <embed src="<?php echo esc_url($file_show); ?>" type="application/pdf" width="100%" height="600px" />
                <?php //endif; ?>

            </div>
            <?php
            return ob_get_clean();
        }
    }
    return 'Order not found.';
}

// ███████╗███╗   ██╗     ██████╗ █████╗ ███████╗ ██████╗     ██████╗ ███████╗    ███████╗ █████╗ ██╗     ██╗      █████╗
// ██╔════╝████╗  ██║    ██╔════╝██╔══██╗██╔════╝██╔═══██╗    ██╔══██╗██╔════╝    ██╔════╝██╔══██╗██║     ██║     ██╔══██╗
// █████╗  ██╔██╗ ██║    ██║     ███████║███████╗██║   ██║    ██║  ██║█████╗      █████╗  ███████║██║     ██║     ███████║
// ██╔══╝  ██║╚██╗██║    ██║     ██╔══██║╚════██║██║   ██║    ██║  ██║██╔══╝      ██╔══╝  ██╔══██║██║     ██║     ██╔══██║
// ███████╗██║ ╚████║    ╚██████╗██║  ██║███████║╚██████╔╝    ██████╔╝███████╗    ██║     ██║  ██║███████╗███████╗██║  ██║
// ╚══════╝╚═╝  ╚═══╝     ╚═════╝╚═╝  ╚═╝╚══════╝ ╚═════╝     ╚═════╝ ╚══════╝    ╚═╝     ╚═╝  ╚═╝╚══════╝╚══════╝╚═╝  ╚═╝

add_shortcode('informe_pendiente', 'display_informe_pendiente');
function display_informe_pendiente() {
    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);
        $order = wc_get_order($order_id);   
        if ($order) {
            
            ob_start();
            ?>
            <div>
                <h2>
                    <span style="color:black;">El informe de la placa</span>
                    <span style="color:#ff5005;"><?php echo esc_html($order->get_meta('placa')); ?></span>
                    <span style="color:black;">se está generando</span>
                </h2>

            </div>
            <?php
            return ob_get_clean();
        }
    }
    return 'Order not found.';
}
// ███████╗███╗   ██╗     ██████╗ █████╗ ███████╗ ██████╗     ██████╗ ███████╗     ██████╗ ██╗   ██╗███████╗    ███╗   ██╗ ██████╗     ███████╗██╗  ██╗██╗███████╗████████╗ █████╗
// ██╔════╝████╗  ██║    ██╔════╝██╔══██╗██╔════╝██╔═══██╗    ██╔══██╗██╔════╝    ██╔═══██╗██║   ██║██╔════╝    ████╗  ██║██╔═══██╗    ██╔════╝╚██╗██╔╝██║██╔════╝╚══██╔══╝██╔══██╗
// █████╗  ██╔██╗ ██║    ██║     ███████║███████╗██║   ██║    ██║  ██║█████╗      ██║   ██║██║   ██║█████╗      ██╔██╗ ██║██║   ██║    █████╗   ╚███╔╝ ██║███████╗   ██║   ███████║
// ██╔══╝  ██║╚██╗██║    ██║     ██╔══██║╚════██║██║   ██║    ██║  ██║██╔══╝      ██║▄▄ ██║██║   ██║██╔══╝      ██║╚██╗██║██║   ██║    ██╔══╝   ██╔██╗ ██║╚════██║   ██║   ██╔══██║
// ███████╗██║ ╚████║    ╚██████╗██║  ██║███████║╚██████╔╝    ██████╔╝███████╗    ╚██████╔╝╚██████╔╝███████╗    ██║ ╚████║╚██████╔╝    ███████╗██╔╝ ██╗██║███████║   ██║   ██║  ██║
// ╚══════╝╚═╝  ╚═══╝     ╚═════╝╚═╝  ╚═╝╚══════╝ ╚═════╝     ╚═════╝ ╚══════╝     ╚══▀▀═╝  ╚═════╝ ╚══════╝    ╚═╝  ╚═══╝ ╚═════╝     ╚══════╝╚═╝  ╚═╝╚═╝╚══════╝   ╚═╝   ╚═╝  ╚═╝

add_shortcode('informe_no_existe', 'display_informe_no_existe');
function display_informe_no_existe() {
    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);
        $order = wc_get_order($order_id);   
        if ($order) {
            
            ob_start();
            ?>
            <div>
                <h2>
                    <span style="color:black;">La placa</span>
                    <span style="color:#ff5005;"><?php echo esc_html($order->get_meta('placa')); ?></span>
                    <span style="color:black;">no existe en registros públicos</span>
                </h2>

            </div>
            <?php
            return ob_get_clean();
        }
    }
    return 'Order not found.';
}


// ███╗   ███╗██╗     ██████╗██╗   ██╗███████╗███╗   ██╗████████╗ █████╗
// ████╗ ████║██║    ██╔════╝██║   ██║██╔════╝████╗  ██║╚══██╔══╝██╔══██╗
// ██╔████╔██║██║    ██║     ██║   ██║█████╗  ██╔██╗ ██║   ██║   ███████║
// ██║╚██╔╝██║██║    ██║     ██║   ██║██╔══╝  ██║╚██╗██║   ██║   ██╔══██║
// ██║ ╚═╝ ██║██║    ╚██████╗╚██████╔╝███████╗██║ ╚████║   ██║   ██║  ██║
// ╚═╝     ╚═╝╚═╝     ╚═════╝ ╚═════╝ ╚══════╝╚═╝  ╚═══╝   ╚═╝   ╚═╝  ╚═╝

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
        echo "<strong style='font-size:1rem;'>".$placa."</strong>";
    } else {
        echo '-';
    }
}


// QUITAR DESCARGAS DEL MENU LATERAL
function quitar_menu_descargas_mi_cuenta( $items ) {
    unset($items['downloads']); // Eliminar el enlace de descargas
    return $items;
  }
  add_filter( 'woocommerce_account_menu_items', 'quitar_menu_descargas_mi_cuenta' );

// QUITAR DIRECCION DE ENVIO DE LA PAGINA DE DIRECCIONES
add_filter( 'woocommerce_my_account_get_addresses', 'ocultar_direccion_envio_en_mi_cuenta', 10, 1 );
function ocultar_direccion_envio_en_mi_cuenta( $address ) {
  // Elimina la dirección de envío
  unset( $address['shipping'] );
  return $address;
}





// ███╗   ███╗██╗     ██████╗██╗   ██╗███████╗███╗   ██╗████████╗ █████╗     ██████╗ ███████╗████████╗ █████╗ ██╗     ██╗     ███████╗
// ████╗ ████║██║    ██╔════╝██║   ██║██╔════╝████╗  ██║╚══██╔══╝██╔══██╗    ██╔══██╗██╔════╝╚══██╔══╝██╔══██╗██║     ██║     ██╔════╝
// ██╔████╔██║██║    ██║     ██║   ██║█████╗  ██╔██╗ ██║   ██║   ███████║    ██║  ██║█████╗     ██║   ███████║██║     ██║     █████╗
// ██║╚██╔╝██║██║    ██║     ██║   ██║██╔══╝  ██║╚██╗██║   ██║   ██╔══██║    ██║  ██║██╔══╝     ██║   ██╔══██║██║     ██║     ██╔══╝
// ██║ ╚═╝ ██║██║    ╚██████╗╚██████╔╝███████╗██║ ╚████║   ██║   ██║  ██║    ██████╔╝███████╗   ██║   ██║  ██║███████╗███████╗███████╗
// ╚═╝     ╚═╝╚═╝     ╚═════╝ ╚═════╝ ╚══════╝╚═╝  ╚═══╝   ╚═╝   ╚═╝  ╚═╝    ╚═════╝ ╚══════╝   ╚═╝   ╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝

// Mostrar campos personalizados en la página de detalles del pedido
/*
add_action( 'woocommerce_order_details_after_order_table', 'mostrar_metas_personalizados_detalle_pedido' );
function mostrar_metas_personalizados_detalle_pedido( $order ) {
  // Obtén los valores de los metadatos
  $placa = get_post_meta( $order->get_id(), 'placa', true );
  $file_show = get_post_meta( $order->get_id(), 'file_show', true );
  $file_download = get_post_meta( $order->get_id(), 'file_download', true );

  // Comprueba si los metadatos existen y muestra los valores
  if ( $placa ) {
    echo '<p><strong>Placa:</strong> ' . esc_html( $placa ) . '</p>';
  }
  
  if ( $file_show ) {
    echo '<p><strong>File Show:</strong> ' . esc_html( $file_show ) . '</p>';
  }

  if ( $file_download ) {
    echo '<p><strong>File Download:</strong> ' . esc_html( $file_download ) . '</p>';
  }
}
*/

// DESACTIVAR "VOLVER A PEDIR"

add_filter('woocommerce_account_orders_actions', 'remove_reorder_button', 10, 2);

function remove_reorder_button($actions, $order) {
  // Remover la acción de "Volver a pedirlo"
  unset($actions['order-again']);
  return $actions;
}






//  ██████╗██╗  ██╗███████╗ ██████╗██╗  ██╗ ██████╗ ██╗   ██╗████████╗
// ██╔════╝██║  ██║██╔════╝██╔════╝██║ ██╔╝██╔═══██╗██║   ██║╚══██╔══╝
// ██║     ███████║█████╗  ██║     █████╔╝ ██║   ██║██║   ██║   ██║
// ██║     ██╔══██║██╔══╝  ██║     ██╔═██╗ ██║   ██║██║   ██║   ██║
// ╚██████╗██║  ██║███████╗╚██████╗██║  ██╗╚██████╔╝╚██████╔╝   ██║
//  ╚═════╝╚═╝  ╚═╝╚══════╝ ╚═════╝╚═╝  ╚═╝ ╚═════╝  ╚═════╝    ╚═╝



// ████████╗ █████╗ ██████╗ ██╗      █████╗     ██████╗ ███████╗    ██████╗ ███████╗██████╗ ██╗██████╗  ██████╗ ███████╗
// ╚══██╔══╝██╔══██╗██╔══██╗██║     ██╔══██╗    ██╔══██╗██╔════╝    ██╔══██╗██╔════╝██╔══██╗██║██╔══██╗██╔═══██╗██╔════╝
//    ██║   ███████║██████╔╝██║     ███████║    ██║  ██║█████╗      ██████╔╝█████╗  ██║  ██║██║██║  ██║██║   ██║███████╗
//    ██║   ██╔══██║██╔══██╗██║     ██╔══██║    ██║  ██║██╔══╝      ██╔═══╝ ██╔══╝  ██║  ██║██║██║  ██║██║   ██║╚════██║
//    ██║   ██║  ██║██████╔╝███████╗██║  ██║    ██████╔╝███████╗    ██║     ███████╗██████╔╝██║██████╔╝╚██████╔╝███████║
//    ╚═╝   ╚═╝  ╚═╝╚═════╝ ╚══════╝╚═╝  ╚═╝    ╚═════╝ ╚══════╝    ╚═╝     ╚══════╝╚═════╝ ╚═╝╚═════╝  ╚═════╝ ╚══════╝



// ███████╗███╗   ███╗ █████╗ ██╗██╗
// ██╔════╝████╗ ████║██╔══██╗██║██║
// █████╗  ██╔████╔██║███████║██║██║
// ██╔══╝  ██║╚██╔╝██║██╔══██║██║██║
// ███████╗██║ ╚═╝ ██║██║  ██║██║███████╗
// ╚══════╝╚═╝     ╚═╝╚═╝  ╚═╝╚═╝╚══════╝

add_filter('woocommerce_email_classes', 'add_custom_email_informe_class');
function add_custom_email_informe_class($email_classes) {
    require_once('class-wc-email-informe.php');
    $email_classes['WC_Email_Informe'] = new WC_Email_Informe();
    return $email_classes;
}

add_filter( 'woocommerce_order_actions', 'add_custom_email_action' );

function add_custom_email_action( $actions ) {
  $actions['send_custom_email_informe'] = __( 'Enviar Informe con Adjunto', 'your-textdomain' );
  return $actions;
}

add_action( 'woocommerce_order_action_send_custom_email_informe', 'process_custom_email_action' );

function process_custom_email_action( $order ) {
  // Asegúrate de que la clase de email esté cargada
  $email = WC()->mailer()->emails['WC_Email_Informe'];

  // Disparar el email
  if ( $email ) {
    $email->trigger( $order->get_id() );
  }
}

//  █████╗ ██████╗ ███╗   ███╗██╗███╗   ██╗
// ██╔══██╗██╔══██╗████╗ ████║██║████╗  ██║
// ███████║██║  ██║██╔████╔██║██║██╔██╗ ██║
// ██╔══██║██║  ██║██║╚██╔╝██║██║██║╚██╗██║
// ██║  ██║██████╔╝██║ ╚═╝ ██║██║██║ ╚████║
// ╚═╝  ╚═╝╚═════╝ ╚═╝     ╚═╝╚═╝╚═╝  ╚═══╝

// Añadir campos personalizados para el seguimiento en el área de administración del pedido
add_action( 'woocommerce_admin_order_data_after_order_details', 'agregar_informe_embed', 10, 1 );
function agregar_informe_embed( $order ){
    
    if ($order) {
        $file_show = $order->get_meta('file_show');
        // $file_download = $order->get_meta('file_download');
        ob_start();
        ?>
        <?php if ($file_show): ?>
            <div style="padding-top:1rem;clear:both;">
                <h3>Informe</h3>
                <p>
                    <span style="color:black;">Placa</span>
                    <span style="color:#ff5005;font-weight:bold;"><?php echo esc_html($order->get_meta('placa')); ?></span>
                </p>
                <embed src="<?php echo esc_url($file_show); ?>" type="application/pdf" width="100%" height="600px" />
            </div>
        <?php endif; ?>
        <?php
        echo ob_get_clean();
    }
}


function quitar_acciones_pedido( $actions ) {
    // Las tres primeras acciones que se muestran en la imagen
    unset( $actions['send_order_details'] );   // Enviar por correo electrónico al cliente los detalles del pedido
    unset( $actions['send_order_details_admin'] );  // Volver a enviar el aviso de nuevo pedido
    unset( $actions['regenerate_download_permissions'] );  // Regenerar los permisos de descarga

    return $actions;
}
add_filter( 'woocommerce_order_actions', 'quitar_acciones_pedido' );

//  █████╗ ██████╗ ███╗   ███╗██╗███╗   ██╗    ██████╗  █████╗ ██████╗
// ██╔══██╗██╔══██╗████╗ ████║██║████╗  ██║    ██╔══██╗██╔══██╗██╔══██╗
// ███████║██║  ██║██╔████╔██║██║██╔██╗ ██║    ██████╔╝███████║██████╔╝
// ██╔══██║██║  ██║██║╚██╔╝██║██║██║╚██╗██║    ██╔══██╗██╔══██║██╔══██╗
// ██║  ██║██████╔╝██║ ╚═╝ ██║██║██║ ╚████║    ██████╔╝██║  ██║██║  ██║
// ╚═╝  ╚═╝╚═════╝ ╚═╝     ╚═╝╚═╝╚═╝  ╚═══╝    ╚═════╝ ╚═╝  ╚═╝╚═╝  ╚═╝

function agregar_link_pedidos_a_admin_bar($wp_admin_bar) {
    // Asegúrate de que WooCommerce esté activo
    if (!class_exists('WooCommerce')) {
      return;
    }
  
    // Agrega un nuevo ítem en la barra de administración
    $wp_admin_bar->add_node(array(
      'id'    => 'pedidos_woocommerce',
      'title' => 'Pedidos de Informes',
      'href'  => admin_url('edit.php?post_type=shop_order'),
      'meta'  => array(
        'class' => 'pedidos-woocommerce', 
        'title' => 'Pedidos de Informes'
      )
    ));
  }
  add_action('admin_bar_menu', 'agregar_link_pedidos_a_admin_bar', 100);


//   ██████╗ ███████╗██████╗ ██╗██████╗  ██████╗ ███████╗
//   ██╔══██╗██╔════╝██╔══██╗██║██╔══██╗██╔═══██╗██╔════╝
//   ██████╔╝█████╗  ██║  ██║██║██║  ██║██║   ██║███████╗
//   ██╔═══╝ ██╔══╝  ██║  ██║██║██║  ██║██║   ██║╚════██║
//   ██║     ███████╗██████╔╝██║██████╔╝╚██████╔╝███████║
//   ╚═╝     ╚══════╝╚═════╝ ╚═╝╚═════╝  ╚═════╝ ╚══════╝

