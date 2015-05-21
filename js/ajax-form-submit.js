(function ($) {
    //====================================================================================================//
    //========================================ajax call using form.js=====================================//
    //====================================================================================================//

    ajaxPostCallWithAuth = function (apiKey,successMessage,redirectPath) {	
        $('form').ajaxForm({
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Authorization', apiKey);
				$("#message span").text("");
				//$('#loader').css('background', 'url(../images/loader.gif) no-repeat');
				//$('#loader').center();
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
			},
			success: function(response) {
				//$('#loader').css('background', 'none');
				$.unblockUI();
			},
			complete: function(response) {				
				var obj = jQuery.parseJSON(response.responseText);
				if(obj.message==successMessage){				
					pageRedirect(redirectPath);
				}
				else{
					var jEl = $("#message span");          
					jEl.text(obj.message).fadeIn(1000);
					setTimeout(function () { jEl.fadeOut(1000) }, 5000);
				}			
				//$('#loader').css('background', 'none');
				$.unblockUI();
			},
			error: function(response){
				var obj = jQuery.parseJSON(response.responseText);
				var jEl = $("#message span");            
				jEl.text(obj.error).fadeIn(1000);
				setTimeout(function () { jEl.fadeOut(1000) }, 5000);
				//$('#loader').css('background', 'none');
				$.unblockUI();
				
			}
		});
    };
	
	ajaxPostCall = function (url, data, OnSuccessFunction) {
			
        $.ajax({					
			type: "post",
			url: url,
			data: data,
			cache: false,
			//dataType: 'json',
			beforeSend: function(xhr) {
				//xhr.setRequestHeader('Authorization', apiKey);
				//$("#message span").text("");
				//$('#formID').fadeOut();
				//$('#loader').css('background', 'url(images/loader.gif) no-repeat');
				//$('#loader').center();
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
				//alert(data);
			},
			complete: function(){
				//$('#loader').css('background', 'none');
				$.unblockUI();
			},
			success : OnSuccessFunction,
			//success : function(response){
			//	var obj = jQuery.parseJSON(response.responseText);
			//	alert(obj.message);
			//},
			error: function (error) {
				//$("#message span").text(error);
				alert(error.error);
				//$("#formID").effect("shake", {times:2}, 100);
			}

		});
    };
	
	ajaxPostCallAuth = function (apiKey, url, data, OnSuccessFunction) {
        $.ajax({
        	url: url,					
			type: "POST",			
			data: data,
			cache: false,
			//dataType: 'json',
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Authorization', apiKey);
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
			},
			success : OnSuccessFunction,
			complete: function(){
				$.unblockUI();
			},			
			error: function (error) {
				alert(error.error);
			}
		});
    };
    
    ajaxPostCallWithFileAuth = function (apiKey, url, formData, OnSuccessFunction) {
        $.ajax({
			url: url,
			type: 'POST',
			data: formData,
			async: true,				
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Authorization', apiKey);
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
			},
			complete: function(){
				$.unblockUI();
			},
			error: function (error) {
				//$("#message span").text(error);
				//alert(error.error);
				$("#formID").effect("shake", {times:2}, 100);
			},
			success: OnSuccessFunction,
			cache: false,
			contentType: false,
			processData: false
			
		});
		return false;
    };
    
    ajaxPostCallWithSuccessMsg = function (apiKey, url, formData, successMessage,redirectPath) {
        $.ajax({
			url: url,
			type: 'POST',
			data: formData,
			async: true,				
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Authorization', apiKey);
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
			},
			complete: function(){
				$.unblockUI();
			},
			error: function(response){
				//var response = jQuery.parseJSON(response);
				var jEl = $("#message span");            
				jEl.text(response.error).fadeIn(1000);
				setTimeout(function () { jEl.fadeOut(1000) }, 5000);
				$.unblockUI();
				
			},
			success: function(response){
				//var obj = jQuery.parseJSON(response);
				if(response.message==successMessage){				
					pageRedirect(redirectPath);
				}
				else{
					var jEl = $("#message span");          
					jEl.text(response.message).fadeIn(1000);
					setTimeout(function () { jEl.fadeOut(1000) }, 5000);
				}			
				$.unblockUI();
			},
			cache: false,
			contentType: false,
			processData: false

			
		});
		return false;
    };
    
    ajaxPostCallWithFile = function (url, formData, OnSuccessFunction) {
        $.ajax({
			url: url,
			type: 'POST',
			data: formData,
			async: true,				
			beforeSend: function(xhr) {
				//$("#message span").text("");
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
			},
			complete: function(){
				$.unblockUI();
			},
			error: function (error) {
				//$("#message span").text(error);
				//alert(error.error);
				$("#formID").effect("shake", {times:2}, 100);
			},
			success: OnSuccessFunction,
			cache: false,
			contentType: false,
			processData: false
			
		});
		return false;
    };
	
	
	//====================================================================================================//
    //===========================================ajax get call ===========================================//
    //====================================================================================================//
	ajaxGetCallWithAuth = function (apiKey, url, OnSuccessFunction) {	
        $.ajax({					
			type: "get",
			url: url,
			cache: false,
			dataType: 'json',
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Authorization', apiKey);
				$("#message span").text("");
				//$('#loader').css('background', 'url(../images/loader.gif) no-repeat');
				//$('#loader').center();
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
			},
			complete: function(){
				//$('#loader').css('background', 'none');
				$.unblockUI();
			},
			success : OnSuccessFunction,
			error: function (error) {
				//$("#message span").text(error);
				alert('error');
			}

		});
    };
	
	ajaxGetCall = function (url, OnSuccessFunction) {	
        $.ajax({					
			type: "get",
			url: url,
			cache: false,
			dataType: 'json',
			beforeSend: function(xhr) {
				//xhr.setRequestHeader('Authorization', apiKey);
				//$("#message span").text("");
				//$('#loader').css('background', 'url(images/loader.gif) no-repeat');
				//$('#loader').center(true);
				$.blockUI({ message: '<img src="images/loader.gif" /><br/> Processing' });
				//$('div.form').block({ message: '<img src="images/loader.gif" /><br/> Loading' });
			},
			complete: function(){
				//$('#loader').css('background', 'none');
				$.unblockUI();
				//$('div.form').unblock();
			},
			success : OnSuccessFunction,
			error: function (error) {
				//$("#message span").text(error);
				alert(error.error);
			}

		});
    };
	
	//====================================================================================================//
    //==================================update data using ajax put call ==================================//
    //====================================================================================================//
	updateDataWithPutCallWithAuth = function (apiKey, url, data) {	
        $.ajax({					
			type: "put",
			url: url,
			cache: false,
			dataType: 'json',
			data: data,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Authorization', apiKey);
				$("#message span").text("");
				$('#loader').css('background', 'url(../images/loader.gif) no-repeat');
			},
			success: function(response) {
				var obj = jQuery.parseJSON(response.responseText);
				if(obj.message==successMessage){				
					pageRedirect(redirectPath);
				}
				else{
					var jEl = $("#message span");          
					jEl.text(obj.message).fadeIn(1000);
					setTimeout(function () { jEl.fadeOut(1000) }, 5000);
				}			
				$('#loader').css('background', 'none');
			},
			complete: function(response) {				
				//$('#loader').css('background', 'none');
				$.unblockUI();
			},
			error: function(response){
				var obj = jQuery.parseJSON(response.responseText);
				var jEl = $("#message span");            
				jEl.text(obj.error).fadeIn(1000);
				setTimeout(function () { jEl.fadeOut(1000) }, 5000);
				//$('#loader').css('background', 'none');
				$.unblockUI();
			}
		});
    };
	
	pageRedirect = function (redirectPath) {
		window.location.replace(redirectPath);
	};
	
	getQueryStringValue = function (queryStringName) {
	    queryStringName = queryStringName.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + queryStringName + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	};
	scrolling = function () {
	    $("#pageData").niceScroll({ autohidemode: true });
	};
	
	timeConverter = function (UNIX_timestamp){
 		var a = new Date(UNIX_timestamp*1000);
 		var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
 		//var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
     	var year = a.getFullYear();
     	var month = months[a.getMonth()];
     	var date = (a.getDate()<10) ? '0' + a.getDate() : a.getDate();
	    var hour = (a.getHours()<10) ? '0' + a.getHours() : a.getHours();
	    var mini = (a.getMinutes()<10) ? '0' + a.getMinutes() : a.getMinutes();
	    var sec = (a.getSeconds()<10) ? '0' + a.getSeconds() : a.getSeconds();
	    var time = date + '-' + month + '-' + year + ' ' + hour + ':' + mini + ':' + sec ;
	    return time;
 }
	
})(jQuery);