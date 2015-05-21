<?php
include_once 'header.php';
?>
<section id="main-content">
    <div class="container">
        <div class="jumbotron text-center">
            <h2>Invite Residents & Family</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>            
        </div>
        <div class="entry-content">
            <p> 
	            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget arcu congue, 
	            molestie nisi facilisis, viverra augue. Pellentesque ac dui iaculis, 
	            aliquam lacus vitae, placerat lectus. 
            </p>           
        </div>
        <form class="form-horizontal user-access" role="form" id="formID">
        	<div class="row link-count-buttons text-center">           
            	<div class="col-sm-10 col-md-10" style="position: relative;">
	            <?php
	            for($i=1; $i<6;$i++){?>
	            	<div id="entry<?php echo $i;?>" class="clonedInput">
						<div class="form-group">
			                <label for="email-<?php echo $i;?>" class="col-sm-2 col-md-2 control-label">Invite:</label>
			                <div class="col-sm-10 col-md-10">
			                    <input type="text" id="email-<?php echo $i;?>" placeholder="Enter email address here" class="form-control validate[required] text-input email" name="emails[]">
			                </div>
			            </div>
			        </div>
				<?php	
				}
				?>	
					<div class="form-group">
						<div class="col-lg-5 col-lg-offset-2">
							<div style='width:125px;float:left'><input type="button" id="submit" name="submit" value="Submit" class="btn btn-primary"/></div>				
							<div id='message' style='float:left;padding-top: 5px;'><span></span></div> 
						</div>
					</div>            
				</div>
				<div class="col-sm-1 col-md-1" style="position: relative;vertical-align: bottom; height: 100%;">
					<div><input type="button" id="btnAdd" name="btnAdd" class="btn"/></div>
		          	<div><input type="button" id="btnDel" name="btnDel" class="btn"/></div>
				</div>	        
        	</div>
        </form>
    </div>
</section>
<?php include_once 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){
		
		$("#submit").click(function(){
			//alert('hello');
			var email = $('.email').length;
			var emails = "";
			for(var i=1; i<= email; i++){
				if($("#email-"+i).val()!=""){
					emails += $("#email-"+i).val()+",";
				}
			}
			//var data = "res_user_id="+res_user_id+"&frnd_user_emails="+emails; 
			alert(emails);
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		alert('emails'); 
		$("#submit").click(function() {
			//var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			//var url = '<?php echo ROOT_PATH;?>v1/fnfForResidence';
			//var res_user_id = '<?php echo $_SESSION['UserId']; ?>';
			//var email = $('.email').length;
//           	var emails = "";
//			for(var i=1; i<= email; i++){
//				if($("#email-"+i).val()!=""){
//					emails += $("#email-"+i).val()+",";
//				}
//			}
			//var data = "res_user_id="+res_user_id+"&frnd_user_emails="+emails; 
			//alert(emails); 
			//ajaxPostCallAuth(api_key, url, data, OnSuccessFunction);
        });       
    });

//	function OnSuccessFunction(response){
//		alert(response.message);
//		$('#loader').css('background', 'none');
//	};	
</script> 