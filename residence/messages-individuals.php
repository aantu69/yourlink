<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
$tzOffset = $_SESSION['tzOffset'];
$res_user_id = $_SESSION['UserId'];
$url = ROOT_PATH.'v1/getAssignedIndividualsForRes/'.$res_user_id;
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);

$sender_id = $_SESSION['UserId'];
$receiver_id = $response['individuals'][0]['user_id'];
$page = 0;
$url_ind_msg = ROOT_PATH.'v1/getIndividualMessage/'.$sender_id.'/'.$receiver_id.'/'.$page;
$response_ind_msg = curl_get_call_with_auth($url_ind_msg,$api_key);
$response_ind_msg = json_decode($response_ind_msg,true);

?>

<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Message to Individuals</h1>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div id="messages-wrap" class="content-round-container">
                    <div class="row message-lists">
                        <div class="col-xs-12 col-sm-5 col-md-4 lists-left">
                            <div id="messager-conatiner">
                            <?php
							if($response['error'] != 1)
							{
								if(count($response['individuals'])>0)
								{?>
									
                                <ul class="list-group">
                                    <?php for($i=0; $i<count($response['individuals']); $i++) {?>
                                    <li class="list-group-item list-msg-item <?php if($i==0) echo 'active'?>" data-name="<?php echo $response['individuals'][$i]['name'];?>" data-id="<?php echo $response['individuals'][$i]['user_id'];?>">
                                        <img class="avatar" src="<?php echo $response['individuals'][$i]['image_url']; ?>" alt="user name">
                                        <h4 class="list-group-item-heading"><?php echo $response['individuals'][$i]['name']; ?>
                                            <span class="received-date">&nbsp;</span>
                                            <span class="meta-location">Individual</span>  
                                        </h4>
                                    </li>
                              <?php }?>
                                </ul>
                          <?php }?>
                                <a class="visible-xs list-group-item-toggle" href="javascript:void(0)">
	                                <i class="fa fa-angle-double-up fa-2x"></i>
	                                <i class="fa fa-angle-double-down fa-2x"></i>
                                </a>
                      <?php }?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-8 lists-right">
                            <div id="message-conatiner" class="content light">
                            <?php
                            if($response_ind_msg['error'] != 1)
							{
								$count = count($response_ind_msg['messages']);
								if($count>0){?>
                                <ul class="short-messages">
                                	<?php
	                                for($i=$count-1; $i>=0; $i--){
	                                	$sent_time = $response_ind_msg['messages'][$i]['send_time']- $tzOffset*60;
										$sent_time = date("d-M-Y H:i:s", $sent_time);
	                                	$sms_by = $response['individuals'][0]['name'];
	                                	$sms_cls = 'sms-me';
	                                	if($response_ind_msg['messages'][$i]['sender_id'] == $sender_id){
	                                		$sms_by = 'Me';
	                                		$sms_cls = 'sms-others';
	                                	}?>
	                                    <li class="sms <?php echo $sms_cls;?>">
	                                        <h4 class="sms-by"><?php echo $sms_by;?></h4>
	                                        <p class="sms-text"><?php echo $response_ind_msg['messages'][$i]['description'];?></p>
	                                        <span class="sms-date"><?php echo $sent_time;?></span>
	                                    </li>
                          	  <?php }?>   
                                    
                                </ul>
                          <?php }
                            }?> 
                            </div>
                            <div class="clearfix"></div>
                            <form name="chapter-form" enctype="multipart/form-data" class="message-form form-horizontal" action="" method="post" id="formID">
                            	<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['UserId']; ?>"/>
								<input type="hidden" name="sender_role" id="sender_role" value="<?php echo $_SESSION['UserRole']; ?>"/>
								<input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $response['individuals'][0]['user_id']; ?>"/>
								<input type="hidden" name="sp_name" id="sp_name" value="<?php echo $response['individuals'][0]['name']; ?>"/>
								<input type="hidden" name="message_title" id="message_title" value="Message From Residence"/>
								<input type="hidden" name="status" id="status" value=""/>
                                <div class="form-group">
                                    <textarea name="description" id="description" class="form-control" placeholder="Type your message..."></textarea>
                                </div>
                                <div class="form-group btn-listings">
                                    <input type="button" value="Save Draft" name="draft" id="draft" class="btn btn-danger"/>
                                	<span class="btn btn-success fileinput-button">
								        <span>Add Photo</span>
								        <!-- The file input field used as target for the file upload widget -->
								        <input type="file" name="attachment" id="attachment"/>
								    </span>
                                	<input type="button" value="Cancel" name="cancel" id="cancel" class="btn btn-primary red"/>
									<input type="button" value="Send" name="broadcast" id="broadcast" class="btn btn-primary green"/>
                                </div>
                            </form>
                        </div>                                   
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#main-content--> 

