<?php
require_once '../include/Config.php';
include_once 'header.php';
?>
<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h3>Compose Notice</h3>
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
			<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['UserId']; ?>"/>
			<input type="hidden" name="status" id="status" value=""/>
          
            <div class="form-group">
                <!--<div class="col-sm-7 col-md-5">
                    <div class="form-group">
                        <label for="message_title" class="col-sm-4 col-md-4 control-label">Notice Title: </label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" class="form-control"  name="message_title" id="message_title" placeholder="">
                        </div>
                    </div> 
                </div> -->              

                <div class="col-sm-5 col-md-4">
                    <div class="form-group">
                        <label for="receiver_role" class="col-sm-4 col-md-4 control-label text-right">Send To: </label>
                        <div class="col-sm-8 col-md-8">
                            <select type="text" name="receiver_role" id="receiver_role" style="margin-right:20px; display: inline; cursor:" class="validate[required] text-input">
                            	<option value="123">All</option>
								<option value="1">Individual</option>
								<option value="2">Service Provider</option>
								<option value="3">Residence</option>			  	  	
						  	</select>
                        </div>
                    </div> 
                </div>                 
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-md-9">                  
                    <textarea name="description" id="description" class="form-control" rows="6" placeholder="Type Message"></textarea>                    
                </div>
                <div class="col-sm-3 col-md-3 btn-listings">                    
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
//		$("#start_date,#end_date").datepicker({
//		    changeMonth:true,
//		    changeYear:true,
//		    dateFormat:"yy-mm-dd"
//		}).datepicker("setDate", "0");
		
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
