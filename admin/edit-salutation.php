<?php include("header.php");?>
<section id="main-content">
    <div class="container">	
		<?php
		if(isset($_GET["salutation_id"])){
			$salutation_id = $_GET["salutation_id"];
			$url = ROOT_PATH."v1/salutations/".$salutation_id;
			$url_salutations = ROOT_PATH."v1/salutations/".$salutation_id;
			$response = curl_get_call_with_auth($url,$api_key);
			$response = json_decode($response,true);
		?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Salutation</h3>
			</div>
			<div class="panel-body">
				<form name="chapter-form" class="chapter-form form-horizontal" id="formID">
					<fieldset>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="salutation_name">Salutation Name:</label>
							<div class="col-lg-5">
								<input type="text" value="<?php if(isset($_GET["salutation_id"])){ echo $response['salutations'][0]["salutation_name"];} ?>" placeholder="Salutation Name" id="salutation_name" class="form-control validate[required] text-input" name="salutation_name">
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
		<?php
		}
		else
		{
			header('Location: salutations.php');
		}
		?>
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
			pageRedirect("salutations.php");
		});
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var salutation_id = getQueryStringValue('salutation_id');
			var url = "<?php echo ROOT_PATH;?>v1/salutations/"+salutation_id;
			var formData = new FormData($('form#formID')[0]);
			//alert(salutation_id);
			ajaxPostCallWithSuccessMsg(api_key, url, formData, 'Salutation has been updated successfully.','salutations.php');	
		});
			
	});

</script>