<?php

/**
 * Don't give direct access to the template
 */ 
if(!class_exists("RGForms")){
	return;
}

/**
 * Load the form data to pass to our PDF generating function 
 */
$form = RGFormsModel::get_form_meta($form_id);

?>

<?php
  $au_dir = _wp_upload_dir_baseurl();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>	
    <link rel='stylesheet' href='<?php echo PDF_PLUGIN_URL .'initialisation/template.css'; ?>' type='text/css' />
<style>
.au_head  {
  background-color: #571e70;
  font-weight: normal;
  font-family: "Times New Roman";
  font-size: 24px;
  text-align: center;
  }
</style>

	<?php 
		/* 
		 * Create your own stylesheet or use the <style></style> tags to add or modify styles  
		 * The plugin stylesheet is overridden every update		 
		 */
	?>
    <title>Gravity PDF</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div class="au_head">
	<img src="<?php echo $au_dir?>/xg-masthead-bg.png" /> <br> <br> <br>
	<b> SOUL'S TEMPLE </b>
</div>

<br><br> <b> Name: </b> Amrutha Valli <br>
<b>Date: </b> 22 January 2016 <br>
<b>Reader: </b> Archana Rao K <br><br>
<img src="<?php echo $au_dir?>/amrutha.jpg" /> <br> <br>

<?php
function au_list_aura_details()  {
	$ar_form = GFAPI::get_form (1);

	$ar_field_len = sizeof ($ar_form['fields']);

  echo "<br>";
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

  
  echo "<br><b> Description: </b>";
  foreach ($descr as $d)
		echo $d; 
  echo "<br><br><b> Remedial Measures </b>"; 
  foreach ($remedy as $r)
		echo $r; 
}

au_list_aura_details();
?>
	</body>
</html>
