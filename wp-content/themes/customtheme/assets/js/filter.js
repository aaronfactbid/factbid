jQuery(document).ready(function(){
	jQuery('.filter_select').on('change',function(){

		var status_filter = jQuery('#status_filter').val();
		var sort_filter = jQuery('#sort_filter').val();
		var topic_filter = jQuery('#topic_filter').val();
		var author_filter = jQuery('#author_filter').val();
		var language_filter = jQuery('#language_filter').val();
		listFacts(status_filter,sort_filter,topic_filter,language_filter,author_filter);
	});

	// jQuery('#search_go').on('click',function(e){
	// 	e.preventDefault();
	// 	var search2 = jQuery('#search2').val();
	// 	listFactsSearch(search2);
	// });
	function listFacts(status_filter='',sort_filter='',topic_filter='',language_filter='',author_filter='') {
	    var x = jQuery.ajax({
	            url:my_ajax_object.ajaxurl,
	            method:'POST',
	            data:{'action':'filter_facts','status_filter':status_filter,'sort_filter':sort_filter,'topic_filter':topic_filter,'language_filter':language_filter,'author_filter':author_filter},
	            // success:function(response) {
	            // 	console.log('came');
	            //     // jQuery('#append-html').html('');
	            //     // jQuery("#myDropdown").removeClass("show");
	                
	            // }
	        });
	        x.done(function(response){
	            	console.log('came');
	            	console.log(response);
	            var	res = JSON.parse(response);
	            console.log(response);
	            	jQuery('#append-html').html(res);
	            });   
	        x.fail(function(response){
	            	console.log('error');
	            	
	            });      

	}
	// function listFactsSearch(search2){
	// 	var x = jQuery.ajax({
	// 	    url:my_ajax_object.ajaxurl,
	// 	    method:'POST',
	// 	    data:{'action':'search_facts','status_filter':search2});
	// 	x.done(function(response){
	// 		console.log('came');
	// 		console.log(response);
	// 		var	res = JSON.parse(response);
	// 		console.log(response);
	// 		jQuery('#append-html').html(res);
	// 	});   
	// 	x.fail(function(response){
	// 		console.log('error');
	// 	});
	// }

	jQuery('.place-bid').on('click',function(e){
		e.preventDefault();
		
		var pfactbid = jQuery(this).data('factbid');
		var bidid = jQuery(this).data('bidid');
		var user_id = jQuery(this).data('user');
		if(bidid){
			console.log("if");
			var visibility = jQuery('input[name="visibility'+bidid+'"]:checked').val();
			var amount = jQuery('#totalAmount'+bidid).val();
			var bid_comments = tinyMCE.get('bid_comments'+bidid).getContent();
			var bid_conditions = tinyMCE.get('bid_conditions'+bidid).getContent();
		} else {
			console.log("else");
			var visibility = jQuery('input[name="visibility"]:checked').val();
			var amount = jQuery('#totalAmount').val();
			var bid_comments = tinyMCE.get('bid_comments').getContent();
			var bid_conditions = tinyMCE.get('bid_conditions').getContent();
		}
		var data_array = {
			"visibility":visibility,
			"amount":amount,
			"bid_comments":bid_comments,
			"bid_conditions":bid_conditions,
			"pfactbid":pfactbid,
			"bidid":bidid,
			"user_id":user_id
		};
		console.log(data_array);

		var s = jQuery.ajax({
	            url:my_ajax_object.ajaxurl,
	            method:'POST',
	            data:{
					'action':'add_bid',
					'visibility':visibility,
					'pfactbid':pfactbid,
					'user_id':user_id,
					'amount':amount,
					'bid_comments':bid_comments,
					'bid_conditions':bid_conditions,
					'bidid':bidid
				},
	            
	        });
	        s.done(function(response){
				console.log('came');
				console.log(response);
				location.reload();
	            });   
	        s.fail(function(response){
	            	console.log('error');
	            	location.reload();
	            });     
		
	});

	jQuery('.create-claim').on('click',function(e){
		e.preventDefault();
		var visibility = jQuery('input[name="visibility"]:checked').val();
		var paymentMethods = document.getElementsByClassName('selected-method');
		var selectedPayments = [];
        for(var i=0;i<paymentMethods.length;i++){
            if(paymentMethods[i].checked){
                selectedPayments.push(paymentMethods[i].value);
            }
        }
			var wallet = jQuery('#wallet').val();
			var swift = jQuery('#swift').val();
			var paypalEmail = jQuery('#paypal-email').val();
			var bankName = jQuery('#bank-name').val();
			var beneficiaryName = jQuery('#beneficiary-name').val();
			var beneficiaryAddress = jQuery('#beneficiary-address').val();
			var zelleAddress = jQuery('#zelle-address').val();
			var aba = jQuery('#aba').val();
	
		
		var selectedFacts = [];
		var element1 = document.getElementsByClassName('selected-factbids');
        for(var i=0;i<element1.length;i++){
            if(element1[i].checked){
                selectedFacts.push(element1[i].value);
            }
        }
		var pfactbid = jQuery(this).data('factbid');
		var user_id = jQuery(this).data('user');
		var title = jQuery('#title').val();
		var subtitle = jQuery('#subtitle').val();
		var comments = jQuery('#comments').val();
		var description = tinyMCE.get('description').getContent();



		var s = jQuery.ajax({
	            url:my_ajax_object.ajaxurl,
	            method:'POST',
	            data:{
					'action':'create_claim',
					'user_id':user_id,
					'selectedFacts':selectedFacts,
					'visibility':visibility,
					'selectedPayments':selectedPayments,
					'wallet':wallet,
					'swift':swift,
					'paypalEmail':paypalEmail,
					'bankName':bankName,
					'beneficiaryName':beneficiaryName,
					'beneficiaryAddress':beneficiaryAddress,
					'zelleAddress':zelleAddress,
					'aba':aba,
					'title':title,
					'subtitle':subtitle,
					'description':description,
					'comments':comments
				},
	        });
	        s.done(function(response){
				console.log(response);
	 			var origin   = window.location.origin; 
				window.location.href = origin+"/"+pfactbid;
	            	
	            });   
	        s.fail(function(response){
	            	console.log('error');
	            	location.reload();
	            });     
		
	});


	jQuery('.update-claim').on('click',function(e){
		e.preventDefault();
		var visibility = jQuery('input[name="visibility"]:checked').val();
		var paymentMethods = document.getElementsByClassName('selected-method');
		var selectedPayments = [];
        for(var i=0;i<paymentMethods.length;i++){
            if(paymentMethods[i].checked){
                selectedPayments.push(paymentMethods[i].value);
            }
        }
			var wallet = jQuery('#wallet').val();
			var swift = jQuery('#swift').val();
			var paypalEmail = jQuery('#paypal-email').val();
			var bankName = jQuery('#bank-name').val();
			var beneficiaryName = jQuery('#beneficiary-name').val();
			var beneficiaryAddress = jQuery('#beneficiary-address').val();
			var zelleAddress = jQuery('#zelle-address').val();
			var aba = jQuery('#aba').val();
	
		
		var selectedFacts = [];
		var element1 = document.getElementsByClassName('selected-factbids');
        for(var i=0;i<element1.length;i++){
            if(element1[i].checked){
                selectedFacts.push(element1[i].value);
            }
        }
		
		var pfactbid = jQuery(this).data('factbid');
		var claim_id = jQuery(this).data('claimid');
		var user_id = jQuery(this).data('user');
		var title = jQuery('#title').val();
		var subtitle = jQuery('#subtitle').val();
		var comments = jQuery('#comments').val();
		var description = tinyMCE.get('description').getContent();



		var s = jQuery.ajax({
	            url:my_ajax_object.ajaxurl,
	            method:'POST',
	            data:{
					'action':'update_claim',
					'user_id':user_id,
					'selectedFacts':selectedFacts,
					'visibility':visibility,
					'selectedPayments':selectedPayments,
					'wallet':wallet,
					'swift':swift,
					'paypalEmail':paypalEmail,
					'bankName':bankName,
					'beneficiaryName':beneficiaryName,
					'beneficiaryAddress':beneficiaryAddress,
					'zelleAddress':zelleAddress,
					'aba':aba,
					'title':title,
					'subtitle':subtitle,
					'description':description,
					'comments':comments,
					'claim_id':claim_id
				},
	        });
	        s.done(function(response){
				console.log('came');
				console.log(response);
				location.reload();
	            	
	            });   
	        s.fail(function(response){
	            	console.log('error');
	            	location.reload();
	            });     
		
	});

	var sum = 0;
	jQuery('.amount').on('change',function(e){
		sum = parseFloat(this.value);
		jQuery('.totalAmount').val(sum);
	});

	jQuery(".post-factbid").on('click', function(e){
		e.preventDefault();
		var factbid_id = jQuery(this).data("id");
		console.log("clicked");
		var s = jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			method:'POST',
			data:{
				'action':'post_factbid',
				'factbid_id':factbid_id
			},
		});
		s.done(function(response){
			console.log('came');
			console.log(response);
			location.reload();
				
			});  
	})

	jQuery(".post-claim").on('click', function(e){
		e.preventDefault();
		var claim_id = jQuery(this).data("id");
		console.log("clicked");
		var s = jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			method:'POST',
			data:{
				'action':'post_claim',
				'claim_id':claim_id
			},
		});
		s.done(function(response){
			console.log('came');
			console.log(response);
			location.reload();
				
			});  
	})
	jQuery('.place-response').on('click',function(e){
		e.preventDefault();
		
		var status = jQuery('input[name="status"]:checked').val();
		var user_id = jQuery(this).data('user');
		var id_factbid = jQuery(this).data('factbid');
		var id_claim = jQuery(this).data('claim');
		var status_explain = tinyMCE.get('status_explain').getContent();
		var paymentMethods = document.getElementsByClassName('selected-method');
		var wallet = jQuery('#wallet').val();
		var swift = jQuery('#swift').val();
		var paypalEmail = jQuery('#paypal-email').val();
		var account = jQuery('#account').val();
		var zelleAddress = jQuery('#zelle-address').val();
		var aba = jQuery('#aba').val();
		var amount = jQuery('#amount').val();
		var selectedPayments = [];
        for(var i=0;i<paymentMethods.length;i++){
            if(paymentMethods[i].checked){
                selectedPayments.push(paymentMethods[i].value);
            }
        }
      		var s = jQuery.ajax({
	            url:my_ajax_object.ajaxurl,
	            method:'POST',
	            data:{
					'action':'add_response',
					'status':status,
					'status_explain':status_explain,
					'id_factbid':id_factbid,
					'id_claim':id_claim,
					'user_id':user_id,
					'selectedPayments':selectedPayments,
					'wallet':wallet,
					'swift':swift,
					'paypalEmail':paypalEmail,
					'account':account,
					'zelleAddress':zelleAddress,
					'aba':aba,
					'amount':amount,
			
				},
	        });
	        s.done(function(response){
				console.log('came');
				console.log(response);
				location.reload();
	            	
	            });   
	        s.fail(function(response){
	            	console.log('error');
	            	location.reload();
	            });     
		
	});
