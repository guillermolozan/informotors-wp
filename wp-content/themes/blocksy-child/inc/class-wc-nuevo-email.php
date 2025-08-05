<?php

class WC_Informe_Email extends WC_Email {
  public function __construct() {
      $this->id = 'informe_email';
      $this->title = 'Informe Adjunto';
      $this->description = __('This is a custom email', 'your-text-domain');
      
      // Other email settings...
      
      parent::__construct();
  }
  
  public function trigger($order_id) {
      // Logic to trigger the email
  }
}