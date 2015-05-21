<?php include("header.php");?>
<?php
$url_country = ROOT_PATH.'v1/countries';

$response_country = curl_get_call_with_auth($url_country,$api_key);
$response_country = json_decode($response_country,true);
?>
<section id="main-content">
    <div class="container">	
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Add Suburb</h3>
			</div>
			<div class="panel-body">
				<form name="chapter-form" class="chapter-form form-horizontal" id="formID">
					<fieldset>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="country_id">Country:</label>
							<div class="col-lg-5">
								<select id="country_id" class="form-control validate[required] text-input" name="country_id">
									<option value="0">Select Country</option>
								<?php
								if(count($response_country['countries'])>0){
									for($i=0; $i<count($response_country['countries']); $i++) {?>
										<option value="<?php echo $response_country['countries'][$i]['country_id']; ?>">
										<?php echo $response_country['countries'][$i]['country_name']; ?>
										</option><?php
									}
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="state_id">State:</label>
							<div class="col-lg-5">
								<select id="state_id" class="form-control validate[required] text-input" name="state_id">
									<option value="0">Select State</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="postcode_id">Postcode:</label>
							<div class="col-lg-5">
								<select id="postcode_id" class="form-control validate[required] text-input" name="postcode_id">
									<option value="0">Select Postcode</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="suburb_name">Suburb Name:</label>
							<div class="col-lg-5">
								<input type="text" placeholder="Suburb Name" id="suburb_name" class="form-control validate[required] text-input" name="suburb_name">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-5 col-lg-offset-4">
								<div style='width:80px;float:left'><input id="back" class="btn btn-primary" type="button" value="Back" name="back"/> </div>
								<div style='width:125px;float:left'><input id="submit" class="btn btn-primary" type="button" value="Submit" name="submit"/></div>				
								<div id='message' style='float:left;padding-top: 5px;'><span></span></div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</section>
<?php include("footer.php");?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#formID").validationEngine();
	});
	
	$(document).ready(function() {
		$("#back").click(function(){
			pageRedirect("suburbs.php");
		});
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var url = "<?php echo ROOT_PATH;?>v1/suburbs";
			var formData = new FormData($('form#formID')[0]);
			ajaxPostCallWithSuccessMsg(api_key, url, formData, 'New suburb has been added successfully.','suburbs.php');
		});
			
	});
	
	$(document).ready(function() {
		var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
		
		$("#country_id").change(function(){
			var country_id = $(this).val();
			var url = "<?php echo ROOT_PATH;?>v1/statesofcountry/" + country_id;
			//bind state dropdown
			ajaxGetCallWithAuth(api_key, url, OnSuccessFunctionState);
		});
		
		$("#state_id").change(function(){
			var state_id=$(this).val();
			var url = "<?php echo ROOT_PATH;?>v1/postcodesofstate/" + state_id;
			//bind postcode dropdown
			ajaxGetCallWithAuth(api_key, url, OnSuccessFunctionPostcode);
		});			
	});
	function OnSuccessFunctionState(response){
		$("#state_id").html("");
		var option = $("<option value='0'>Select State</option>");
		$("#state_id").append(option);
		$("#postcode_id").html("");
		var option_post = $("<option value='0'>Select Postcode</option>");
		$("#postcode_id").append(option_post);
		if(response.error == false){
			$.each(response.states , function(key , value){ // First Level
				var options = $("<option value="+value.state_id+">" + value.state_name + "</option>");
				$("#state_id").append(options);    
			});
		}
		
		
	};
	function OnSuccessFunctionPostcode(response){
		$("#postcode_id").html("");
		var option = $("<option value='0'>Select Postcode</option>");
		$("#postcode_id").append(option);
		if(response.error == false){
			$.each(response.postcodes , function(key , value){ // First Level
				var options = $("<option value="+value.postcode_id+">" + value.postcode_name + "</option>");
				$("#postcode_id").append(options);    
			});
		}
		
	};
</script>