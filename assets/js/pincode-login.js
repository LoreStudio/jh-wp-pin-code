( function( $ ) {		
	
	$("#user_pincode").on("keypress", function(event) {
	  if (event.key === "Enter" || event.which == 13) {
	    event.preventDefault();
	    $("#login_submit_btn").trigger('click');
	  }
	});
	$(document).on('click', '#login_submit_btn',function( event ) {
		console.log('verify it');
		if($(this).hasClass('verifying')){
			console.log('in process');
			return false;
		}
		$('#login-error-window').hide().html('');
		let btn_txt = $(this).html();
		var $that = $(this);
		let redirect_to = $('#redirect_to').val();
		event.preventDefault();
		$.ajax({
                url: pincode_object.ajax_url,
                type: 'POST',
                data: $('#pincode_login_form').serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $(this).addClass('verifying');
					//$that.html('Please wait...');
                },
		}).done(function (response) { //
			if('success' === response.status){

				window.dataLayer = window.dataLayer || [];

				dataLayer.push({
				"event": "sign_in_submit"
				});

				// return console.log('redirect_to', response.redirect_to);

				window.location.href = response.redirect_to;
				return;
			}else{
				$that.removeClass('verifying');
				//$that.html(btn_txt);
				$('#login-error-window').show().html(response.message);
			}
		}).fail(function (jqXHR, textStatus) {
			$that.removeClass('verifying');
			//$that.html(btn_txt);
			 console.log("Request failed: " + textStatus);
		});
		
	});
})(jQuery);