jQuery(document).ready(function(){
	function get_tinymce_content(id) {
		var returnItem = "";
		if (jQuery("#wp-"+id+"-wrap").hasClass("tmce-active")){
			returnItem = tinyMCE.get(id).getContent();
			console.log("Visual " + returnItem);
			return returnItem;
		}else{
			item = "#"+id;
			console.log("item " + item);
			returnItem = jQuery(item).val();
			console.log("TEXT " + returnItem);
			return returnItem;
		}
	
	}

	jQuery('#create_factbid').on('click',function(e){
		e.preventDefault();
		var parent = jQuery('#factbid-form #parent').val();
		var user = jQuery(this).data("user");
		var title = jQuery('#factbid-form #title').val();
		var image = jQuery('#factbid-form #factbid-img').val();
		var type = jQuery('#factbid-form #type').val();
		var country = jQuery('#factbid-form #country').val();
		var status = jQuery('#factbid-form #status').val();
		var topics = jQuery('#factbid-form #topics').val();
		var visibility = jQuery('#factbid-form #visibility').val();
		var priority = jQuery('#factbid-form #priority').val();
		var language = jQuery('#factbid-form #language').val();
		var nobid = jQuery('input[name="nobid"]:checked').val();

		var description = get_tinymce_content('description');
		var if_claimed = get_tinymce_content('if_claimed');
		var if_unclaimed = get_tinymce_content('if_unclaimed');
		var acceptable_claim = get_tinymce_content('acceptable_claim');

		// var footnote = tinyMCE.get('footnote').getContent();
		var footnote = "";
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{'action':'create_factbid',
				'parent':parent,
				'title':title,
				'description':description,
				'type':type,
				'nobid':nobid,
				'country':country,
				'status':status,
				'topics':topics,
				'visibility':visibility,
				'priority':priority,
				'language':language,
				'if_claimed':if_claimed,
				'if_unclaimed':if_unclaimed,
				'acceptable_claim':acceptable_claim,
				'footnote':footnote,
				'image':image,
				'user_id':user
			},
			method:'POST',
			success:function(result){
				console.log(result);
				// var origin   = window.location.origin; 
				// window.location.href = origin+"/browse";
				window.location.href = result;
			}
			});
	});

	jQuery('.like_b').on('click',function(e){
		e.preventDefault();
		var post_id = jQuery(this).data('id');
		var user_id = jQuery(this).data('user');
		if(user_id < 1){
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{'action':'factbid_add_thumbs_up','post_id':post_id,'user_id':user_id},
			method:'POST',
			success:function(result){
				console.log(result);
				location.reload();
			}
			});
	});
	jQuery('.unlike_b').on('click',function(e){
		e.preventDefault();
		var post_id = jQuery(this).data('id');
		var user_id = jQuery(this).data('user');
		if(user_id < 1){
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{'action':'factbid_add_thumbs_down','post_id':post_id,'user_id':user_id},
			method:'POST',
			success:function(result){
				console.log(result);
				location.reload();
			}
			});
	});

	jQuery('#edit_factbid').on('click',function(e){
		e.preventDefault();
		var parent = jQuery('#factbid-form #parent').val();
		var title = jQuery('#factbid-form #title').val();
		var user = jQuery(this).data("user");
		var image = jQuery('#factbid-form input[name="factbid-img"]').val();
		// var description = jQuery('#factbid-form #description').val();
		var type = jQuery('#factbid-form #type').val();
		var country = jQuery('#factbid-form #country').val();
		var status = jQuery('#factbid-form #status').val();
		var topics = jQuery('#factbid-form #topics').val();
		var visibility = jQuery('#factbid-form #visibility').val();
		var priority = jQuery('#factbid-form #priority').val();
		var language = jQuery('#factbid-form #language').val();
		var nobid = jQuery('input[name="nobid"]:checked').val();

		var description = get_tinymce_content('description');
		var if_claimed = get_tinymce_content('if_claimed');
		var if_unclaimed = get_tinymce_content('if_unclaimed');
		var acceptable_claim = get_tinymce_content('acceptable_claim');


		
		// var footnote = tinyMCE.get('footnote').getContent();
		var footnote = "";

		var old_post_id = jQuery('input[name="old_post_id"]').val();
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{'action':'edit_factbid',
				'parent':parent,
				'title':title,
				'description':description,
				'type':type,
				'nobid':nobid,
				'country':country,
				'status':status,
				'topics':topics,
				'visibility':visibility,
				'priority':priority,
				'language':language,
				'if_claimed':if_claimed,
				'if_unclaimed':if_unclaimed,
				'acceptable_claim':acceptable_claim,
				'footnote':footnote,
				'old_post_id':old_post_id,
				'image':image,
				'user_id':user
			},
			method:'POST',
			success:function(result){
				// var origin   = window.location.origin; 
				// window.location.href = origin+"/browse";
				window.location.href = result;
			}
			});
	});
});

jQuery(function($){

	// on upload button click
	$('body').on( 'click', '.factbid-upl', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
				type : 'image'
			},
			button: {
				text: 'Use this image' // button label text
			},
			multiple: false
		}).on('select', function() { // it also has "open" and "close" events
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			button.html('<img src="' + attachment.url + '">').next().show().next().val(attachment.id);
		}).open();
	
	});

	// on remove button click
	$('body').on('click', '.factbid-rmv', function(e){

		e.preventDefault();

		var button = $(this);
		button.next().val(''); // emptying the hidden field
		button.hide().prev().html('Upload image');
	});


});