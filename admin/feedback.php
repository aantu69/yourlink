<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
$tzOffset = $_SESSION['tzOffset'];
$res_user_id = $_SESSION['UserId'];
$url = ROOT_PATH.'v1/getFeedbacks';
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
?>

 <section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Feedback</h1>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="content-round-container padd-30">                  
                <?php
				if($response['error'] != 1)
				{
					if(count($response['feedbacks'])>0)
					{
						for($i=0; $i<count($response['feedbacks']); $i++) {
							$sent_time = $response['feedbacks'][$i]['sent_time']- $tzOffset*60;
							$sent_time = date("d-M-Y H:i:s", $sent_time);
							$avatar = $response['feedbacks'][$i]['image_url'];
							$orgName = $response['feedbacks'][$i]['first_name']." ".$response['feedbacks'][$i]['last_name'];
							$description = $response['feedbacks'][$i]['description'];
							$feedback_category_name = $response['feedbacks'][$i]['feedback_category_name'];
							$email = $response['feedbacks'][$i]['email'];?>
							<div class="row bdc-lists">
		                        <div class="col-xs-12 col-sm-4">
		                            <img class="avatar" src="<?php echo $avatar;?>" alt="<?php echo $orgName;?>">
		                            <a href="#" class="organisation-name"><?php echo $orgName;?></a><br/>
		                            <span class="received-date"><?php echo $email;?></span><br/>
		                            <span class="received-date"><?php echo $sent_time;?></span>
		                        </div>
		                        <div class="col-xs-12 col-sm-3">
		                            <div class="event-desc">
		                                <p><?php echo $feedback_category_name;?></p>
		                            </div>
		                        </div>
		                        <div class="col-xs-12 col-sm-5 events event-collapse">
		                            <h2 class="event-title"><span class="badge pull-right"><i class="fa fa-angle-up"></i></span></h2>
		                            <div class="event-desc">
		                                <p><?php echo $description;?></p>
		                            </div>
		                        </div>
		                       <div class="lists-border"></div>
		                    </div><?php 
                   		}
                   }
                }?>
                    
                    <!--<div class="row bdc-lists">
                        <div class="col-xs-12 col-sm-4">
                            <a href="#" class="avatar"><img src="../images/avatar.png" alt="user name"></a>
                            <a href="#" class="organisation-name">Organisation name</a>
                            <span class="received-date">20 Sep 2014 - 3.00pm</span>
                        </div>
                        <div class="col-xs-12 col-sm-8 events event-collapse">
                            <h2 class="event-title"> <a href="#">Event Name</a> <span class="badge pull-right"><i class="fa fa-angle-up"></i></span></h2>
                            <div class="event-desc">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis augue quis risus iaculis, at gravida dui imperdiet. Aenean semper sapien a elementum commodo. Sed euismod in massa eget rutrum. Curabitur placerat arcu in enim ullamcorper volutpat. Donec ex ante, vehicula a fringilla eu, placerat sed massa. Vivamus efficitur odio sed quam scelerisque, eu feugiat quam convallis. Vivamus ut eleifend turpis, eget varius lectus. Proin pharetra a lectus sed interdum. Aenean pharetra nunc porttitor ipsum fringilla, vel ultrices nisi efficitur.</p>

                                <p>Phasellus tincidunt porttitor mauris sit amet porttitor. Pellentesque et finibus nisl. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi quis iaculis felis, nec efficitur neque. Aliquam mattis lectus in imperdiet maximus. Proin et urna et magna sodales fermentum. Vestibulum et porttitor augue. Nulla quis lacinia libero. Nam dapibus tempus metus, et aliquet diam tempor id. Etiam pharetra lorem a lacus varius consectetur. Phasellus ac neque eu lacus venenatis imperdiet. Duis tempor leo in lorem varius varius. Vivamus rutrum cursus est, in consectetur velit egestas in. Suspendisse massa felis, varius sed egestas eu, mollis vel tellus. Quisque at pharetra eros. Sed dignissim a lacus sed lacinia.</p>

                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et aliquam odio. Suspendisse ut porta nulla. Pellentesque in augue lorem. Nullam mattis lacus ac mauris vulputate tempor. Aliquam fermentum luctus justo, eu ultricies nunc sodales sed. Vestibulum sagittis risus sit amet est porta, eget tincidunt nunc varius. Aliquam et arcu vel diam sodales malesuada in ac enim. Morbi porta eros ac nisi eleifend tempus. </p>
                            </div>
                        </div>
                        <div class="lists-border"></div>
                    </div>-->
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#main-content--> 

<?php

include_once 'footer.php';
