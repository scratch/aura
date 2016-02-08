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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>	
    <link rel='stylesheet' href='<?php echo PDF_PLUGIN_URL .'initialisation/template.css'; ?>' type='text/css' />
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
       
<?php	

  $lead = RGFormsModel::get_lead($lead_ids['0']);
  $form_data = GFPDFEntryDetail::lead_detail_grid_array($form, $lead);
			
  $au_pdf_body = array(); $au_pdf_pos_descr = array(); $au_pdf_neg_descr = array();
  $au_pdf_body = unserialize($form_data['field'][12]);
  foreach ($au_pdf_body as $bp)  {
    if (!empty($bp['8']))
      $au_pdf_pos_descr[] =  $bp['8'][0];
    if (!empty($bp['10']))
      $au_pdf_neg_descr[] =  $bp['10'][0];
  }
  ?>            
      
  <img src="<?php $au_upload_dir = wp_upload_dir(); echo $au_upload_dir['baseurl'] ; ?>/aura-reader-header.jpg" align="center"/>           


   <h3> <?php echo "Aura Reading: " . $form_data['field']['Aura Reader Name']['first'] . 
           " "  . 
           $form_data['field']['Aura Reader Name']['last'] . 
           " On: " . $form_data['field']['Aura Date']; ?> </h3>

   <h2><?php echo $form_data['field']['Client Name']['first']; echo '  ' . 
        $form_data['field']['Client Name']['last']; ?></h2>
   <div id="au-client-image"><img src="<?php echo $form_data['field']['Aura Photgraph'][0]; ?>" style="float:left"> </div>
  <h4>Description:</h4>
  <p><?php  $str = implode($au_pdf_pos_descr); echo $str;?>
</p>
  <h4>Remedial Measures:</h4>
  <p><?php  $str = implode($au_pdf_neg_descr); echo $str; ?>
  <hr />
</body>
</html>
