<?php
include_once 'header.php';

$url_salutation = ROOT_PATH.'v1/salutations';
$url_country = ROOT_PATH.'v1/countrieslist';
$url_category = ROOT_PATH.'v1/levelOneClass';

$response_salutation = curl_get_call_with_auth($url_salutation, $api_key);
$response_salutation = json_decode($response_salutation,true);

$response_country = curl_get_call($url_country);
$response_country = json_decode($response_country,true);

$response_category = curl_get_call($url_category);
$response_category = json_decode($response_category,true);

?>
<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h3>Step 1: Account Details</h3>
        </div>
        <form class="form-horizontal user-access" role="form" id="formID">
            <div class="form-group">           	            
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="salutation" class="col-sm-2 col-md-4 control-label">Title:</label>
	                <div class="col-sm-6 col-md-6">
	                    <select class="form-control" id="salutation" name="salutation">
	                    	<option data="0" value="0">Select Title</option>
						<?php
						if(count($response_salutation['salutations'])>0){
							for($i=0; $i<count($response_salutation['salutations']); $i++) {?>
								<option data="<?php echo $response_salutation['salutations'][$i]['salutation_id']; ?>" value="<?php echo $response_salutation['salutations'][$i]['salutation_name']; ?>"><?php echo $response_salutation['salutations'][$i]['salutation_name']; ?></option><?php
							}
						}?>
							
						</select>
	                </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="gender" class="col-sm-2 col-md-3 control-label">Gender:</label>
                    <div class="col-sm-6 col-md-6">
                        <select class="form-control state-select" id="gender" name="gender">
                        	<option value="0">Select Gender</option>
                        	<option value="1">Male</option>
                        	<option value="2">Female</option>
                        </select>                        
                    </div>
                </div>            	                
            </div>
            <div class="form-group">
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="first_name" class="col-sm-2 col-md-4 control-label">First Name:</label>
	                <div class="col-sm-6 col-md-6">
	                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="">
	                </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="last_name" class="col-sm-2 col-md-3 control-label">Last Name:</label>
	                <div class="col-sm-6 col-md-6">
	                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="">
	                </div>
                </div>                
            </div>

            <div class="form-group">
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="phone" class="col-sm-2 col-md-4 control-label">Contact Number:</label>
	                <div class="col-sm-6 col-md-6">
	                    <input type="text" class="form-control" id="phone" name="phone" placeholder="">
	                </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="birth_date" class="col-sm-2 col-md-3 control-label">Date of Birth:</label>
                    <div class="col-sm-6 col-md-6">
	                    <input type="text" class="form-control" id="birth_date" name="birth_date" placeholder="">
	                </div>
                </div>
            
                
            </div>
            <div class="form-group">
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="country" class="col-sm-2 col-md-4 control-label">Country:</label>
                    <div class="col-sm-6 col-md-6">
                        <select class="form-control" id="country" name="country">
                        	<option data="0" value="0">Select Country</option>
						<?php
						if(count($response_country['countries'])>0){
							for($i=0; $i<count($response_country['countries']); $i++) {?>
								<option data="<?php echo $response_country['countries'][$i]['country_id']; ?>" value="<?php echo $response_country['countries'][$i]['country_name']; ?>"><?php echo $response_country['countries'][$i]['country_name']; ?></option><?php
							}
						}?>
							
						</select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="state" class="col-sm-2 col-md-3 control-label">State:</label>
                    <div class="col-sm-6 col-md-6">
                        <select class="form-control state-select" id="state" name="state">
                        	<option value="0">Select State</option>
                        </select>
                        <input type="text" id="state-text" class="form-control validate[required] text-input state-text hiden" name="state-text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="postcode" class="col-sm-2 col-md-4 control-label">Postcode:</label>
                    <div class="col-sm-6 col-md-6">
                        <select class="form-control postcode-select" id="postcode" name="postcode">
                        	<option value="0">Select Postcode</option>
                        </select>
                        <input type="text"  id="postcode-text" class="form-control validate[required] text-input postcode-text hiden" name="postcode-text">
                    </div>
                    
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
                    <label for="suburb" class="col-sm-2 col-md-3 control-label">Suburb:</label>
                    <div class="col-sm-6 col-md-6">
                        <select class="form-control suburb-select" id="suburb" name="suburb">
                        	<option value="0">Select Suburb</option>
                        </select>
                        <input type="text" id="suburb-text" class="form-control validate[required] text-input postcode-text hiden" name="suburb-text">
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
	                <label for="email" class="col-sm-2 col-md-4 control-label">Email Address:</label>
	                <div class="col-sm-6 col-md-6">
	                    <input type="text" class="form-control" id="email" name="email" placeholder="">
	                </div>
	            </div>
	            <div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
	            	<label for="category" class="col-sm-2 col-md-3 control-label">Category:</label>
	                <div class="col-sm-6 col-md-6">
	                    <select class="form-control" id="category" name="category">
	                    	<option value="0">Select Category</option>
							<?php									
							if(count($response_category['classes'])>0){
								for($i=0; $i<count($response_category['classes']); $i++) {?>
									<option value="<?php echo $response_category['classes'][$i]['level_one_class_id']; ?>"><?php echo $response_category['classes'][$i]['level_one_class_name']; ?></option><?php
								}
							}?>
										
	                    </select>
	                </div>
	            </div>
            </div>
            <div class="form-group">
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
            		<label for="password" class="col-sm-2 col-md-4 control-label">Password:</label>
	                <div class="col-sm-6 col-md-6">
	                    <input type="password" class="form-control" id="password" name="password" placeholder="">
	                </div>
            	</div>
            	<div class="col-xs-12 col-sm-12 col-md-6 form-group-inner">
            		<label for="confirm_password" class="col-sm-2 col-md-3 control-label">Confirm Password:</label>
	                <div class="col-sm-6 col-md-6">
	                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="">
	                </div>
            	</div>
                
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-8 form-group-inner">
                    <label for="organisation_description" class="col-sm-2 col-md-3 control-label">Organization Description:</label>
                    <div class="col-sm-6 col-md-9">
                        <textarea class="form-control" rows="9" id="organisation_description" name="organisation_description"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 form-group-inner">                   
                    <div class="col-xs-12">
                        <!--<input type="file" name="file_uploder" class="hidden"/>
                        <div class="upload-drop-zone" id="drop-zone">
                            Upload Logo
                        </div>-->
                        <div id="imagePreview" class="upload-drop-zone drop-zone"></div>
						<span class="btn btn-success fileinput-button">
					        <i class="glyphicon glyphicon-plus"></i>
					        <span>Add Profile Picture</span>
					        <!-- The file input field used as target for the file upload widget -->
					        <input type="file" name="profile" id="profile">
					    </span>
                    </div>
                    <!--<div class="col-xs-12">

                        <div class="btn-group button-upload" role="group "><button class="btn btn-success button-upload">Upload</button></div>

                    </div>-->
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="privacy"> I agree to the Yourlink <a href="#"><span class="sr-note">Terms & Conditions.</span></a>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  	<div style='width:80px;float:left'><input id="back" class="btn btn-primary" type="button" value="Back" name="back"/> </div>
					<div style='width:125px;float:left'><input id="submit" class="btn btn-primary" type="button" value="Submit" name="submit"/></div>				
					<div id='message' style='float:left;padding-top: 5px;'><span></span></div>
                </div>
            </div>
            
        </form>
    </div>
