<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
?>
<?php
require_once '../include/Config.php';
require_once '../include/function.php';

$user_id = $_SESSION['UserId'];
$postcode = $_SESSION['Postcode'];
$url = ROOT_PATH.'v1/getSpsForRes/'.$user_id.'/'.$postcode;
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
//echo $response['error'];
?>

<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Service Provider Link</h1>
        </div>
        <div class="entry-content">
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget arcu congue, molestie nisi facilisis, viverra augue. Pellentesque ac dui iaculis, aliquam lacus vitae, placerat lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam venenatis enim in efficitur vestibulum. Mauris porttitor enim sapien, sollicitudin placerat nisi posuere sit amet. Suspendisse sit amet ante eget libero hendrerit tempus. Sed porttitor accumsan leo, at auctor justo varius et. Praesent blandit non elit vel vestibulum. Nam cursus, odio eu malesuada commodo, dui est hendrerit tortor, ut vulputate diam ipsum at urna.</p>
            <form class="form-inline form-sarch-inline" action="" role="form">
                <div class="form-group col-sm-8">
                    <input type="text" placeholder="Search here" class="form-control" id="organization_name" name="organization_name" />
                </div>
                <div class="form-group">
                    <input type="button" id="search" name="search" value="Search" class="btn btn-default"/>
                </div>
                <div class="form-group">
                    <input type="button" id="clear" name="clear" value="Clear Search" class="btn btn-danger"/>
                </div>
            </form>
        </div>    
        <div class="row">
            <div class="col-xs-12">
            <form name="chapter-form" class="chapter-form form-horizontal" action="#" method="post" id="formID">
                <div class="content-round-container padd-30">   
                    <div id="service-lists-container">
                    <div id="message-container">
            <?php
			if($response['error'] != 1)
			{
				if(count($response['categories'])>0)
				{
					for($i=0; $i<count($response['categories']); $i++) {
						//if()
						?>
                        <div class="list-group service-lists">
                            <div class="list-group-item cell-hearder">
                                <div class="row">
                                    <div class="col-sm-9 cell-left"><h4 class="service-cat-title"><?php echo $response['categories'][$i]["category_name"]; ?></h4></div>
                                    <div class="col-sm-3 cell-right">&nbsp;</div>
                                </div>
                            </div><?php
                            for($j=0; $j<count($response['categories'][$i]["sps"]); $j++){
								$sp_id = $response['categories'][$i]["sps"][$j]["user_id"];
								$added = $response['categories'][$i]["sps"][$j]["already_added"];
								$send_receive = $response['categories'][$i]["sps"][$j]["send_receive"];
								?>
                                <div class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-9 cell-left">
                                            <a class="cell-avater" href=""> <img class="avatar" src='<?php echo $response['categories'][$i]["sps"][$j]["image_url"]; ?>' alt="user name"></a>
                                            <p class="cell-text"><?php echo $response['categories'][$i]["sps"][$j]["organisation_name"]; ?></p>
                                        </div>
                                        <div class="col-sm-3 cell-right">
                                        	<div>
	                                        	<input type="checkbox" value="<?php echo $sp_id.'_0'; ?>" name="rd-<?php echo $sp_id; ?>" id="rd-<?php echo $sp_id.'_0'; ?>" class="css-checkbox" <?php if($added == '1'){if($send_receive==0){echo 'checked';}} ?>/>
												<label class="checkbox" for="rd-<?php echo $sp_id.'_0'; ?>">Receive Broadcast</label>
											</div>
											<div>
	                                        	<input type="checkbox" value="<?php echo $sp_id.'_1'; ?>" name="rd-<?php echo $sp_id; ?>" id="rd-<?php echo $sp_id.'_1'; ?>" class="css-checkbox" <?php if($added == '1'){if($send_receive==1){echo 'checked';}} ?>/>
												<label class="checkbox" for="rd-<?php echo $sp_id.'_1'; ?>">Message</label>
											</div>
                                            
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        
                    <?php 
                    }
                }
                else{?>
					<div class="well well-lg">No service provider available in your postcode.</div><?php
				}
            }
            else{?>
            	<div class="well well-lg">No service provider available in your postcode.</div><?php
            } ?>
                    </div>
                    <div class="form-group res-btn">
	                    <div class="col-sm-10 col-md-10">
							<div style='width:125px;float:left'><input type="button" id="cancel" name="cancel" value="Cancel" class="btn btn-primary btn-login"/></div>
							<div style='width:125px;float:left'><input type="button" id="submit" name="submit" value="Proceed" class="btn btn-primary btn-success"/></div>				
							<div id='message' style='float:left;padding-top: 5px;'><span></span></div> 
						</div>
	                </div>
                </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</section><!--/#main-content--> 

<?php include_once 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function() {
		RestrictCheckboxChecked();
        
		$("#submit").click(function() {
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var url = '<?php echo ROOT_PATH;?>v1/addSpsForResidence';
			var res_user_id = '<?php echo $_SESSION['UserId']; ?>';			
			var sp_ids = '';
            $("#formID input[type='checkbox']:checked").each(function () {
                sp_ids += $(this).val() + ",";
            });
            var data = "res_user_id="+res_user_id+"&sp_ids="+sp_ids; 
            ajaxPostCallAuth(api_key, url, data, OnSuccessFunction);
            //alert(data);
        });
        
        $("#search").click(function() {
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var user_id = '<?php echo $_SESSION['UserId']; ?>';
			var query_organization_name = $('#organization_name').val();			
			var get_url = '<?php echo ROOT_PATH;?>v1/searchSpsForRes/'+user_id+'/'+query_organization_name; 
			ajaxGetCallWithAuth(api_key, get_url, OnSuccessFunctionLoadMsg);
            //ajaxPostCallAuth(api_key, url, data, OnSuccessFunctionLoadMsg);
            //alert(api_key);
        }); 
        
        $("#clear").click(function(){
			$('#organization_name').val('');
			
			var api_key = '<?php echo $_SESSION['ApiKey']; ?>';
			var user_id = '<?php echo $_SESSION['UserId']; ?>';
			var postcode = '<?php echo $_SESSION['Postcode']; ?>';		
			var get_url = '<?php echo ROOT_PATH;?>v1/getSpsForRes/'+user_id+'/'+postcode; 
			ajaxGetCallWithAuth(api_key, get_url, OnSuccessFunctionLoadMsg);
		});      
    });

	function OnSuccessFunction(response){
		alert(response.message);
	};
	
	function RestrictCheckboxChecked(){
		$("input:checkbox").click(function() {
		    if ($(this).is(":checked")) {
		        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
		        $(group).prop("checked", false);
		        $(this).prop("checked", true);
		    } else {
		        $(this).prop("checked", false);
		    }
		});
	}	
	
	function OnSuccessFunctionLoadMsg(response){
		var msgContainer = $('#service-lists-container');
    	//msgContainer.html('');
        //alert(response.error);	        			
		if(response.error == false){
			var msgData = '';
			var count = response.categories.length;
			if(count>0){
				for(var i = 0; i < count; i++){					
					msgData +='<div class="list-group service-lists">';
                    msgData +='<div class="list-group-item cell-hearder">';
                    msgData +='<div class="row">'
                    msgData +='<div class="col-sm-9 cell-left">';
                    msgData +='<h4 class="service-cat-title">'+response.categories[i]['category_name']+'</h4></div>';
                    msgData +='<div class="col-sm-3 cell-right">&nbsp;</div>';
                    msgData +='</div>';
                    msgData +='</div>';
                    
                    //alert(response.categories[i]['sps'].length);
                    
                    for(var j=0; j<response.categories[i]['sps'].length; j++){
                    	var sp_id = response.categories[i]["sps"][j]["user_id"];
						var added = response.categories[i]["sps"][j]["already_added"];
						var send_receive = response.categories[i]["sps"][j]["send_receive"];
						var send_and_receive = '';
						var only_receive = '';
						if(added == '1'){
							if(send_receive == '1'){
								send_and_receive = 'checked';
							}else if(send_receive == '0'){
								only_receive = 'checked';
							}
			        	}
						
						msgData +='<div class="list-group-item">';
                        msgData +='<div class="row">';
                        msgData +='<div class="col-sm-9 cell-left">';
                        msgData +='<a class="cell-avater" href=""> <img class="avatar" src="'+response.categories[i]["sps"][j]["image_url"]+'" alt="user name"></a>';
                        msgData +='<p class="cell-text">'+response.categories[i]["sps"][j]["organisation_name"]+'</p>';
                        msgData +='</div>';
                        msgData +='<div class="col-sm-3 cell-right">';
                        msgData +='<div>';
	                    msgData +='<input type="checkbox" value="'+sp_id+'_0" name="rd-'+sp_id+'" id="rd-'+sp_id+'_0" class="css-checkbox" '+only_receive+'/>';
						msgData +='<label class="checkbox" for="rd-'+sp_id+'_0">Receive Broadcast</label>';
						msgData +='</div>';
						msgData +='<div>';
	                    msgData +='<input type="checkbox" value="'+sp_id+'_1" name="rd-'+sp_id+'" id="rd-'+sp_id+'_1" class="css-checkbox" '+send_and_receive+'/>';
						msgData +='<label class="checkbox" for="rd-'+sp_id+'_1">Message</label>';
						msgData +='</div>';                                        
                        msgData +='</div>';
                        msgData +='</div>';
                        msgData +='</div>';
					}
					msgData +='</div>';
				}					 
			}

			msgData +='';
			$('#message-container',msgContainer).slideUp('slow',function(){
				$(this).html(msgData).slideDown();
				RestrictCheckboxChecked();
			})
			//msgContainer.append(msgData);

			
		}else{
			alert(response.message);
			msgData ='';
			$('#message-container',msgContainer).slideUp('slow',function(){
				$(this).html(msgData).slideDown();
			})
		}
		
		
		
	};
</script> 