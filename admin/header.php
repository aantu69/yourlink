<?php 
ob_start();
@session_start();
if(isset($_SESSION['UserRole']) && $_SESSION['UserRole'] == "0") 
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
        <link href="../css/validationEngine.jquery.css" rel="stylesheet"/>
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/jquery.mCustomScrollbar.min.css" rel="stylesheet">
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
                        <div class="col-xs-6 col-sm-4 hbtn hbtn-help"><a class="navbar-right" href="help.php"><span class="fa fa-question fa-5x"></span><span class="text-only">Help</span></a></div>
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
                        <ul class="nav navbar-nav admin-nav">
                            <li class="dropdown <?php if ('salutations.php' == $page_name || 'add-salutation.php' == $page_name || 'edit-salutation.php' == $page_name || 
                            'country.php' == $page_name || 'add-country.php' == $page_name || 'edit-country.php' == $page_name || 
                            'states.php' == $page_name || 'add-state.php' == $page_name || 'edit-state.php' == $page_name || 
                            'postcodes.php' == $page_name || 'add-postcode.php' == $page_name || 'edit-postcode.php' == $page_name || 
                            'suburbs.php' == $page_name || 'add-suburb.php' == $page_name || 'edit-suburb.php' == $page_name || 
                            'class.php' == $page_name || 'add-class.php' == $page_name || 'edit-class.php' == $page_name || 
                            'feedback-category.php' == $page_name || 'add-feedback-category.php' == $page_name || 'edit-feedback-category.php' == $page_name) echo 'active'; ?>">
                                <a href="">Master</a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="salutations.php">Salutation</a></li>
                                    <li><a href="country.php">Country</a></li>
                                    <li><a href="states.php">State</a></li>
                                    <li><a href="postcodes.php">Postcode</a></li>
                                    <li><a href="suburbs.php">Suburb</a></li>
                                    <li><a href="class.php">Class</a></li>
                                    <li><a href="feedback-category.php">Feedback Category</a></li>
                                </ul>
                            </li>
                            <li class="dropdown <?php if ('users-individual.php' == $page_name || 'add-user-individual.php' == $page_name || 
                            'edit-user-individual.php' == $page_name || 'users-service-provider.php' == $page_name || 
                            'add-user-service-provider.php' == $page_name || 'edit-user-service-provider.php' == $page_name || 
                            'users-residence.php' == $page_name || 'add-user-residence.php' == $page_name || 
                            'edit-user-residence.php' == $page_name || 'users-admin.php' == $page_name || 
                            'add-user-admin.php' == $page_name || 'edit-user-admin.php' == $page_name) echo 'active'; ?>">
                                <a href="">Users</a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="users-individual.php">Individuals</a></li>
                                    <li><a href="users-service-provider.php">Service Providers</a></li>
                                    <li><a href="users-residence.php">Residences</a></li>
                                    <li><a href="users-admin.php">Admin</a></li>
                                </ul>
                            </li>
                            <li class="<?php if ('notice.php' == $page_name) echo 'active'; ?>"><a href="notice.php">Notice</a></li>  
                            <li class="<?php if ('feedback.php' == $page_name) echo 'active'; ?>"><a href="feedback.php">Feedback</a></li>
                            <li class="<?php if ('billing.php' == $page_name) echo 'active'; ?>"><a href="billing.php">Billing</a></li> 
                            <li class="<?php if ('content.php' == $page_name) echo 'active'; ?>"><a href="content.php">Content</a></li>                        
                            <li id="nav-logout"><a href="#">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>