var au_id_prefix = "input_";
var au_bod_col = "1_7";
var au_pos_col = "1_7";
var au_neg_col = "1_9";
var au_repeater_idx = 1;

jQuery(document).on('gform_repeater_init_done', function() {
	jQuery('#' + au_id_prefix + au_pos_col + '-1-' + au_repeater_idx ).on('change', function() {
		alert("pos color");
	});
});

// While each new form is repeated, get the values for the newly created # ID's.
// gform_repeater_after_repeat
//	  ++au_repeater_idx;

jQuery(document).on('gform_repeater_init_done', function() {
