<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';

$sp_user_id = $_SESSION['UserId'];
$url = ROOT_PATH.'v1/getAssignedResidenceForSp/'.$sp_user_id;
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
//echo $response['error'];

?>

<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Residence Messaging</h1>
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
                                    <li class="list-group-item list-msg-item <?php if($i==0) echo 'active'?>" data-target="<?php echo '#msg-'.$i;?>" data-id="<?php echo $i;?>">
                                        <img class="avatar" src="<?php echo $response['sps'][$i]['image_url']; ?>" alt="user name">
                                        <h4 class="list-group-item-heading"><?php echo $response['sps'][$i]['organisation_name']; ?>
                                            <span class="received-date">20 Sep 2014 - 3.00pm</span>
                                            <span class="meta-location">Resident</span>  
                                        </h4>
                                    </li>
                              <?php }?>
                                </ul>
                          <?php }?>
                                <a class="visible-xs list-group-item-toggle" href="javascript:void(0)"><i class="fa fa-angle-double-up fa-2x"></i><i class="fa fa-angle-double-down fa-2x"></i></a>
                      <?php }?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-8 lists-right">
                            <div id="message-conatiner" class="content light">
                                <ul class="short-messages">
                                    <li class="sms sms-others">
                                        <h4 class="sms-by">Residence</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-me">
                                        <h4 class="sms-by">Me</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-others">
                                        <h4 class="sms-by">Residence</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-me">
                                        <h4 class="sms-by">Me</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-others">
                                        <h4 class="sms-by">Residence</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-me">
                                        <h4 class="sms-by">Me</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-others">
                                        <h4 class="sms-by">Residence</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-me">
                                        <h4 class="sms-by">Me</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-others">
                                        <h4 class="sms-by">Residence</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-me">
                                        <h4 class="sms-by">Me</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-others">
                                        <h4 class="sms-by">Residence</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                    <li class="sms sms-me">
                                        <h4 class="sms-by">Me</h4>
                                        <p class="sms-text">Don't use data attributes from multiple plugins on the same element. For example, a button cannot both have a tooltip and toggle a modal. To accomplish this, use a wrapping element.</p>
                                        <span class="sms-date">20 Sep 2014 - 3.00pm</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix"></div>
                            <form class="message-form">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Type your message..."></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-danger">Save Draft</button>
                                    <button class="btn btn-info">Save Draft</button>
                                    <button class="btn btn-default">Save Draft</button>
                                    <button class="btn btn-warning">Save Draft</button>
                                    <button class="btn btn-success" id="load-more-message">Add Messages</button>
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

<?php

include_once 'footer.php';
