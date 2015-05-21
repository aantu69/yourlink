<?php include("header.php");?>
<section id="main-content">
    <div class="container">	
		<?php
		if(isset($_GET["level_one_class_id"])){
			$level_one_class_id = $_GET["level_one_class_id"];
			$url = ROOT_PATH."v1/levelOneClass/".$level_one_class_id;
			//$url_class = ROOT_PATH."v1/levelOneClass/".$level_one_class_id;
			$response = curl_get_call_with_auth($url, $api_key);
			$response = json_decode($response,true);
		?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Category</h3>
			</div>
			<div class="panel-body">
				<form name="chapter-form" class="chapter-form form-horizontal" id="formID">
					<fieldset>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="level_one_class_name">Class Name:</label>
							<div class="col-lg-5">
								<input type="text" value="<?php if(isset($_GET["level_one_class_id"])){ echo $response['classes'][0]["level_one_class_name"];} ?>" placeholder="Class Name" id="level_one_class_name" class="form-control validate[required] text-input" name="level_one_class_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="level_one_class_order">Order:</label>
							<div class="col-lg-5">
								<input type="text" value="<?php if(isset($_GET["level_one_class_id"])){ echo $response['classes'][0]["level_one_class_order"];} ?>" placeholder="Order" id="level_one_class_order" class="form-control validate[required] text-input" name="level_one_class_order">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="level_one_class_contain_level_two">Contain 2nd Level:</label>
							<div class="col-lg-5 checkbox-col">
								<input type="checkbox" <?php if(isset($_GET["level_one_class_id"])){ if($response['classes'][0]["level_one_class_contain_level_two"] == 'true'){echo 'checked';}} ?> id="level_one_class_contain_level_two" class="custom-checkbox show-checkbox" name="level_one_class_contain_level_two">
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
			header('Location: category.php');
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
			pageRedirect("class.php");
		});
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var level_one_class_id = getQueryStringValue('level_one_class_id');
			var url = "<?php echo ROOT_PATH;?>v1/levelOneClass/"+level_one_class_id;
			var formData = new FormData($('form#formID')[0]);
			//alert(salutation_id);
			ajaxPostCallWithSuccessMsg(api_key, url, formData, 'Class has been updated successfully.','class.php');	
		});
			
	});
</script>