<?php


// 1. Registrar el Custom Post Type (Testimonios)
function cpt_testimonios_init() {
  $labels = array(
    'name'               => 'Testimonios',
    'singular_name'      => 'Testimonio',
    'add_new'            => 'Añadir Testimonio',
    'add_new_item'       => 'Añadir Nuevo Testimonio',
    'edit_item'          => 'Editar Testimonio',
    'new_item'           => 'Nuevo Testimonio',
    'all_items'          => 'Todos los Testimonios',
    'view_item'          => 'Ver Testimonio',
    'search_items'       => 'Buscar Testimonios',
    'not_found'          => 'No se encontraron Testimonios',
    'not_found_in_trash' => 'No se encontraron Testimonios en la papelera',
    'menu_name'          => 'Testimonios'
  );

  $args = array(
    'labels'       => $labels,
    'public'       => true,
    'show_ui'      => true,
    'show_in_menu' => true,
    'supports'     => array( 'page-attributes'), // Añade 'page-attributes' para soportar menu_order
    'menu_icon'    => 'dashicons-format-quote',
    'has_archive'  => true,
    'rewrite'      => false,
    // 'can_export'   => true // Permite exportar/ importar
  );
  register_post_type('testimonios', $args);
}
add_action('init', 'cpt_testimonios_init');

// 2. Añadir Metaboxes (Texto, Nombre, Fecha, Activo)
function testimonios_add_metaboxes() {
  add_meta_box(
    'testimonios_fields',
    'Datos del Testimonio',
    'testimonios_fields_callback',
    'testimonios',
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'testimonios_add_metaboxes');
// 2.1 Ordenar por menu_order
function ordenar_testimonios_por_menu_order($query) {
  // Verificar que estemos en el administrador y que sea la consulta principal
  if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'testimonios') {
    // Ordenar por menu_order en orden ascendente
    $query->set('orderby', 'ID');
    $query->set('order', 'DESC');
  }
}
add_action('pre_get_posts', 'ordenar_testimonios_por_menu_order');

function testimonios_fields_callback($post) {
  $texto  = get_post_meta($post->ID, '_testimonios_texto', true);
  $nombre = get_post_meta($post->ID, '_testimonios_nombre', true);
  $fecha  = get_post_meta($post->ID, '_testimonios_fecha', true);
  $activo = get_post_meta($post->ID, '_testimonios_activo', true);
  ?>
  <p>
    <label for="testimonios_nombre">Nombre:</label><br>
    <input
      type="text"
      id="testimonios_nombre"
      name="testimonios_nombre"
      value="<?php echo esc_attr($nombre); ?>"
      style="width:100%"
    />
  </p>
  <p>
    <label for="testimonios_fecha">Fecha:</label><br>
    <input
      type="date"
      id="testimonios_fecha"
      name="testimonios_fecha"
      value="<?php echo esc_attr($fecha); ?>"
      style="width:100%"
    />
  </p>
  <p>
    <label for="testimonios_texto">Texto del Testimonio:</label><br>
    <textarea
      id="testimonios_texto"
      name="testimonios_texto"
      style="width:100%;height:80px;"
    ><?php echo esc_textarea($texto); ?></textarea>
  </p>
  <p>
    <label for="testimonios_activo">¿Activo?</label>
    <input
      type="checkbox"
      id="testimonios_activo"
      name="testimonios_activo"
      value="1"
      <?php checked($activo, '1'); ?>
    />
  </p>
  <?php
}

// 3. Guardar Metadatos
function testimonios_save_metaboxes($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!isset($_POST['testimonios_nombre'])) return;
  
  // Guardar el nombre
  update_post_meta($post_id, '_testimonios_nombre', sanitize_text_field($_POST['testimonios_nombre']));
  
  // Guardar la fecha en formato Y-m-d
  if (isset($_POST['testimonios_fecha'])) {
    $fecha = sanitize_text_field($_POST['testimonios_fecha']);
    $fecha_formateada = date('Y-m-d', strtotime($fecha)); // Formatear la fecha
    update_post_meta($post_id, '_testimonios_fecha', $fecha_formateada);
  }
  
  // Guardar el texto del testimonio
  update_post_meta($post_id, '_testimonios_texto', sanitize_textarea_field($_POST['testimonios_texto']));
  
  // Guardar el estado activo
  update_post_meta($post_id, '_testimonios_activo', isset($_POST['testimonios_activo']) ? '1' : '');
}
add_action('save_post', 'testimonios_save_metaboxes');

function convertirFecha($fecha) {
  // Configurar nombres de meses en español en mayúsculas
  $meses = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
  
  // Convertir la fecha al formato timestamp
  $timestamp = strtotime($fecha);
  
  // Extraer el día, mes y año
  $dia = date('d', $timestamp);
  $mes = $meses[date('n', $timestamp) - 1];
  $año = date('y', $timestamp);
  $añoActual = date('y');
  
  // Formatear la fecha, omitiendo el año si es el actual
  return ($año == $añoActual) ? "$dia $mes" : "$dia $mes $año";
}


