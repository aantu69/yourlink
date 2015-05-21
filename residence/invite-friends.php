<?php
include_once 'header.php';
$res_user_id = $_SESSION['UserId'];
$url = ROOT_PATH."v1/getAssignedIndividualsForRes/".$res_user_id;
$response = curl_get_call_with_auth($url, $api_key);
$response = json_decode($response,true);
?>
<section id="main-content">
    <div class="container">
        <div class="jumbotron">
            <h2>Invite or Disconnect Residents & Family</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>            
        </div>
        <form class="form-horizontal user-access" role="form" id="formID">
        	<div class="row link-count-buttons text-center">           
            	<div class="col-sm-12 col-md-12 col-lg-10" style="position: relative;">
	            <?php
	            for($i=1; $i<4;$i++){?>
	            	<div id="entry<?php echo $i;?>" class="clonedInput">
						<div class="form-group">
			                <label for="email-<?php echo $i;?>" class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label">Invite:</label>
			                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
			                    <input type="text" id="email-<?php echo $i;?>" placeholder="Enter email address here" class="form-control validate[required] text-input email" name="emails[]">
			                </div>
			            </div>
			        </div>
				<?php	
				}
				?>	
					<div class="form-group">
						<div class="col-sm-8 col-md-12" style="text-align: left;">
							<h3>Current Residents & Family</h3>
							<div class="add-row-inrow">
								<input type="button" id="btnAdd" name="btnAdd" class="btn"/>
			          	        <input type="button" id="btnDel" name="btnDel" class="btn"/>
							</div>
						</div>
						
					</div>
				<?php
				if(count($response['individuals'])>0){?>
					<div class="form-group">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="content-round-container padd-30">
								<div class="row bdc-lists">
						<?php	for($i=0; $i<count($response['individuals']); $i++){
									$individual_id = $response['individuals'][$i]['user_id'];
									$name = $response['individuals'][$i]['name'];
									$avatar = $response['individuals'][$i]['image_url'];
								?>
									<div class="col-sm-6 col-md-6 col-lg-4 disconnect-<?php echo $individual_id;?>">
										<img class="avatar" src="<?php echo $avatar;?>" alt="<?php echo $name;?>">
					                    <a href="#" class="organisation-name"><?php echo $name;?></a><br/>
					                    <span class="received-date">
					                    	<input type="button" id="disconnect-<?php echo $individual_id;?>" name="submit" value="Disconnect" class="btn btn-primary btn-login btn-disconnect" data="<?php echo $individual_id;?>"/>
					                    </span>
									</div><?php
								}?>

								</div>
							</div>
						</div>
					</div><?php
				}?>	
					<div class="form-group">
						<div class="col-sm-5 col-md-5">
							<div style='width:125px;float:left'><input type="button" id="cancel" name="cancel" value="Cancel" class="btn btn-primary btn-login"/></div>
							<div style='width:125px;float:left'><input type="button" id="submit" name="submit" value="Proceed" class="btn btn-primary btn-success"/></div>				
							<div id='message' style='float:left;padding-top: 5px;'><span></span></div> 
						</div>
						
					</div>            
				</div>
					        
        	</div>
        </form>
    </div>
</section>
<?php include_once 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#submit").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var url = '<?php echo ROOT_PATH;?>v1/fnfForResidence';
			var res_user_id = '<?php echo $_SESSION['UserId']; ?>';
			var email = $('.email').length;
			var emails = "";
			for(var i=1; i<= email; i++){
				if($("#email-"+i).val()!=""){
					emails += $("#email-"+i).val()+",";
				}
			}
			var data = "res_user_id="+res_user_id+"&frnd_user_emails="+emails; 
			//alert(emails);
			ajaxPostCallAuth(api_key, url, data, OnSuccessFunction);
		});
		
		$(".btn-disconnect").click(function(){
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var url = '<?php echo ROOT_PATH;?>v1/disconnectFnfForResidence';
			var residence_id = '<?php echo $_SESSION['UserId']; ?>';			
			var individual_id = $(this).attr('data');
			var data = "residence_id="+residence_id+"&individual_id="+individual_id;
			//ajaxPostCallAuth(api_key, url, data, OnSuccessFunctionDisconnect(individual_id));
			alert($(this).length);
		});
		
		function OnSuccessFunction(response){
			alert(response.message);
			//$('#loader').css('background', 'none');
		};
		function OnSuccessFunctionDisconnect(individual_id) {
	        return function(response) { // Your old function
	            if(response.message == 'FNF has been disconnected.'){
					$('.disconnect-' + individual_id).slideUp('slow', function () {
						$('.disconnect-' + individual_id).addClass('hiden');					
					});
						
				}else{
					alert(response.message);
				}
	        }        
	    }

	});
</script>