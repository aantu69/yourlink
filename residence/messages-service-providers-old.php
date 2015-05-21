<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
$res_user_id = $_SESSION['UserId'];
$url = ROOT_PATH.'v1/getAssignedSpsForRes/'.$res_user_id;
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);

$sender_id = $_SESSION['UserId'];
$receiver_id = $response['sps'][0]['user_id'];
$url_ind_msg = ROOT_PATH.'v1/getIndividualMessage/'.$sender_id.'/'.$receiver_id;
$response_ind_msg = curl_get_call_with_auth($url_ind_msg,$api_key);
$response_ind_msg = json_decode($response_ind_msg,true);

?>

<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Message to Servise Provider</h1>
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
								if(count($response['sps'])>0)
								{?>
									
                                <ul class="list-group">
                                    <?php for($i=0; $i<count($response['sps']); $i++) {?>
                                    <li class="list-group-item list-msg-item <?php if($i==0) echo 'active'?>" data-target="<?php echo '#msg-'.$i;?>" data-id="<?php echo $response['sps'][$i]['user_id'];?>">
                                        <img class="avatar" src="<?php echo $response['sps'][$i]['image_url']; ?>" alt="user name">
                                        <h4 class="list-group-item-heading"><?php echo $response['sps'][$i]['organisation_name']; ?>
                                            <span class="received-date">20 Sep 2014 - 3.00pm</span>
                                            <span class="meta-location">Service Provider</span>  
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
								if(count($response_ind_msg['messages'])>0){?>
                                <ul class="short-messages">
                                	<?php
	                                for($i=0; $i<count($response_ind_msg['messages']); $i++){
	                                	$sms_by = 'Service Provider';
	                                	$sms_cls = 'sms-me';
	                                	if($response_ind_msg['messages'][$i]['sender_id'] == $sender_id){
	                                		$sms_by = 'Me';
	                                		$sms_cls = 'sms-others';
	                                	}?>
	                                    <li class="sms <?php echo $sms_cls;?>">
	                                        <h4 class="sms-by"><?php echo $sms_by;?></h4>
	                                        <p class="sms-text"><?php echo $response_ind_msg['messages'][$i]['description'];?></p>
	                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
	                                    </li>
                          	  <?php }?>   
                                    
                                </ul>
                          <?php }
                            }?> 
                            </div>
                            <div class="clearfix"></div>
                            <!--<form class="message-form">-->
                            <form name="chapter-form" enctype="multipart/form-data" class="message-form form-horizontal" action="" method="post" id="formID">	
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Type your message..."></textarea>
                                </div>
                                <div class="form-group">
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
            var userResidence = $(this).attr('data-id');
            //showMessage(userResidence);
        });
	});
</script>