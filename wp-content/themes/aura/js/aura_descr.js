/* The various ID's generated by repeater for gravity forms pluging
 * The new ID's for repeated fields is created as follows:
 * <old-ID>-1-<repeater>.
 * old-ID has <form-id_field-id>
 * TODO: Get form ID; this may change from installation to installation.
 */
var au_id_prefix = "input_";
var au_body_part = "3_5";
var au_pos_col = "3_7";
var au_neg_col = "3_9";
var au_repeater_idx = 1;
var g_bodypart;

jQuery(document).on('gform_repeater_init_done', function() {

	jQuery('#' + au_id_prefix + au_body_part + '-1-' + au_repeater_idx).on('change', function() {
    g_bodypart = jQuery(this).val();
		// alert("bodypart: " + g_bodypart);
	});

	jQuery('#' + au_id_prefix + au_pos_col + '-1-' + au_repeater_idx ).on('change', function() {
    var pcolor = jQuery(this).val();
    // alert ('pos color: ' + pcolor);
    // alert ('description: ' + g_aura_body_part[g_bodypart]['pos_color'][pcolor]);
	});

	jQuery('#' + au_id_prefix + au_neg_col + '-1-' + au_repeater_idx ).on('change', function() {
    var negcolor = jQuery(this).val();
    // alert ('neg color: ' + negcolor);
    // alert ('description: ' + g_aura_body_part[g_bodypart]['neg_color'][negcolor]);
	});
});

// While each new form is repeated, get the values for the newly created # ID's.
// gform_repeater_after_repeat
//	  ++au_repeater_idx;
jQuery(document).on('gform_repeater_after_repeat', function() {
	jQuery('#' + au_id_prefix + au_pos_col + '-1-' + au_repeater_idx ).on('change', function() {
		alert("pos color");
	});
});
