<?php include_once 'header.php';?>
<section id="main-content">
    <div class="container">
    <?php
    if(isset($_GET["user_id"])){
		$user_id = $_GET['user_id'];
		$url = ROOT_PATH."v1/getUserInfo/".$user_id;
		$response = curl_get_call_with_auth($url, $api_key);
		$response = json_decode($response,true);
		$organisation_name = $response['users'][0]['organisation_name'];
		$address = $response['users'][0]['address'];
		$country = $response['users'][0]['country'];
		$state = $response['users'][0]['state'];
		$postcode = $response['users'][0]['postcode'];
		$suburb = $response['users'][0]['suburb'];
		$primary_contact = $response['users'][0]['primary_contact'];
		$phone = $response['users'][0]['phone'];
		$email = $response['users'][0]['email'];
		$category = $response['users'][0]['category'];
		$residence = $response['users'][0]['residence'];
		$user_role = $response['users'][0]['user_role'];
		$organisation_description = $response['users'][0]['organisation_description'];
		$image_url = $response['users'][0]['image_url'];
		$image_name = $response['users'][0]['image_name'];

		
		$url_country = ROOT_PATH.'v1/countrieslist';
		$url_state = ROOT_PATH.'v1/statesofcountry/'.$country;
		$url_state = str_replace(" ","+",$url_state);
		$url_postcode = ROOT_PATH.'v1/postcodesofstate/'.$state;
		$url_postcode = str_replace(" ","+",$url_postcode);
		$url_suburb = ROOT_PATH.'v1/suburbsofpostcode/'.$postcode;
		$url_suburb = str_replace(" ","+",$url_suburb);
		$url_category = ROOT_PATH.'v1/levelOneClass';

		$response_country = curl_get_call($url_country);
		$response_country = json_decode($response_country,true);

		$response_state = curl_get_call_with_auth($url_state, $api_key);
		$response_state = json_decode($response_state,true);

		$response_postcode = curl_get_call_with_auth($url_postcode, $api_key);
		$response_postcode = json_decode($response_postcode,true);

		$response_suburb = curl_get_call_with_auth($url_suburb, $api_key);
		$response_suburb = json_decode($response_suburb,true);

		$response_category = curl_get_call($url_category);
		$response_category = json_decode($response_category,true);

		//echo $url_postcode;
		//echo count($response_postcode['postcodes']);

		?>

        <div class="page-header">
            <h3>Step 1: Account Details</h3>
        </div>
        <form class="form-horizontal user-access" role="form" id="formID">
        	<input  type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>"/>
        	<input  type="hidden" id="user_role" name="user_role" value="3"/>
        	<input  type="hidden" id="category" name="category" value="<?php echo $category;?>"/>
        	<input  type="hidden" id="current_image" name="current_image" value="<?php echo $image_name;?>"/>
            <div class="form-group">
                <label for="organisation_name" class="col-sm-2 col-md-2 control-label">Organisation:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" id="organisation_name" name="organisation_name" placeholder="" value="<?php echo $organisation_name;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-sm-2 col-md-2 control-label">Address:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?php echo $address;?>">
                </div>
            </div>
            <div class="form-group">
            	<div class="col-xs-12 col-sm-6 col-md-6 form-group-inner">
                    <label for="country" class="col-sm-4 col-md-4 control-label">Country:</label>
                    <div class="col-sm-8 col-md-7">
                        <select id="country" name="country">
                        	<option data="0" value="0">Select Country</option>
						<?php
						if(count($response_country['countries'])>0){
							for($i=0; $i<count($response_country['countries']); $i++) {
								$id = $response_country['countries'][$i]['country_id'];
								$name = $response_country['countries'][$i]['country_name'];?>
								<option value="<?php echo $name;?>" data="<?php echo $id;?>" <?php if($country==$name){echo 'selected';};?>><?php echo $name;?></option><?php
							}
						}?>
							
						</select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 form-group-inner">
                    <label for="state" class="col-sm-4 col-md-2 control-label">State:</label>
                    <div class="col-sm-8 col-md-6 select-state">
                        <select class="state-select <?php if($country != 'Australia'){echo 'hiden';}?>" id="state" name="state">
                        	<option data="0" value="0">Select State</option>
                        <?php
						if(count($response_state['states'])>0){
							for($i=0; $i<count($response_state['states']); $i++) {
								$id = $response_state['states'][$i]['state_id'];
								$name = $response_state['states'][$i]['state_name'];?>
								<option value="<?php echo $name;?>" data="<?php echo $id;?>" <?php if($state==$name){echo 'selected';};?>><?php echo $name;?></option><?php
							}
						}?>
                        </select>
                        <input type="text" id="state-text" class="form-control validate[required] text-input state-text <?php if($country == 'Australia'){echo 'hiden';}?>" name="state-text" value="<?php echo $state;?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-6 form-group-inner">
                    <label for="postcode" class="col-sm-4 col-md-4 control-label">Postcode:</label>
                    <div class="col-sm-8 col-md-7 select-postcode">
                        <select class="postcode-select <?php if($country != 'Australia'){echo 'hiden';}?>" id="postcode" name="postcode">
                        	<option data="0" value="0">Select Postcode</option>
                        <?php
						if(count($response_postcode['postcodes'])>0){
							for($i=0; $i<count($response_postcode['postcodes']); $i++) {
								$id = $response_postcode['postcodes'][$i]['postcode_id'];
								$name = $response_postcode['postcodes'][$i]['postcode_name'];?>
								<option value="<?php echo $name;?>" data="<?php echo $id;?>" <?php if($postcode==$name){echo 'selected';};?>><?php echo $name;?></option><?php
							}
						}?>
                        </select>
                        <input type="text"  id="postcode-text" class="form-control validate[required] text-input postcode-text <?php if($country == 'Australia'){echo 'hiden';}?>" name="postcode-text" value="<?php echo $postcode;?>">
                    </div>
                    
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 form-group-inner">
                    <label for="suburb" class="col-sm-4 col-md-2 control-label">Suburb:</label>
                    <div class="col-sm-8 col-md-6 select-suburb">
                        <select class="suburb-select <?php if($country != 'Australia'){echo 'hiden';}?>" id="suburb" name="suburb">
                        	<option value="0">Select Suburb</option>
                        <?php
						if(count($response_suburb['suburbs'])>0){
							for($i=0; $i<count($response_suburb['suburbs']); $i++) {
								$id = $response_suburb['suburbs'][$i]['suburb_id'];
								$name = $response_suburb['suburbs'][$i]['suburb_name'];?>
								<option value="<?php echo $name;?>" data="<?php echo $id;?>" <?php if($suburb==$name){echo 'selected';};?>><?php echo $name;?></option><?php
							}
						}?>
                        </select>
                        <input type="text" id="suburb-text" class="form-control validate[required] text-input postcode-text  <?php if($country == 'Australia'){echo 'hiden';}?>" name="suburb-text" value="<?php echo $suburb;?>">
                    </div>
                    
                </div>
            </div>
            <div class="form-group">
                <label for="primary_contact" class="col-sm-2 col-md-2 control-label">Primary Contact:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" id="primary_contact" name="primary_contact" placeholder="" value="<?php echo $primary_contact;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-sm-2 col-md-2 control-label">Pone Number:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="<?php echo $phone;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 col-md-2 control-label">Email Address:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php echo $email;?>">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 col-md-2 control-label">Password:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="form-group">
                <label for="confirm_password" class="col-sm-2 col-md-2 control-label">Confirm Password:</label>
                <div class="col-sm-10 col-md-8">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-8 form-group-inner">
                    <label for="organisation_description" class="col-sm-2 col-md-3 control-label">Organization Description:</label>
                    <div class="col-sm-6 col-md-9">
                        <textarea class="form-control" rows="9" id="organisation_description" name="organisation_description"><?php echo $organisation_description;?></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 form-group-inner">                   
                    <div class="col-xs-12">
                        <!--<input type="file" name="file_uploder" class="hidden"/>
                        <div class="upload-drop-zone" id="drop-zone">
                            Upload Logo
                        </div>-->
                        <div id="imagePreview" class="upload-drop-zone drop-zone">
                        	<img src="<?php echo $image_url;?>" width="147px" height="147px"/>
                        </div>
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
                	<input type="checkbox" id="privacy" name="privacy">
					<label class="checkbox" for="privacy"> I agree to the Yourlink <a href="#"><span class="sr-note">Terms & Conditions. </label>
                    <!--<div class="checkbox">
                        <label>
                            <input type="checkbox" id="privacy"> I agree to the Yourlink <a href="#"><span class="sr-note">Terms & Conditions.</span></a>
                        </label>
                    </div>-->
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
        <?php
		}
		else
		{
			header('Location: users-service-provider.php');
		}
		?>
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
	            	$("#imagePreview").html('');
	                $("#imagePreview").css("background-image", "url("+this.result+")");
	            }
	        }
	    });
	});
	$(document).ready(function() {	
		$("#back").click(function(){
			pageRedirect("users-residence.php");
		});
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var url = "<?php echo ROOT_PATH;?>v1/updateProfile";
			var formData = new FormData($('form#formID')[0]);
			ajaxPostCallWithFileAuth(api_key, url, formData, OnSuccessFunction);	
		});
		
		$('#privacy').change(function() {
	        if ($(this).is(':checked')) {
	        	$('#submit').removeAttr('disabled');	            
	        } else {
	            $('#submit').attr('disabled', 'disabled');
	        }
        });
        
		var country_name = $('#country option:selected').text();
        if(country_name == 'Australia'){
			ShowDropdown();
		}
		else
		{
			HideDropdown();
		}
    
		
		$("#country").change(function(){
			var country_id = $('option:selected', this).attr('data');
			var country_name = $('#country option:selected').text();
			if(country_name == 'Australia'){
				ShowDropdown();
				var url = "<?php echo ROOT_PATH;?>v1/stateofcountry/" + country_id;
				//bind state dropdown
				ajaxGetCall(url, OnSuccessFunctionState);
			}
			else
			{
				HideDropdown();
				$("#state-text").val("");
				$("#postcode-text").val("");
				$("#suburb-text").val("");
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

		var jEl = $("#message span");          
		jEl.text(response.message).fadeIn(1000);
		setTimeout(function () { jEl.fadeOut(1000) }, 5000);
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
		$("#postcode").html("");
		$(".select-postcode .holder").html("Select Postcode");
		var option_postcode = $("<option data='0' value='0'>Select Postcode</option>");
		$("#postcode").append(option_postcode);
		
		$("#suburb").html("");
		$(".select-suburb .holder").html("Select Suburb");
		var option_suburb = $("<option data='0' value='0'>Select Suburb</option>");
		$("#suburb").append(option_suburb);
					
		$("#state").html("");
		$(".select-state .holder").html("Select State");
		var option = $("<option data='0' value='0'>Select State</option>");
		$("#state").append(option);
		$.each(response.states , function(key , value){ // First Level
			var options = $('<option data="'+value.state_id+'" value="'+value.state_name+'" >' + value.state_name + '</option>');
			$("#state").append(options);    
		});
	};
	function OnSuccessFunctionPostcode(response){
		$("#postcode").html("");
		$(".select-postcode .holder").html("Select Postcode");
		var option = $("<option data='0' value='0'>Select Postcode</option>");
		$("#postcode").append(option);
		
		$.each(response.postcodes , function(key , value){ // First Level
			var options = $('<option data="'+value.postcode_id+'" value="'+value.postcode_name+'">' + value.postcode_name + '</option>');
			$("#postcode").append(options);    
		});
  
  		$("#suburb").html("");
		$(".select-suburb .holder").html("Select Suburb");
		var option_suburb = $("<option data='0' value='0'>Select Suburb</option>");
		$("#suburb").append(option_suburb);
	};
	function OnSuccessFunctionSuburb(response){
		$("#suburb").html("");
		$(".select-suburb .holder").html("Select Suburb");
		var option = $("<option data='0' value='0'>Select Suburb</option>");
		$("#suburb").append(option);
		$.each(response.suburbs , function(key , value){ // First Level
			var options = $('<option data="'+value.suburb_id+'" value="'+value.suburb_name+'">' + value.suburb_name + '</option>');
			$("#suburb").append(options);    
		});
	};
	function HideDropdown(){
		$(".state-select").parent('.select-wrapper').addClass('hiden');
		$(".state-text").removeClass('hiden');
		$(".postcode-select").parent('.select-wrapper').addClass('hiden');
		$(".postcode-text").removeClass('hiden');
		$(".suburb-select").parent('.select-wrapper').addClass('hiden');
		$(".suburb-text").removeClass('hiden');
	}
	function ShowDropdown(){
		$(".state-select").parent('.select-wrapper').removeClass('hiden');
		$(".state-text").addClass('hiden');
		$(".postcode-select").parent('.select-wrapper').removeClass('hiden');
		$(".postcode-text").addClass('hiden');
		$(".suburb-select").parent('.select-wrapper').removeClass('hiden');
		$(".suburb-text").addClass('hiden');
	}
</script>