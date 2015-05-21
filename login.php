<?php

include_once 'header.php';
?>
<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h3>Login</h3>
        </div>
        <form class="form-horizontal user-access" role="form" method="post" action="">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 col-md-2 control-label">Email Address</label>
                <div class="col-sm-6 col-md-5">
                    <input type="email" class="form-control" placeholder="Email" name="email" id="email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 col-md-2 control-label">Password</label>
                <div class="col-sm-6 col-md-5">
                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                </div>
            </div>
            <!--<div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Remember me
                        </label>
                    </div>
                </div>
            </div>-->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="button" class="btn btn-primary btn-login" value="Sign in" name="submit" id="login"/>
                    <a href="registration.php" class="btn btn-info btn-success">Create Account</a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                     <a href="#" class="btn btn-link">Forgot Password</a>
                     <a href="#" class="btn btn-link">Get help here.</a>
                </div>
                <div id='message' style='float:left;padding-top: 5px;'><span></span></div>
            </div>
        </form>
    </div>
</section>
<?php

include_once 'footer.php';
?>
<script type='text/javascript'>
	$(document).ready(function() {	
	 	$("#login").click(function() {			 		
	 		var url = 'login-processing.php';
			var email = $("#email").val();
			var password = $("#password").val();
			var tzOffset = (new Date()).getTimezoneOffset();					
			var data = "email="+email+"&password="+password+"&tzOffset="+tzOffset;
			ajaxPostCall(url, data, OnSuccessFunction);
			//alert(data);
        });
	});
	
	function OnSuccessFunction(response){		
		if(response==0){
			pageRedirect('admin/index.php');
		}
		else if(response==2){
			pageRedirect('serviceprovider/index.php');
		}
		else if(response==3){
			pageRedirect('residence/index.php');
		}
		else{
			alert(response);
		}
	};
	
</script>
