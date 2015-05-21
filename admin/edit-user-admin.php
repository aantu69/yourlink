<?php include("header.php");?>
<section id="main-content">
    <div class="container">
    <?php
	if(isset($_GET["user_id"])){
		$user_id = $_GET["user_id"];
		$url = ROOT_PATH."v1/getUserInfo/".$user_id;
		$response = curl_get_call_with_auth($url, $api_key);
		$response = json_decode($response,true);
	?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Add User</h3>
			</div>
			<div class="panel-body">
				<form class="chapter-form form-horizontal" id="formID">
					<fieldset>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="first_name">First Name:</label>
							<div class="col-lg-5">
								<input type="text" value="<?php if(isset($_GET["user_id"])){ echo $response['users'][0]["first_name"];} ?>" placeholder="First Name" id="first_name" class="form-control validate[required] text-input" name="first_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="last_name">Last Name:</label>
							<div class="col-lg-5">
								<input type="text" value="<?php if(isset($_GET["user_id"])){ echo $response['users'][0]["last_name"];} ?>" placeholder="Last Name" id="last_name" class="form-control validate[required] text-input" name="last_name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="email">Email:</label>
							<div class="col-lg-5">
								<input type="text" value="<?php if(isset($_GET["user_id"])){ echo $response['users'][0]["email"];} ?>" placeholder="Email" id="email" class="form-control validate[required] text-input" name="email">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="password">Password:</label>
							<div class="col-lg-5">
								<input type="password" id="password" class="form-control validate[required] text-input" name="password">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label" for="confirm_password">Confirm Password:</label>
							<div class="col-lg-5">
								<input type="password" id="confirm_password" class="form-control validate[required] text-input" name="confirm_password">
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
		header('Location: users-admin.php');
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
			pageRedirect("users-admin.php");
		});
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var user_id = getQueryStringValue('user_id');
			var url = "<?php echo ROOT_PATH;?>v1/users/"+user_id;
			var formData = new FormData($('form#formID')[0]);
			//alert(url);
			ajaxPostCallWithSuccessMsg(api_key, url, formData, 'User updated successfully.','users-admin.php');	
		});
			
	});
	
</script>