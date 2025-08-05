<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

$order_id=$order->get_order_number();


echo $email_heading . "\n\n";

echo "Hola ".esc_html( $user_login ).".\n";

echo "Aquí tienes el informe de la placa ". esc_html( $placa ) ." que solicitaste.\n";
echo 'en la fecha '. esc_html( $order_date_time ) .', con el número de pedido: #'. esc_html( $order_id )."\n\n";

// echo "Gracias por tu pedido.\n\n";

// if ( ! empty( $file_download_url ) ) {
  // echo "Puedes descargar tu informe desde el siguiente enlace: " . esc_url( $file_download_url ) . "\n\n";
  echo 'También puedes ver y descargar el informe desde la página de tu cuenta en '.esc_url('https://infomotors.pe/mi-cuenta/informe/'. $order_id). "\n\n";
// }

echo "Gracias por preferir Informotors. Saludos Cordiales\n";

do_action( 'woocommerce_email_footer_text', $email );
