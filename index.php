<?php 
	ob_start();
	@session_start();
	if(isset($_SESSION['UserName'])) 
	{
		$api_key = $_SESSION['ApiKey'];
		$user_id = $_SESSION['UserId'];
		$user_name = $_SESSION['UserName'];
		header('Location: admin/index.php');
	}
	else
	{
		header('Location: login.php');
	}
?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
//echo strpos('broadcasts', $_SERVER['SCRIPT_NAME']);
?>

<section id="main-content">
                <div class="container">
                    <div class="row logo-center">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3 text-center">
                            <img class="logo-lg-center" src="images/logo.png" alt="Logo: Your Link"/>
                        </div>
                    </div>
                    <div class="row row-tagline text-center">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <h2 class="tagline-text">A Social and Community</h2>
                            <h2 class="tagline-text">Hub For Senior</h2>
                        </div> 
                    </div>
                    <div class="row row-subscribe">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label class="col-sm-12  text-center">Coming soon, in the meantime subscribe to stay up to date</label>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-8 col-sm-8 col-sm-offset-1">
                                        <input class="form-control" type="email" name="sub-email" placeholder="Enter Email Here..."/>
                                    </div>
                                    <div class="col-xs-4 col-sm-3">
                                        <input type="submit" class="btn btn-success" value="Submit" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.row-subscribe -->
                    <div class="row row-social-links hidden">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                            <div class="btn-group btn-group-justified">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Left</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Middle</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Right</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--/#main-content--> 

<?php

include_once 'footer.php';
