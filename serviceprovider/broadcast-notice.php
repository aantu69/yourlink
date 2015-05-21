<?php
include_once 'header.php';
$sender_id = $_SESSION['UserId'];
$tzOffset = $_SESSION['tzOffset'];
$url = ROOT_PATH.'v1/getSentBroadcast/' . $sender_id;
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
?>
<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h3>Compose Broadcast notice or event</h3>
        </div>
        <!--<form class="user-access form-horizontal" role="form">-->
        <form name="chapter-form" enctype="multipart/form-data" class="chapter-form form-horizontal" action="" method="post" id="formID">
        	<input type="hidden" name="offset" id="offset" value="<?php echo $_SESSION['tzOffset']; ?>"/>
			<input type="hidden" name="sender_role" id="sender_role" value="<?php echo $_SESSION['UserRole']; ?>"/>
			<input type="hidden" name="receiver_role" id="receiver_role" value="13"/>
			<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['UserId']; ?>"/>
			<input type="hidden" name="status" id="status" value=""/>
            <div class="form-group">          
                <div class="col-sm-6 col-md-3 col-lg-2">
                	<div class="form-group">
                		<input id="event" class="event" name="event" type="radio" value="1" checked="">
						<label class="radio"  for="event"> Broadcast Event </label>			  	
					</div> 
                </div>
                <div class="col-sm-6 col-md-2 col-lg-2">
                	<div class="form-group">
                		<input id="notice" class="event" name="event" type="radio" value="0">
						<label class="radio"  for="notice"> Notice </label>				 	
					</div> 
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group start_date">
                        <label for="start_date" class="col-sm-4 col-md-6 control-label">Start Date </label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" class="form-control" id="start_date" name="start_date" readonly="true" style="cursor: default;">
                        </div>
                    </div> 
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group start_time">
                        <label for="start_time" class="col-sm-4 col-md-5 control-label">Start Time </label>
                        <div class="col-sm-8 col-md-7">
                            <select name="start_time" id="start_time" style="margin-right:20px; display: inline;" class="validate[required] text-input">
                            <?php
							for($i=0; $i<24; $i++){
								$hour = $i<10 ? "0".$i : $i;?>
								<option value="<?php echo $hour.':00';?>"><?php echo $hour.':00';?></option>
								<option value="<?php echo $hour.':15';?>"><?php echo $hour.':15';?></option>
								<option value="<?php echo $hour.':30';?>"><?php echo $hour.':30';?></option>
								<option value="<?php echo $hour.':45';?>"><?php echo $hour.':45';?></option>
								<?php
							}
							?>
                            </select>
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-5 col-lg-4">
                    <div class="form-group message_title">
                        <label for="message_title" class="col-sm-2 col-md-4 control-label">Event Name </label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" class="form-control"  name="message_title" id="message_title" placeholder="">
                        </div>
                    </div> 
                </div>               
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="form-group end_date">
                        <label for="end_date" class="col-sm-4 col-md-6 control-label">End Date </label>
                        <div class="col-sm-8 col-md-6">
                            <input type="text" class="form-control" id="end_date" id="end_date" readonly="true" style="cursor: default;">
                        </div>
                    </div> 
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group end_time">
                        <label for="end_time" class="col-sm-4 col-md-5 control-label">End Time </label>
                        <div class="col-sm-8 col-md-7">
                            <select type="text" name="end_time" id="end_time" style="margin-right:20px; display: inline; cursor:" class="validate[required] text-input">
							<?php
							for($i=0; $i<24; $i++){
								$hour = $i<10 ? "0".$i : $i;?>
								<option value="<?php echo $hour.':00';?>"><?php echo $hour.':00';?></option>
								<option value="<?php echo $hour.':15';?>"><?php echo $hour.':15';?></option>
								<option value="<?php echo $hour.':30';?>"><?php echo $hour.':30';?></option>
								<option value="<?php echo $hour.':45';?>"><?php echo $hour.':45';?></option>
								<?php
							}
							?>			  	  	
						  	</select>
                        </div>
                    </div> 
                </div>                 
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <div class="col-sm-9">                  
                    <textarea name="description" id="description" class="form-control" rows="6" placeholder="Type Message"></textarea>                    
                </div>
                <div class="col-sm-3 btn-listings">                    
                    <input type="button" value="Save Draft" name="draft" id="draft" class="btn btn-warning"/>
					<span class="btn btn-danger fileinput-button">
				        <span>Add Photo</span>
				        <!-- The file input field used as target for the file upload widget -->
				        <input type="file" name="attachment" id="attachment"/>
				    </span>			            						
                
                    <input type="button" value="Cancel" name="cancel" id="cancel" class="btn btn-default"/>
                    <input type="button" value="Send" name="broadcast" id="broadcast" class="btn btn-success"/>                 
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="panel panel-info">
				<div class="panel-body"">
					<div id="message-conatiner" class="content light">
					<?php 
					if($response['error'] != 1)
					{
						$count = count($response['messages']);
						if($count>0){?>
						<ul class="short-messages">
							<?php 
							for($i=$count-1; $i>=0; $i--){
								$sent_time = $response['messages'][$i]['send_time']- $tzOffset*60;
								$sent_time = date("d-M-Y H:i:s", $sent_time);
								//$sent_time = date("Y-m-d H:i:s", $timestamp);
								$event = 'Event';
								$title = $response['messages'][$i]['message_title'];
								if($response['messages'][$i]['event'] == 0){
									$event = 'Notice';
									$title = '';
								}?>
								<li class="sms sms-me">
									<h4 class="sms-by"><?php echo $event;?></h4>
									<span class="sms-text"><?php echo $title;?></span>
									<p class="sms-text"><?php echo $response['messages'][$i]['description'];?></p>
									<span class="sms-date"><?php echo $sent_time;?></span>
								</li>
							<?php	
							}?>
						</ul><?php	
						}
					}
					?>
					</div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php include_once 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#start_date,#end_date").datepicker({
		    changeMonth:true,
		    changeYear:true,
		    dateFormat:"d-M-yy"
		}).datepicker("setDate", "0");
		
		$('.event').change(function() {
	        if ($(this).val() == 0) {
	        	$('.start_date').addClass('hiden');	
	        	$('.start_time').addClass('hiden');
	        	$('.end_date').addClass('hiden');
	        	$('.end_time').addClass('hiden'); 
	        	$('.message_title').addClass('hiden');           
	        } else {
	            $('.start_date').removeClass('hiden');	
	        	$('.start_time').removeClass('hiden');
	        	$('.end_date').removeClass('hiden');
	        	$('.end_time').removeClass('hiden'); 
	        	$('.message_title').removeClass('hiden'); 
	        }
        });
		
		var api_key = '<?php echo $_SESSION["ApiKey"]; ?>';
		var url = "<?php echo ROOT_PATH;?>v1/sendMessage";
		$("#broadcast").click(function(){
			//$('#loader').show();
			$("#status").val("Sent");			
			var formData = new FormData($('form#formID')[0]);
			ajaxPostCallWithFileAuth(api_key, url, formData, OnSuccessFunctionLoadMsg);
			//$('#loader').hide();
		});		
		$("#draft").click(function(){
			$("#status").val("Draft");			
			var formData = new FormData($('form#formID')[0]);
			ajaxPostCallWithFileAuth(api_key, url, formData, OnSuccessFunctionLoadMsg);
		});

	});
	
	function loadPreviouseMessage(){
		var sender_id = '<?php echo $_SESSION['UserId']; ?>';
		var api_key   = '<?php echo $_SESSION['ApiKey']; ?>';
		var url = "<?php echo ROOT_PATH;?>v1/getSentBroadcast/" + sender_id;
		ajaxGetCallWithAuth(api_key, url, OnSuccessFunctionLoadMsg);
		//alert(url);
	};
	function OnSuccessFunctionLoadMsg(response){
		$(".short-messages").html("");
		var count = response.messages.length;
		if(count > 0){
			for(var i = count-1; i >= 0; i--){
				var event = 'Notice';
				if(response.messages[i]['event'] == 1){
					event = 'Event';
				}
				//alert(i);
				var tzOffset = '<?php echo $_SESSION['tzOffset']; ?>';
				var timestamp = response.messages[i]['send_time'] - tzOffset*60;
				var date_time = timeConverter(timestamp).split(' ');
				var options = $("<li class='sms sms-me'>"+
					"<h4 class='sms-by'>"+event+"</h4>"+
					"<p class='sms-text'>"+response.messages[i]['description']+"</p>"+
					"<span class='sms-date'>"+date_time[0]+" - "+date_time[1]+"</span>");
				$(".short-messages").append(options); 
			}
		}
		
	};
</script>