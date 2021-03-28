jQuery(document).ready(function($) {
	"use strict";
    $( "a:contains('import-demo-full-custom')" ).parent().remove();
	$("#import-content").change(function() {
	  var id = $(this).children(":selected").attr("id");
	  $('#import-link-value').val(id);
	});
	$("#vc_settings-templatera #submit_btn").attr('value', 'Import ekko Templates');	
});
