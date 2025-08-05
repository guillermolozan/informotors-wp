<?php
/*
if ( ! class_exists( 'WC_Email_Informe' ) ) {

  class WC_Email_Informe extends WC_Email {

    public function __construct() {
      $this->id          = 'custom_email_informe';
      $this->title       = 'Email Informe';
      $this->description = 'Este es un email personalizado enviado a los clientes cuando el pedido está completado.';
      $this->heading     = 'Tu Informe Personalizado';
      $this->subject     = 'Aquí está tu informe personalizado';

      $this->template_base  = plugin_dir_path( __FILE__ ) . 'templates/';
      $this->template_html  = 'emails/custom-email.php';
      $this->template_plain = 'emails/plain/custom-email.php';
      $this->enabled = 'yes'; // Asegúrate de que esté habilitado

      // Trigger del email cuando el pedido está completado
      add_action( 'woocommerce_order_status_completed_notification', array( $this, 'trigger' ) );

      parent::__construct();
    }

    public function trigger( $order_id ) {
      if ( ! $order_id ) {
        // error_log('No order ID provided');
        return;
      }
      $this->object = wc_get_order( $order_id );
      // error_log('Trigger called for order: ' . $order_id);
      $user = $this->object->get_user(); // Obtener el usuario asociado al pedido

      // Verifica si hay un usuario asociado y obtiene su correo electrónico de cuenta
      if ( $user ) {
        $this->recipient = $user->user_email;
      } else {
        return; // Si no hay usuario, no se envía el correo
      }
      // error_log('Recipient email: ' . $this->recipient);

      // Obtener el path del archivo adjunto desde el meta 'file_download'
      // $file_path = get_post_meta( $order_id, 'file_download', true );
      $file_path = '/var/www/store/reporte-'.$this->object->get_meta('placa').'.pdf';
      // error_log($file_path);
      // Verifica si el archivo existe en el servidor
      if ( ! file_exists( $file_path ) ) {
        error_log('El archivo no existe: ' . $file_path);
        return;
      } else {
        // error_log('El archivo existe: ' . $file_path);
      }
      

      // Adjuntar el archivo si está habilitado y hay un destinatario válido
      if ( $this->is_enabled() && $this->get_recipient() ) {
        $this->attachments = array( $file_path );
        $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->attachments );
      }
    }

    public function get_content_html() {
      ob_start();
      wc_get_template( $this->template_html, array(
        'order'         => $this->object,
        'email_heading' => $this->get_heading(),
        'sent_to_admin' => false,
        'plain_text'    => false,
        'email'         => $this,
        'placa'         => $this->object->get_meta('placa'),
        'file_download_url' => $this->object->get_meta('file_download'),
      ), '', $this->template_base );
      return ob_get_clean();
    }

    public function get_content_plain() {
      ob_start();
      wc_get_template( $this->template_plain, array(
        'order'         => $this->object,
        'email_heading' => $this->get_heading(),
        'sent_to_admin' => false,
        'plain_text'    => true,
        'email'         => $this,
        'placa'         => $this->object->get_meta('placa'),
        'file_download_url' => $this->object->get_meta('file_download'),
      ), '', $this->template_base );
      return ob_get_clean();
    }
  }
}




*/


if ( ! class_exists( 'WC_Email_Informe' ) ) {

  class WC_Email_Informe extends WC_Email {

    public function __construct() {
      $this->id          = 'custom_email_informe';
      $this->title       = 'Email Informe';
      $this->description = 'Envia el informe al cliente.';
      $this->template_base  = plugin_dir_path( __FILE__ ) . 'templates/';
      $this->template_html  = 'emails/custom-email.php';
      $this->template_plain = 'emails/plain/custom-email.php';
      $this->enabled = 'yes'; // Asegúrate de que esté habilitado
      $this->heading     = 'b';
      $this->subject     = 'b';

      // Trigger del email cuando el pedido está completado
      add_action( 'woocommerce_order_status_completed_notification', array( $this, 'trigger' ) );

      parent::__construct();
    }

    public function trigger( $order_id ) {
      if ( ! $order_id ) {
        return;
      }

      $this->object = wc_get_order( $order_id );
      $user = $this->object->get_user(); // Obtener el usuario asociado al pedido

      // Verifica si hay un usuario asociado y obtiene su correo electrónico de cuenta
      if ( $user ) {
        $this->recipient = $user->user_email;
        $user_login = $user->user_login; // Obtener el login del usuario
      } else {
        return; // Si no hay usuario, no se envía el correo
      }

      // Obtener la placa
      $placa = $this->object->get_meta('placa');

      // Definir el subject y heading usando la placa
      $this->subject = 'Informe Placa ' . $placa;
      $this->heading = $this->subject;

      // Obtener el path del archivo adjunto desde el meta 'file_download'
      $file_path = '/var/www/store/reporte-' . $placa . '.pdf';

      // Verifica si el archivo existe en el servidor
      if ( ! file_exists( $file_path ) ) {
        error_log('El archivo no existe: ' . $file_path);
        return;
      }
      // error_log('trigger');


      // Adjuntar el archivo si está habilitado y hay un destinatario válido
      if ( $this->is_enabled() && $this->get_recipient() ) {
        $this->attachments = array( $file_path );
        $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->attachments );
      }
    }

    public function get_content_html() {
      ob_start();
      wc_get_template( $this->template_html, array(
        'order'             => $this->object,
        'email_heading'     => $this->get_heading(),
        'sent_to_admin'     => false,
        'plain_text'        => false,
        'email'             => $this,
        'placa'             => $this->object->get_meta('placa'),
        'file_download_url' => $this->object->get_meta('file_download'),
        'user_login'        => $this->object->get_user()->user_login, // Pasar el user_login al template
        'order_date_time'   => $this->object->get_date_created()->date('d-m-y H:ia'), // Fecha y hora del pedido
      ), '', $this->template_base );
      return ob_get_clean();
    }

    public function get_content_plain() {
      ob_start();
      wc_get_template( $this->template_plain, array(
        'order'             => $this->object,
        'email_heading'     => $this->get_heading(),
        'sent_to_admin'     => false,
        'plain_text'        => true,
        'email'             => $this,
        'placa'             => $this->object->get_meta('placa'),
        'file_download_url' => $this->object->get_meta('file_download'),
        'user_login'        => $this->object->get_user()->user_login, // Pasar el user_login al template
        'order_date_time'   => $this->object->get_date_created()->date('d-m-y H:ia'), // Fecha y hora del pedido
      ), '', $this->template_base );
      return ob_get_clean();
    }
  }
}
