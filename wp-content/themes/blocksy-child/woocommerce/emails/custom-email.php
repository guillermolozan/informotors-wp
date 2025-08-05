<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$order_id=$order->get_order_number();

do_action( 'woocommerce_email_header', $email_heading, $email );

echo '<p>Hola '.esc_html( $user_login ).'.</p>';

echo '<p>';
echo 'Aquí tienes el informe de la placa '. esc_html( $placa ) .' que solicitaste <br>';
echo 'en la fecha '. esc_html( $order_date_time ) .', con el número de pedido: #'. esc_html( $order_id );
echo '</p>';

// if ( ! empty( $file_download_url ) ) {
echo '<p>También puedes descargar el informe desde la página de tu cuenta en <a href="';
echo esc_url('https://infomotors.pe/mi-cuenta/informe/'. $order_id);
echo '">https://infomotors.pe/mi-cuenta/informe/'. $order_id .'</a></p>';
// }

echo '<p>Gracias por preferir Infotmoros. Saludos cordiales,</p>';
// echo '<p>Tu equipo de soporte</p>';

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
// if ( $additional_content ) {
// 	echo wp_kses_post( wpautop( wptexturize(   $additional_content ) ) );
// }

do_action( 'woocommerce_email_footer', $email );