jQuery(':radio[name="status"]').change(function() {
	var status = jQuery(this).filter(':checked').val();
	if(status == 3 || status == 4){
		jQuery("#pay-amount").fadeOut();
	}
	else{
		jQuery("#pay-amount").fadeIn();
	}
});
	jQuery('.btn-bidEdit').click(function(e){
		e.preventDefault();
		var bid = jQuery(this).data("id");
		var thisp = jQuery(this);
		var modal = thisp.next('.bidEditModal');
		var s = jQuery.ajax({
			type: "GET",
			url: my_ajax_object.ajaxurl,
			method:'POST',
			data: {
				'action':'edit_bid',
				'id_bid':bid
			}
		});
		s.done(function(response) {
			
			// get the ajax response data
			var data = response;
			// update modal content
			// show modal
			jQuery(modal).modal('show');
			
		});
			
	});

	jQuery('.btn-bidView').click(function(e){
		e.preventDefault();
		var bid = jQuery(this).data("id"); 
		var thisp = jQuery(this);
		var modal = thisp.next('.bidModalView');
		var s = jQuery.ajax({
			type: "GET",
			url: my_ajax_object.ajaxurl,
			method:'POST',
			data: {
				'action':'view_bid',
				'id_bid':bid
			}
		});
		s.done(function(response) {
			
			// get the ajax response data
			var data = response;
			// update modal content
			jQuery(modal).children('.modal-body').text(data);
			// show modal
			jQuery(modal).modal('show');
			
		});
	});

	jQuery(document).ready(function(){
		jQuery('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
			localStorage.setItem('activeTab', $(e.target).attr('href'));
		});
		var activeTab = localStorage.getItem('activeTab');
		if(activeTab){
			jQuery('[href="' + activeTab + '"]').tab('show');
		}
	});

	jQuery('.rating').on('click',function(e){
		e.preventDefault();
		var profile_id = jQuery(this).data('id');
		var rating = jQuery(this).data('rating');
		var user_id = jQuery(this).data('user');
		if(user_id < 1 || profile_id < 1){
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{
				'action':'factbid_add_profile_rating',
				'profile_id':profile_id,
				'user_id':user_id,
				'rating':rating
			},
			method:'POST',
			success:function(result){
				console.log(result);
				location.reload();
			}
			});
	});

	jQuery('.post_request_button').on('click',function(e){
		e.preventDefault();
		var user_id = jQuery(this).data('id');
		var content = jQuery("#post_request").val();
		if(user_id < 1){
			console.log("User not logged in");
			return;
		}
		if(content == ""){
			alert("Fill the Intention of your post to submit.!!");
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{
				'action':'factbid_update_post_request',
				'user_id':user_id,
				'content':content
			},
			method:'POST',
			success:function(result){
				console.log(result);
				location.reload();
			}
			});
	});

	jQuery('.approve_request_button').on('click',function(e){
		e.preventDefault();
		var user_id = jQuery(this).data('id');
		if(user_id < 1){
			console.log("User not logged in");
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{
				'action':'factbid_approve_post_request',
				'user_id':user_id
			},
			method:'POST',
			success:function(result){
				console.log(result);
				location.reload();
			}
			});
	});

	function addShowPassword(){
		var img = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/></svg>';
		var chtml = '<button id="toggle-password" type="button" aria-label="Show password as plain text. Warning: this will display your password on the screen.">'+img+'</i></button>'
		jQuery(chtml).insertAfter('#loginform-custom #user_pass');
	}
	addShowPassword();
	jQuery(document).on('click','#toggle-password', function () {
			
		// var x = jQuery('#loginform-custom #user_pass');
		// console.log(x);
		// console.log(x.type);
		var x = document.getElementById("user_pass");
		if (x.type === "password") {
			console.log("if");
			x.type = "text";
		} else {
			console.log("else");
			x.type = "password";
		}
	});

	function preg_match (regex, str) {
		if (new RegExp(regex).test(str)){
		  return regex.exec(str);
		}
		return false;
	}
	function iterateLoop(value, index, array) {
		html += "<li><small><em>"+value+"</em></small></li>";
	}

	jQuery(document).on('keyup', '#register_form #password', function(){
		jQuery(".errorMPassword").remove();
		let password = jQuery(this).val();
		if(password == ""){
			return;
		}
		var item = checkPassword(password);
		// console.log(item);
		if(item && Object.entries(item).length != 0){
			if(Object.values(item).every((v) => v === false)){
				return;
			}else{
				var html = "<div class='errorM errorMPassword'><ul>";
				for(var key in item){
					if(item[key] != false){
						html += "<li><small><em>"+item[key]+"</em></small></li>";
					}
				}
				html += "</ul></div>";
				jQuery(html).insertAfter(this);
			}
			
		}
	});

	function checkPassword(password){
		let lowerL = new RegExp('(?=.*[a-z])');
		let upperL = new RegExp('(?=.*[A-Z])');
		let digitL = new RegExp('(?=.*[0-9])');
		let specialL = new RegExp('(?=.*[^A-Za-z0-9])');
		let lengthL = new RegExp('(?=.{8,})');

		var lowerCheck = "Atleast one lowercase letter required!";
		var upperCheck = "Atleast one Uppercase letter required!";
		var digitCheck = "Atleast one Digit required!";
		var specialCheck = "Atleast one Special case character required!";
		var lengthCheck = "Password should be greater than 8 character long.!";


		if(lowerL.test(password)) {
			lowerCheck = false;
		}
		if(upperL.test(password)) {
			upperCheck = false;
		}
		if(digitL.test(password)) {
			digitCheck = false;
		}
		if(specialL.test(password)) {
			specialCheck = false;
		}
		if(lengthL.test(password)) {
			lengthCheck = false;
		}
		var returnarray = {
			'lowerCheck':lowerCheck,
			'upperCheck':upperCheck,
			'digitCheck':digitCheck,
			'specialCheck':specialCheck,
			'lengthCheck':lengthCheck
		};
		return returnarray;
	}
	jQuery(document).on('keyup', '#register_form #password_confirmation', function(){
		jQuery(".errorMpassword_confirmation").remove();
		let password = jQuery('#register_form #password').val();
		let password_confirmation = jQuery(this).val();
		if(password_confirmation == ""){
			return;
		}
		if(password.localeCompare(password_confirmation) != 0){
			var html = "<div class='errorM errorMpassword_confirmation'><ul>";
			html += "<li><small><em>Password Doesn't match</em></small></li>";
			html += "</ul></div>";
			jQuery(html).insertAfter(this);
		}
	});
	jQuery(document).on('change', '#register_form #username', function(){
		jQuery(".errorMusername").remove();
		let username = jQuery(this).val();
		if(username == ""){
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{
				'action':'checking_username',
				'username':username
			},
			method:'POST',
			success:function(result){
				let res = JSON.parse(result);
				if(res.length != 0){
					let html = "<div class='errorM errorMusername'><ul>";
					res.map(function(value){
						html += `<li><small><em>${value}</em></small></li>`;
					});
					html += "</ul></div>";
					jQuery(html).insertAfter('#register_form #username');
				}
			}
		});
	});
	jQuery(document).on('change', '#register_form #useremail', function(){
		jQuery(".errorMuseremail").remove();
		let useremail = jQuery(this).val();
		if(useremail == ""){
			return;
		}
		jQuery.ajax({
			url:my_ajax_object.ajaxurl,
			data:{
				'action':'checking_email',
				'useremail':useremail
			},
			method:'POST',
			success:function(result){
				let res = JSON.parse(result);
				if(res.length != 0){
					var html = "<div class='errorM errorMuseremail'><ul>";
					res.map(function(value){
						html += `<li><small><em>${value}</em></small></li>`;
					});
					html += "</ul></div>";
					jQuery(html).insertAfter('#register_form #useremail');
				}
			}
		});
	});
});