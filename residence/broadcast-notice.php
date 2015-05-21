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
            <h3>Compose Broadcast Notice</h3>
        </div>
        <!--<form class="user-access form-horizontal" role="form">-->
        <form name="chapter-form" enctype="multipart/form-data" class="chapter-form form-horizontal" action="" method="post" id="formID">
        	<input type="hidden" name="event" id="event" value="0"/>
        	<input type="hidden" name="start_date" id="start_date" value="0000-00-00"/>
        	<input type="hidden" name="start_time" id="start_time" value="00:00"/>
        	<input type="hidden" name="end_date" id="end_date" value="0000-00-00"/>
        	<input type="hidden" name="end_time" id="end_time" value="00:00"/>
        	<input type="hidden" name="offset" id="offset" value="<?php echo $_SESSION['tzOffset']; ?>"/>
			<input type="hidden" name="sender_role" id="sender_role" value="<?php echo $_SESSION['UserRole']; ?>"/>
			<input type="hidden" name="receiver_role" id="receiver_role" value="12"/>
			<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['UserId']; ?>"/>
			<input type="hidden" name="status" id="status" value=""/>
            <!--<div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="form-group">
                        <label for="message_title" class="col-sm-2 col-md-2 control-label">Notice Title </label>
                        <div class="col-sm-10 col-md-10">
                            <input type="text" class="form-control"  name="message_title" id="message_title" placeholder="">
                        </div>
                    </div> 
                </div>                                
            </div>-->
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-md-9">                  
                    <textarea name="description" id="description" class="form-control" rows="6" placeholder="Type Message"></textarea>                    
                </div>
                <div class="col-sm-3 col-md-3 btn-listings">                    
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
								if($response['messages'][$i]['event'] == 0){
									$event = 'Notice';
								}?>
								<li class="sms sms-me">
									<h4 class="sms-by"><?php echo $event;?></h4>
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
		    dateFormat:"yy-mm-dd"
		}).datepicker("setDate", "0");
		
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
