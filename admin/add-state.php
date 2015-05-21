<?php include("header.php");?>
<?php
$url = ROOT_PATH.'v1/relationaldata';
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
?>
<section id="main-content">
    <div class="container">	
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Add State</h3>
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
								if(count($response['countries'])>0){
									for($i=0; $i<count($response['countries']); $i++) {?>
										<option value="<?php echo $response['countries'][$i]['country_id']; ?>"><?php echo $response['countries'][$i]['country_name']; ?></option><?php
									}
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="state_name">State Name:</label>
							<div class="col-lg-5">
								<input type="text" placeholder="State Name" id="state_name" class="form-control validate[required] text-input" name="state_name">
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
			pageRedirect("states.php");
		});
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var url = "<?php echo ROOT_PATH;?>v1/states";
			var formData = new FormData($('form#formID')[0]);
			ajaxPostCallWithSuccessMsg(api_key, url, formData, 'New state has been added successfully.','states.php');	
		});
			
	});
</script>