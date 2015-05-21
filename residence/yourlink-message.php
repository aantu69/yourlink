<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
$tzOffset = $_SESSION['tzOffset'];
$url = ROOT_PATH.'v1/getYourlinkNotice/3';
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
?>

 <section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Notice from Yourlink</h1>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="content-round-container padd-30">                  
                <?php
				if($response['error'] != 1)
				{
					$count = count($response['messages']);
					if($count>0)
					{
						for($i=$count-1; $i>=0; $i--) {
							$sent_time = $response['messages'][$i]['send_time']- $tzOffset*60;
							$sent_time = date("d-M-Y H:i:s", $sent_time);
							$title = $response['messages'][$i]['message_title'];
							$description = $response['messages'][$i]['description'];?>			
							<div class="row bdc-lists">
		                        <div class="col-xs-12 col-sm-4">
		                            <img class="avatar" src="../images/logo.png" alt="YourLink">
		                            <a href="" class="organisation-name">YourLink</a><br/>
		                            <span class="received-date"><?php echo $sent_time;?></span>
		                        </div>
		                        <div class="col-xs-12 col-sm-8 events event-collapse">
		                            <h2 class="event-title"> <a href="#"><?php echo $title;?></a> <span class="badge pull-right"><i class="fa fa-angle-up"></i></span></h2>
		                            <div class="event-desc">
		                                <p><?php echo $description;?></p>
		                            </div>
		                        </div>
		                       <div class="lists-border"></div>
		                    </div><?php 
                   		}
                   }
                }?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#main-content--> 

<?php

include_once 'footer.php';
