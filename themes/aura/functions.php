<?php
/**
 * Twenty Sixteen functions and definitions
 */
 
function aura_enqueue_style()  {
	wp_enqueue_style('twentysixteenstyle', get_template_directory_uri() . '/style.css', false);
}

add_action('wp_enqueue_scripts', 'aura_enqueue_style');


/* pre_render_filter:
					 Params:
					 $form
					 $ajax_enabled: bool
					 $field_values
 */

function aura_get_master_aura_form_details($form, $ajax_enabled, $field_values)  {
  // Get details from master form.
	$ar_form = GFAPI::get_form (1);
  // var_dump ($ar_form);

	$ar_field_len = sizeof ($ar_form['fields']);

	// Now print all the entries
	$au_search_criteria = array (
		'status' => array ('active','trash'),
	);

	$ar_entries = GFAPI::get_entries(1, $au_search_criteria);

  $descr = array();  $remedy = array();
	foreach ($ar_entries as $ar_row)  {
    $descr[] = (count($ar_row[4] != 0) ? $ar_row[4] : "<>");
    $remedy[] = (count($ar_row[5] != 0) ? $ar_row[5] : "<>");
	}



  /* Sample code
  $au_body_part = array (
    array ('text' => 'eye',  'value' => 'eye'),
    array ('text' => 'ear',  'value' => 'ear'),
    array ('text' => 'nose', 'value' => 'ear'),

  $form['fields'][5]['choices'] = $au_body_part;
  );
 */

  // TODO: Learn to declare this as an array of arrays
  $body_part = array(); $pos_color = array(); $pos_color_descr = array();
  $neg_color = array(); $neg_color_descr = array();

  foreach ($ar_entries as $entry)  {
    if ($entry['1'] != '')  
      $body_part[] =  array ('text' => $entry['1'], 'value' => $entry['1']);
    if ($entry['2'] != '')  
      $pos_color[] =  array ('text' => $entry['2'], 'value' => $entry['2']);
    if ($entry['4'] != '')  
      $pos_color_descr[] =  array ('text' => $entry['4'], 'value' => $entry['4']);
    if ($entry['3'] != '')  
      $neg_color[] =  array ('text' => $entry['3'], 'value' => $entry['3']);
    if ($entry['5'] != '')  
      $neg_color_descr[] = $form['fields'][9]['choices'][] = array ('text' => $entry['5'], 'value' => $entry['5']);
  }

  $form['fields'][5]['choices'] = $body_part;
  $form['fields'][6]['choices'] = $pos_color;
  // $form['fields'][7]['choices'] = $pos_color_descr;
  $form['fields'][8]['choices'] = $neg_color;
  // $form['fields'][9]['choices'] = $neg_color_descr;

  // var_dump($form);
  return $form;
}
  
add_filter('gform_pre_render_3', 'aura_get_master_aura_form_details');

