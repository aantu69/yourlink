<?php 
ob_start();
@session_start(); //session_destroy();
if(isset($_SESSION['UserRole']) && $_SESSION['UserRole'] == "2") 
{
	$api_key = $_SESSION['ApiKey'];
	$user_id = $_SESSION['UserId'];
	$user_role = $_SESSION['UserRole'];
}
else
{
	header('Location: ../login.php');
}
require_once '../include/Config.php';
require_once '../include/function.php';
$page_name = explode('/',$_SERVER['SCRIPT_NAME']);
$page_name = end($page_name);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Your Link</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
        <!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
        <!--script src="js/less-1.3.3.min.js"></script-->
        <!--append ‘#!watch’ to the browser URL, then refresh the page. -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
        <link href="../jquery-ui-1.11.0.custom/jquery-ui.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="../js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../images/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../images/favicon.ico">


    </head>

    <body class="yl">
        <div id="page-wrap" class="wraper">
            <header id="header" class="navbar">
                <div class="container">                   
                    <div class="row row-hbtn">
                        <div class="col-xs-6 col-sm-4 hbtn hbtn-home"><a class="navbar-left" href="index.php"><span class="fa fa-home fa-5x"></span><span class="text-only">Home</span></a></div>
                        <div class="col-xs-12 col-sm-4 hbtn hbtn-logo"><a href="index.php" class=""> <img class="logo-lg-center" src="../images/logo-invert.png" alt="Logo: Your Link"/></a></div>
                        <div class="col-xs-6 col-sm-4 hbtn hbtn-help"><a class="navbar-right" href="#"><span class="fa fa-question fa-5x"></span><span class="text-only">Help</span></a></div>
                    </div>   
                    <div class="clearfix"></div>
                </div>
            </header><!--/#Header--> 
            <nav id="primary-navbar" class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#primary-navigation">
                            <span class="sr">Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                            
                        </button>                       
                    </div>
                    <div class="collapse navbar-collapse" id="primary-navigation">
                        <ul class="nav navbar-nav sp-nav">
                            <li class="<?php if ('broadcast-notice.php' == $page_name) echo 'active'; ?>"><a href="broadcast-notice.php">Broadcasts</a></li>
                            <li class="<?php if ('messages-residence.php' == $page_name) echo 'active'; ?>"><a href="messages-residence.php">Messages</a></li>                           
                            <li class="<?php if ('account-details.php' == $page_name) echo 'active'; ?>"><a href="account-details.php">Account Details</a></li>
                            <li class="<?php if ('yourlink-message.php' == $page_name) echo 'active'; ?>"><a href="yourlink-message.php">YourLink</a></li>
                            <li id="nav-logout"><a href="#">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>