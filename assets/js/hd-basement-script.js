jQuery( document ).on( 'click', '.hd-basement-dashboard-js', function() {
	
	//console.log( 'clicked' );

	var userid = jQuery( this ).attr( 'data-userid' );

    jQuery.ajax({
        
        type: 'post',
        url: ajaxurl,
        data: {
            action: 'hd_basement_dismiss_dashboard_style_notice',
            user: userid
        },

        // what happens on success
		success: function( response ) {

			console.log( response );

		}

    })

});