</section>
<?php include_once 'footer.php';?>
<script type="text/javascript">
	$(function() {
	    $("#profile").on("change", function()
	    {
	        var files = !!this.files ? this.files : [];
	        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
	 
	        if (/^image/.test( files[0].type)){ // only image file
	            var reader = new FileReader(); // instance of the FileReader
	            reader.readAsDataURL(files[0]); // read the local file
	 
	            reader.onloadend = function(){ // set image data as background of div
	                $("#imagePreview").css("background-image", "url("+this.result+")");
	            }
	        }
	    });
	});
	$(document).ready(function() {	
		$("#back").click(function(){
			pageRedirect("users-service-provider.php");
		});
		
		$("#submit").click(function(){
			var url = "<?php echo ROOT_PATH;?>v1/registration";
			var formData = new FormData($('form#formID')[0]);
			ajaxPostCallWithFile(url, formData, OnSuccessFunction);	
		});
		
		$('#privacy').change(function() {
	        if ($(this).is(':checked')) {
	        	$('#submit').removeAttr('disabled');	            
	        } else {
	            $('#submit').attr('disabled', 'disabled');
	        }
        });
    
		
		$("#country").change(function(){
			var country_id = $('option:selected', this).attr('data');
			var country_name = $('#country option:selected').text();
			if(country_name == 'Australia'){
				$(".state-select").removeClass('hiden');
				$(".state-text").addClass('hiden');
				$(".postcode-select").removeClass('hiden');
				$(".postcode-text").addClass('hiden');
				$(".suburb-select").removeClass('hiden');
				$(".suburb-text").addClass('hiden');
				var url = "<?php echo ROOT_PATH;?>v1/stateofcountry/" + country_id;
				//bind state dropdown
				ajaxGetCall(url, OnSuccessFunctionState);
			}
			else
			{
				$(".state-select").addClass('hiden');
				$(".state-text").removeClass('hiden');
				$(".postcode-select").addClass('hiden');
				$(".postcode-text").removeClass('hiden');
				$(".suburb-select").addClass('hiden');
				$(".suburb-text").removeClass('hiden');
			}
		});
		
		$("#state").change(function(){
			var state_id = $('option:selected', this).attr('data');
			var url = "<?php echo ROOT_PATH;?>v1/postcodeofstate/" + state_id;
			//bind postcode dropdown
			ajaxGetCall(url, OnSuccessFunctionPostcode);
		});	
			
		$("#postcode").change(function(){
			var postcode_id = $('option:selected', this).attr('data');
			var url = "<?php echo ROOT_PATH;?>v1/suburbofpostcode/" + postcode_id;
			//bind postcode dropdown
			ajaxGetCall(url, OnSuccessFunctionSuburb);
		});
	});
	function OnSuccessFunction(response){		
		//var response = $.parseJSON(response);		

		if(response.message == "You are successfully registered"){
			var url = 'login-processing.php';
			var email = $("#email").val();
			var password = $("#password").val();
			var tzOffset = (new Date()).getTimezoneOffset();					
			var data = "email="+email+"&password="+password+"&tzOffset="+tzOffset;
			ajaxPostCall(url, data, OnSuccessFunctionLogin);
		}
		else{
			var jEl = $("#message span");          
			jEl.text(response.message).fadeIn(1000);
			setTimeout(function () { jEl.fadeOut(1000) }, 5000);
		}
	};
	
	function OnSuccessFunctionLogin(response){
				
		if(response==0){
			pageRedirect('admin/index.php');
		}
		else if(response==2){
			pageRedirect('serviceprovider/index.php');
		}
		else if(response==3){
			pageRedirect('residence/index.php');
		}
		else{
			alert(response);
		}
	};
	
	function OnSuccessFunctionCategory(response){
		$("#category").html("");
		var option = $("<option value='0'>Select Category</option>");
		$("#category").append(option);
		$.each(response.categories , function(key , value){ // First Level
			var options = $('<option value="'+value.category_id+'">' + value.category_name + '</option>');
			$("#category").append(options);    
		});
		
	};
	function OnSuccessFunctionCountry(response){
		$("#country").html("");
		var option = $("<option data='0' value='0'>Select Country</option>");
		$("#country").append(option);
		$.each(response.countries , function(key , value){ // First Level
			var options = $('<option data="'+value.country_id+'" value="'+value.country_id+'">' + value.country_name + '</option>');
			$("#country").append(options);    
		});
		$('#loader').css('background', 'none');
	};
	function OnSuccessFunctionState(response){
		$("#state").html("");
		var option = $("<option data='0' value='0'>Select State</option>");
		$("#state").append(option);
		$.each(response.states , function(key , value){ // First Level
			var options = $('<option data="'+value.state_id+'" value="'+value.state_name+'" >' + value.state_name + '</option>');
			$("#state").append(options);    
		});
	};
	function OnSuccessFunctionPostcode(response){
		$("#postcode").html("");
		var option = $("<option data='0' value='0'>Select Postcode</option>");
		$("#postcode").append(option);
		$.each(response.postcodes , function(key , value){ // First Level
			var options = $('<option data="'+value.postcode_id+'" value="'+value.postcode_name+'">' + value.postcode_name + '</option>');
			$("#postcode").append(options);    
		});
	};
	function OnSuccessFunctionSuburb(response){
		$("#suburb").html("");
		var option = $("<option data='0' value='0'>Select Suburb</option>");
		$("#suburb").append(option);
		$.each(response.suburbs , function(key , value){ // First Level
			var options = $('<option data="'+value.suburb_id+'" value="'+value.suburb_name+'">' + value.suburb_name + '</option>');
			$("#suburb").append(options);    
		});
	};
	$(document).ready(function(){
		// $("#category").multiselect({
			// selectedList: 4
		// });
	});
</script>