<?php include_once 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){		
		$('.list-msg-item', '#messager-conatiner').click(function () {	
			var sender_id = '<?php echo $_SESSION['UserId']; ?>';		
            var receiver_id = $(this).attr('data-id');
            $("#receiver_id").val(receiver_id);          
            var sp_name = $(this).attr('data-name');
            $("#sp_name").val(sp_name);          
            getMessage(sender_id, receiver_id);
        });
        
        var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
		var url = "<?php echo ROOT_PATH;?>v1/sendIndividualMessage";
		$("#broadcast").click(function(){
			$("#status").val("Sent");	
			var sender_id = '<?php echo $_SESSION['UserId']; ?>';
			var receiver_id = $("#receiver_id").val();		
			var formData = new FormData($('form#formID')[0]);
			//alert(formData)
			ajaxPostCallWithFileAuth(api_key, url, formData, OnSuccessFunctionLoadMsg);
			//getMessage(sender_id, receiver_id);
		});		
		$("#draft").click(function(){
			$("#status").val("Draft");
			var sender_id = '<?php echo $_SESSION['UserId']; ?>';
			var receiver_id = $("#receiver_id").val();			
			var formData = new FormData($('form#formID')[0]);
			//alert(formData)
			ajaxPostCallWithFileAuth(api_key, url, formData, OnSuccessFunctionLoadMsg);
			//getMessage(sender_id, receiver_id);
		});
		
	});
	
	function getMessage(sender_id, receiver_id){
		var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
		var page = 0;
		var get_url = '<?php echo ROOT_PATH;?>v1/getIndividualMessage/'+sender_id+'/'+receiver_id+'/'+page;
        ajaxGetCallWithAuth(api_key, get_url, OnSuccessFunctionLoadMsg);
        //alert(get_url);
	};
	
	function OnSuccessFunctionLoadMsg(response){
		var msgContainer = $('#message-conatiner');
    	//msgContainer.html('');
        	        			
		if(response.error == false){
			var sender_id = '<?php echo $_SESSION['UserId']; ?>';
			var msgData = '';
			var count = response.messages.length;
			if(count>0){
				for(var i = count-1; i >= 0; i--){
					var tzOffset = '<?php echo $_SESSION['tzOffset']; ?>';
					var timestamp = response.messages[i]['send_time'] - tzOffset*60;
					var date_time = timeConverter(timestamp).split(' ');
					
					
					var sms_by = $("#sp_name").val();
		        	var sms_cls = 'sms-me';
		        	if(response.messages[i]['sender_id'] == sender_id){
		        		sms_by = 'Me';
		        		sms_cls = 'sms-others';
		        	}
		            msgData +='<li class="sms '+sms_cls+'">';
		            msgData +='<h4 class="sms-by">'+sms_by+'</h4>';
		            msgData +='<p class="sms-text">'+response.messages[i]['description']+'</p>';
		            msgData +='<span class="sms-date">'+date_time[0]+"  "+date_time[1]+'</span>';
		            msgData +='</li>';
				}					 
			}
//				$.each(response.messages , function(key , value){ // First Level
//					//var date_time = (value.send_date).split(' ');
//					   
//				});
			msgData +='';
			$('ul',msgContainer).slideUp('slow',function(){
				$(this).html(msgData).slideDown();
			})
			//msgContainer.append(msgData);

			
		}else{
			alert(response.message);
			msgData ='';
			$('ul',msgContainer).slideUp('slow',function(){
				$(this).html(msgData).slideDown();
			})
		}
		
	};
</script>