// 4. Shortcode para mostrar testimonios
function shortcode_testimonios($atts) {
  // Atributo opcional Num (cantidad de testimonios)
  $atts = shortcode_atts(array(
    'num' => '-1',
  ), $atts, 'testimonios');

  $args = array(
    'post_type'      => 'testimonios',
    'posts_per_page' => (int) $atts['num'],
    'meta_key'       => '_testimonios_activo',
    'meta_value'     => '1',
    'orderby'   => 'ID',
    'order'     => 'DESC',
  );
  
  $query = new WP_Query($args);
  if (!$query->have_posts()) return 'No hay testimonios disponibles.';

  $output = '<div class="testimonios-list">';
  while ($query->have_posts()) {
    $query->the_post();
    $texto  = get_post_meta(get_the_ID(), '_testimonios_texto', true);
    $nombre = get_post_meta(get_the_ID(), '_testimonios_nombre', true);
    $fecha  = get_post_meta(get_the_ID(), '_testimonios_fecha', true);

    $output .= '<div class="testimonio-item">';
    $output .= '<blockquote class="testimonio_texto">' . esc_html($texto) . '</blockquote>';
    $output .= '<p class="testimonio_nombre">' . esc_html($nombre) . '</p>';
    $output .= '<p class="testimonio_fecha">' . esc_html(convertirFecha($fecha)) . '</p>';
    $output .= '</div>';
  }
  $output .= '</div>';

  wp_reset_postdata();
  return $output;
}
add_shortcode('testimonios', 'shortcode_testimonios');






function testimonios_edit_columns($columns) {
  // Eliminar columnas innecesarias
  unset($columns['title']); // Elimina la columna 'title'
  unset($columns['date']); // Elimina la columna 'date'

  // Agregar columnas personalizadas
  $columns['nombre_testimonial'] = 'Nombre';
  $columns['texto_testimonial'] = 'Texto';
  $columns['fecha_testimonial'] = 'Fecha';
  $columns['activo_testimonial'] = 'Activo'; // Nueva columna

  return $columns;
}
add_filter('manage_testimonios_posts_columns', 'testimonios_edit_columns');

// Mostrar contenido personalizado en las columnas
function testimonios_custom_columns($column, $post_id) {
  if ($column === 'nombre_testimonial') {
    $nombre = get_post_meta($post_id, '_testimonios_nombre', true);
    echo esc_html($nombre);
  }
  if ($column === 'texto_testimonial') {
    $texto = get_post_meta($post_id, '_testimonios_texto', true);
    echo esc_html(mb_strimwidth($texto, 0, 100, '...'));
  }
  if ($column === 'fecha_testimonial') {
    $fecha = get_post_meta($post_id, '_testimonios_fecha', true);
    echo esc_html($fecha);
  }
  if ($column === 'activo_testimonial') {
    $activo = get_post_meta($post_id, '_testimonios_activo', true);
    echo esc_html($activo === '1' ? 'Sí' : 'No'); // Mostrar "Sí" o "No" según el valor
  }
}
add_action('manage_testimonios_posts_custom_column', 'testimonios_custom_columns', 10, 2);

// Quitar edición rápida
function testimonios_remove_quick_edit($actions, $post) {
  global $current_screen;
  if ($current_screen->post_type === 'testimonios') {
    if (isset($actions['inline hide-if-no-js'])) {
      unset($actions['inline hide-if-no-js']);
    }
  }
  return $actions;
}
add_filter('post_row_actions','testimonios_remove_quick_edit', 10, 2);



function importar_testimonios_desde_csv() {
  $csv_file = __DIR__ . '/testimonios.csv'; // Ruta del archivo CSV

  if (!file_exists($csv_file)) {
    die("El archivo CSV no existe.");
  }

  // Abrir el archivo CSV
  if (($handle = fopen($csv_file, "r")) !== FALSE) {
    $header = fgetcsv($handle, 1000, ","); // Leer encabezados
    $rows = []; // Arreglo para almacenar las filas

    // Leer todas las filas del CSV
    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $rows[] = $row;
    }
    fclose($handle);

    // Invertir el orden de las filas
    $rows = array_reverse($rows);


    foreach ($rows as $row) {

      $data = array_combine($header, $row);

      // Insertar el post (CPT Testimonios)
      $post_id = wp_insert_post([
        'post_title'  => $data['post_title'],
        'post_type'   => 'testimonios',
        'post_status' => 'publish',
      ]); 

      if ($post_id && !is_wp_error($post_id)) {
        // Añadir metadatos personalizados
        update_post_meta($post_id, '_testimonios_nombre', $data['_testimonios_nombre']);
        update_post_meta($post_id, '_testimonios_fecha', $data['_testimonios_fecha']);
        update_post_meta($post_id, '_testimonios_texto', $data['_testimonios_texto']);
        update_post_meta($post_id, '_testimonios_activo', $data['_testimonios_activo']);
      } else {
        error_log("Error al insertar post en la fila " . print_r($post_id, true));
      }
    }

    echo "Importación completada.";
    exit();
  }
}


add_action('importar_testimonios', 'importar_testimonios_desde_csv');

function ejecutar_importacion_condicional() {
  if (isset($_GET['run_import']) && current_user_can('manage_options')) {
    do_action('importar_testimonios');
  }
}
add_action('admin_init', 'ejecutar_importacion_condicional');

/*
http://localhost:10160/wp-admin/?run_import=1
*/