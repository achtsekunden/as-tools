<?php

/*
** Version: 0.1 - AS function for adding Shortcodes to Widgets (Classic Widgets)

Changelog:
Version: 0.1 - 21.02.2025 - created the basic function
*/

// Prevent direct access
if (!defined('ABSPATH')) exit;

function as_add_shortcode_to_widgets($params) {
  if (!is_admin() && !empty($params[0]['widget_id'])) {
      return $params; // Verhindert die Anzeige im Frontend
  }

  if (!empty($params[0]['widget_id'])) {
      $widget_id = esc_attr($params[0]['widget_id']);
      $shortcode = '<p style="background:#f7f7f7; padding:8px; border-radius:4px; font-size:13px;">'
                 . '<strong>Shortcode:</strong> [as-widget id="' . $widget_id . '"]</p>';

      // Fügt den Shortcode-Text NUR im Admin-Bereich hinzu
      $params[0]['after_widget'] .= $shortcode;
  }
  return $params;
}


// Fügt im Admin-Bereich die Shortcode-ID als data-Attribut hinzu
function as_add_widget_shortcode_admin($widget, $return, $instance) {
  if (!empty($widget->id)) {
      echo '<div class="as-widget-shortcode" data-widget-id="' . esc_attr($widget->id) . '" style="padding: 5px; background: #f7f7f7; border-radius: 4px; margin-top: 10px; margin-bottom:10px; font-size: 13px;">'
         . '<strong>Shortcode:</strong> [as-widget id="' . esc_attr($widget->id) . '"]</div>';
  }
}

function as_render_widget_shortcode($atts) {
  // Wenn keine Widget-ID angegeben ist, abbrechen
  if (empty($atts['id'])) {
      return;
  }

  // Die übergebene Widget-ID verwenden
  $widget_id = $atts['id'];

  // Sicherstellen, dass das Widget mit dieser ID existiert
  if (!isset($GLOBALS['wp_registered_widgets'][$widget_id])) {
      return ''; // Rückgabe eines leeren Strings, wenn das Widget nicht gefunden wird
  }

  // Holen der Widget-Instanz und der notwendigen Optionen
  $widget_instance = $GLOBALS['wp_registered_widgets'][$widget_id];
  $widget_class = $widget_instance['callback'][0];  // Das Widget-Klassenobjekt
  $widget_options = get_option($widget_instance['callback'][0]->option_name);

  preg_match('/-(\d+)$/', $widget_id, $matches);
  $widget_number = isset($matches[1]) ? $matches[1] : 0;

  // Holen der Instanz des Widgets
  $instance = isset($widget_options[$widget_number]) ? $widget_options[$widget_number] : array();

  // Sicherstellen, dass eine Instanz des Widgets und die Klasse korrekt sind
  if (!is_object($widget_class) || !isset($widget_class->option_name)) {
      return ''; // Wenn keine gültige Instanz gefunden wurde, gib einen leeren String zurück
  }

  // Holen des Klassennamens für das Widget (ohne die Verwendung von classname)
  $classname = 'widget ' . get_class($widget_class);

  // Optional: Widget-Position als zusätzliche Klasse hinzufügen
  $widgets_map = wp_get_sidebars_widgets(); // Alternative zu get_widgets_map()
  foreach ($widgets_map as $sidebar => $widgets) {
      if (in_array($widget_id, $widgets)) {
          $classname .= ' area-' . $sidebar; // Füge die Sidebar-Position als Klasse hinzu
          break;
      }
  }

  // Bereitstellung der standardmäßigen Widget-Argumente
  $args = array(
      'before_widget' => '<div class="' . trim($classname) . '" id="' . $widget_id . '">', // CSS-Klasse hier einsetzen
      'before_title' => '<h2 class="widgettitle">',
      'after_title' => '</h2>',
      'after_widget' => '</div>',
      'widget_id' => $widget_id,
      'widget_name' => isset($widget_instance['name']) ? $widget_instance['name'] : ''
  );

  // Widget-Ausgabe generieren
  ob_start();
  // Überprüfen, ob die Widget-Klasse ein Widget ist und den richtigen Typ hat
  if (method_exists($widget_class, 'widget')) {
      $widget_class->widget($args, $instance);
  }
  $content = ob_get_clean();

  // Rückgabe des Inhalts
  return do_shortcode($content);
}

// function call
if(get_option('as_check_widget_shortcode_db')):
  add_filter('dynamic_sidebar_params', 'as_add_shortcode_to_widgets');
  add_action('in_widget_form', 'as_add_widget_shortcode_admin', 10, 3);
  add_shortcode('as-widget', 'as_render_widget_shortcode');
endif;
