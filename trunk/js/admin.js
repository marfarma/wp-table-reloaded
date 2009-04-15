jQuery(document).ready(function($){
    $("#import_format").change(function () {
          if ( 'csv' == $(this).val() )
		$(".tr-import-delimiter").css('display','table-row');
	  else
		$(".tr-import-delimiter").css('display','none');
        })
        .change();

    $("#export_format").change(function () {
          if ( 'csv' == $(this).val() )
		$(".tr-export-delimiter").css('display','table-row');
	  else
		$(".tr-export-delimiter").css('display','none');
        })
        .change();

    $("#options_uninstall input").click(function () {
	  if( !!$('#options_uninstall input:checked').val() ) {
		return confirm( 'Do you really want to activate this? You should only do that right before uninstallation!' ); 
	  }
	});

    $('.postbox h3, .postbox .handlediv').click( function() {
	$($(this).parent().get(0)).toggleClass('closed');
    } );

});