jQuery(document).ready(function($) {

	$(window).load(function() {

		//Get data
		var post_id = parseInt( ( $( 'body' ).attr( 'class' ).match( /(?:^|\s)postid-([0-9]+)(?:\s|$)/ ) || [ 0, 0 ] )[1] ),
			raw_time = $('span#swcart').attr('attr-rawtime');

		//Append HTML
		$('body').prepend('<div id="swcart-loader" style="width: 100%; position: fixed; top: 0; z-index: 99999999; height: 5px; display: none;"><div class="inside" style="background: #F44336; height: 5px; width: 0; box-shadow: 0 0 5px 1px #B71C1C;"></div></div>');

		//Do the magic
		var post_height = $('body.single-post.postid-'+post_id+' #swcart-wrapper').height(),
			start = $('body.single-post.postid-'+post_id+' #swcart-wrapper').offset().top,
			end = $('body.single-post.postid-'+post_id+' #swcart-wrapper').offset().top + post_height;

		$(window).on('scroll', function() {

			var scrollPos = $(document).scrollTop();
			console.log(scrollPos + ' - ' + post_height+ ' - ' + end);
			
			if(scrollPos >= start && scrollPos <= end) {

				var distanceIn = scrollPos - start,
					percent = (distanceIn * 100) / post_height;

				//Display bar
				$('#swcart-loader').css('display', 'block');
					$('#swcart-loader .inside').animate({'width': Math.round(percent)+"%"}, 90);
				} else if (scrollPos >= end && scrollPos <= parseInt(end, 10) + parseInt('140', 10)) {
					$('#swcart-loader .inside').animate({'width': "100%"}, 90);
				} else {
					$('#swcart-loader .inside').animate({'width': "0"}, 90);
					$('#swcart-loader').css('display', 'none');
				}

		});
	});
});