jQuery(document).ready(function($){  // By default, in "no-conflict mode", so, would need to use jQuery instead of $, use this function so that you can use the $ from now on
	var employeeSortList = $('ul.employee-sort-list'); // Variable for employee list, get ui with the class employee-sort-list
	var loading = $('.loading'); // Next, get the loading image, so create variable called loading and set it to the class of loading
	var orderSaveMsg = $('.order-save-msg'); // Error message
	var orderSaveErr = $('.order-save-err'); // Save message

	employeeSortList.sortable({
		update: function(e, ui){
			loading.show(); //Show image
      // Make ajax call
			$.ajax({
				url: ajaxurl,
				type: 'post',
				dataType: 'json',
				data:{
					action: 'save_order',
					order: employeeSortList.sortable('toArray'),
          // Create localized token
					token: ED_EMPLOYEE_DISPLAY.token // Makes sure for is coming from the right place
				},
				success: function(res){ // Pass in response object
					loading.hide(); // Hide loading icon (it should only be showing when it's actually doing the work)
					if(true === res.success){ // if true is equal to response dot success, then that means it worked
						orderSaveMsg.show();
						setTimeout(function(){
							orderSaveMsg.hide(); // Save message for success
						}, 2000); // Hide after 2 seconds
					} else {
						orderSaveErr.show();
						setTimeout(function(){
							orderSaveErr.hide(); // Error message
						}, 2000); // Hide after 2 seconds
					}
				},
				error: function(err){ // Error function, pass in err
					orderSaveErr.show();
					setTimeout(function(){
							orderSaveErr.hide();
						}, 2000);
				}
			});
		}
	});
});
