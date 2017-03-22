(function ( $ ) {
	'use strict';
	
	$( '#upload-form' ).submit(function () {
		var parameters = {
			option: '',
			upload: fileContent,
		};
		var option = $( '[name="option"]:checked' );
		
		if ( option.length ) {
			parameters.option = option.val();
			console.log(parameters)
		} else {
			alert( 'Please select an option' );
			return false;
		}
		
		$.post( 'upload.php', parameters, function ( res ) {
			$( '#view' ).html( res );
		} );
		
		return false;
	});
	
	$( '#upload' ).on( 'change', readFile );
	
	var fileContent = '';
	
	function readFile() {
		var filereader = new FileReader();
		var file = this.files.item( 0 );
		
		filereader.onload = function () {
			fileContent = filereader.result;
			$( '#view' ).html( fileContent );
		};
		
		filereader.readAsText( file );
	}
})( jQuery );