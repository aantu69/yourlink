<?php
require_once '../include/Config.php';
include_once 'header.php';
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
                <div class="col-xs-6 col-sm-2">
                	<!--<div>
                		<input type="radio" id="radio01" name="event" value="1"/>
                		<label for="radio01"><span></span>Broadcast Event:</label>
					  					  	
					</div>-->
                	<div class="event">Broadcast Event: <input type="radio" name="event" value="1"/></div>
                    <!--<div class="checkbox">
                        <label>
                            Broadcast Event <input type="checkbox">
                        </label>
                    </div>--> 
                </div>
                <div class="col-xs-6 col-sm-2">
                	<!--<div>
                		<input type="radio" id="radio02" name="event" value="0" checked />
                		<label for="radio02"><span></span>Notice:</label>
					 						 	
					</div>-->
                	<div class="notice">Notice: <input type="radio" name="event" value="0" checked/></div>
                    <!--<div class="checkbox">
                        <label>
                            Notice <input type="checkbox">
                        </label>
                    </div>--> 
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="start_date" class="col-sm-6 control-label text-right">Start Date: </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="start_date" name="start_date" readonly="true" style="cursor: default;">
                        </div>
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="start_time" class="col-sm-6 control-label text-right">Start Time: </label>
                        <div class="col-sm-6">
                            <select name="start_time" id="start_time" style="margin-right:20px; display: inline;" class="form-control validate[required] text-input">
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
                <div class="col-xs-6 col-sm-4">
                    <div class="form-group">
                        <label for="message_title" class="col-sm-4 control-label">Event Name: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"  name="message_title" id="message_title" placeholder="">
                        </div>
                    </div> 
                </div>               
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="end_date" class="col-sm-6 control-label text-right">End Date: </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="end_date" id="end_date" readonly="true" style="cursor: default;">
                        </div>
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="end_time" class="col-sm-6 control-label text-right">End Time: </label>
                        <div class="col-sm-6">
                            <select type="text" name="end_time" id="end_time" style="margin-right:20px; display: inline; cursor:" class="form-control validate[required] text-input">
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
                <div class="col-xs-12 col-sm-10">                  
                    <textarea name="description" id="description" class="form-control" rows="6" placeholder="Type Message"></textarea>                    
                </div>
                <div class="col-xs-12 col-sm-2 btn-listings">                    
                    <!--<input type="submit" class="btn btn-warning" value="Save Draft">                   
                    <input type="submit" class="btn btn-danger" value="Add Photo">                   
                    <input type="submit" class="btn btn-default" value="Cancel">                   
                    <input type="submit" class="btn btn-success" value="Send"> --> 
                    
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
            <!--<div class="form-group">
                <textarea class="form-control" rows="6" placeholder="Details of past notice or event"></textarea>  
            </div>-->
            <div class="panel panel-info">
				<div class="panel-body" style="text-align:center;">
					<div id="msg-info"></div>
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
		loadPreviouseMessage();
	});
	
	function loadPreviouseMessage(){
		var sender_id = '<?php echo $_SESSION['UserId']; ?>';
		var api_key   = '<?php echo $_SESSION['ApiKey']; ?>';
		var url = "<?php echo ROOT_PATH;?>v1/getSentBroadcast/" + sender_id;
		ajaxGetCallWithAuth(api_key, url, OnSuccessFunctionLoadMsg);
		//alert(url);
	};
	function OnSuccessFunctionLoadMsg(response){
		$("#msg-info").html("");
		$.each(response.messages , function(key , value){ // First Level
			//var date_time = (value.send_date).split(' ');
			var tzOffset = '<?php echo $_SESSION['tzOffset']; ?>';
			var timestamp = value.send_time - tzOffset*60;
			var date_time = timeConverter(timestamp).split(' ');
			var options = $("<div class='description-date-time'>"+
				"<div class='description'>"+value.description+"</div>"+
				"<div class='date-time'>"+date_time[0]+"<br/>"+date_time[1]+"</div></div>");
			$("#msg-info").append(options);    
		});
		
	};
</script>
