<footer id="footer" class="bt-6">
                <div class="container">
                    <div class="content-empty ht-50"><span class="sr-only">TODO Footer Content</span></div>
                </div>
            </footer><!--/#footer--> 
        </div><!--/#page-wrap--> 
        <!--Site Scripts--> 
        <script type='text/javascript' src='../js/jquery-1.8.2.min.js'></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/mCustomScrollbar.concat.min.js"></script> 
        <script type='text/javascript' src='../js/jquery.validationEngine-en.js'></script>
        <script type='text/javascript' src='../js/jquery.validationEngine.js'></script>      
        <script type="text/javascript" src="../js/scripts.js"></script>
        <script type='text/javascript' src='../js/jquery.form.js'></script>
		<script type='text/javascript' src='../js/ajax-form-submit.js'></script>
		<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#nav-logout").click(function(){
					if(confirm('Are you sure to log out?')){
						pageRedirect('../logout.php');
					}
				});
			});			
		</script>
    </body>
</html>
