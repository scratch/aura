<?php
/**
 * Twenty Sixteen functions and definitions
 */
 

function aura_enqueue_style()  {
	wp_enqueue_style('twentysixteenstyle', get_template_directory_uri() . '/style.css', false);
}


function aura_enqueue_scripts()  {
  wp_enqueue_script('twentysixteenscript', get_stylesheet_directory_uri() . '/js/aura_descr.js', 
    array( 'jquery', 'jquery-ui-core', 'jquery-ui-button', 'jquery-ui-autocomplete') );
}


add_action('wp_enqueue_scripts', 'aura_enqueue_style');
add_action('wp_enqueue_scripts', 'aura_enqueue_scripts');


/* pre_render_filter:
					 Params:
					 $form
					 $ajax_enabled: bool
					 $field_values
 */
function aura_get_master_aura_form_details($form, $ajax_enabled, $field_values)  {
  // Get details from master form.
	$ar_form = GFAPI::get_form (1);

	$au_search_criteria = array (
		'status' => array ('active','trash'),
	);
	$ar_entries = GFAPI::get_entries(1, $au_search_criteria);

  $body_part = array(); // To hold description associated with bodypart/color.
  $pos_color = array(); $neg_color = array(); $bp = array();
  
  // Pull details from aura details form to display in this form. 
  // Index each entry by 'body part'
  foreach ($ar_entries as $entry)  {
    if ($entry['1'] == '')
      continue;  // Assert false.
    else {
      $idx = $entry['1'];
      $bp[] = array ('text' => $entry['1'], 'value' => $entry['1']);
      if ($entry['2'] != '')  {
        $body_part[$idx]['pos_color'][$entry['2']] = $entry['4'];  // Set pos colour value to description
        $needle = array('text' => $entry['2'], 'value' => $entry['2']);
        if (!in_array ($needle, $pos_color))
          $pos_color[] = $needle;
      }

      if ($entry['3'] != '')  {
        $body_part[$idx]['neg_color'][$entry['3']] = $entry['5'];
        $needle = array('text' => $entry['3'], 'value' => $entry['3']);
        if (!in_array ($needle, $neg_color))
          $neg_color[] = $needle;
      }
    }
  }

  // To display description using JS
  $json_bp = json_encode($body_part);
  /*
  $html =  
    '<input type="hidden" name="aura_body_part"' . 
    'id="aura_body_part_id"' . 
    'value=' . $json_bp .
    ' />' ;
  */
  // HACK/REVISIT: Creating JS var safe?
  $html = '<script type="text/javascript"> var g_aura_body_part=' . $json_bp . '</script>';
  echo $html;

  $form['fields'][5]['choices'] = $bp;
  $form['fields'][6]['choices'] = $pos_color;
  $form['fields'][8]['choices'] = $neg_color;
  // Default display
  $form['fields'][5]['placeholder'] = 'Pick choice from list below';
  $form['fields'][6]['placeholder'] = 'Pick choice from list below';
  $form['fields'][8]['placeholder'] = 'Pick choice from list below';
  // $form['fields'][7]['choices'] = $pos_color_descr;
  // $form['fields'][9]['choices'] = $neg_color_descr;

  return $form;
}
  
add_filter('gform_pre_render_3', 'aura_get_master_aura_form_details');
add_filter( 'gform_pre_validation_3', 'aura_get_master_aura_form_details' );
add_filter( 'gform_pre_submission_filter_3', 'aura_get_master_aura_form_details' );
add_filter( 'gform_admin_pre_render_3', 'aura_get_master_aura_form_details' );
