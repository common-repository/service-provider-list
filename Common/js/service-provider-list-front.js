jQuery(document).ready( function() {
   jQuery('#serviceTypeSelect').change( function() {
   	  var stype = jQuery(this).val();
      location.href = '?stype='+stype;
   });
});