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

  $body_part = array(); $pos_color = array(); $pos_color_descr = array();
  $neg_color = array(); $neg_color_descr = array();
  
  // Pull details from aura details form to display in this form. 
  // Index each entry by 'body part'
  foreach ($ar_entries as $entry)  {
    if ($entry['1'] == '')
      continue;  // Assert false.
    else {
      $idx = $entry['1'];
      $body_part[$idx] = null;  // clean up old data, if any; CSV may contain same entry with different data.
      if ($entry['2'] != '')  
        $body_part[$idx]['pos_color'] = array ('text' => $entry['2'], 'value' => $entry['2']);
      if ($entry['3'] != '')  
        $body_part[$idx]['neg_color'] = array ('text' => $entry['3'], 'value' => $entry['3']);
      if ($entry['4'] != '')  
        $body_part[$idx]['pos_descr'] = array ('text' => $entry['4'], 'value' => $entry['4']);
      if ($entry['5'] != '')  
        $body_part[$idx]['neg_descr'] = array ('text' => $entry['5'], 'value' => $entry['5']);
    }
  }

  // Just to make the pos and neg colours unique.
  $bp = array();
  foreach ($body_part as $bp_idx => $bp_val)  {
    $bp[] = array ('text' => $bp_idx, 'value' => $bp_idx);
    if ($bp_val['pos_color'] != ''  &&  !in_array($bp_val['pos_color'], $pos_color))  
      $pos_color[] = $bp_val['pos_color'];
    if ($bp_val['neg_color'] != ''  &&  !in_array($bp_val['neg_color'], $neg_color))  
      $neg_color[] = $bp_val['neg_color'];

    // if ($bp_val['pos_descr'] != '')  $pos_color_descr[] = $val['pos_descr'];
    // if ($bp_val['neg_descr'] != '')  $neg_color_descr[] = $val['neg_descr'];
  }

  // To display description using JS
  $json_bp = json_encode($body_part);
  $html =  '<input type="text/javascript" name="_aura_body_part"' . 
    'value=' . $json_bp .
    ' />';

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
