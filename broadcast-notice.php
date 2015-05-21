<?php

include_once 'header.php';
?>
<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h3>Compose Broadcast notice or event</h3>
        </div>
        <form class="user-access form-horizontal" role="form">
            <div class="form-group">
                <div class="col-xs-6 col-sm-2">
                    <div class="checkbox">
                        <label>
                            Broadcast Event <input type="checkbox">
                        </label>
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-2">
                    <div class="checkbox">
                        <label>
                            Notice <input type="checkbox">
                        </label>
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-6 control-label text-right">Start Date: </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="inputPassword" placeholder="DD/MM/YY">
                        </div>
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-6 control-label text-right">Start Time: </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="inputPassword" placeholder="00:00">
                        </div>
                    </div> 
                </div> 
            </div>
            <div class="form-group">
                <div class="col-xs-6 col-sm-4">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-4 control-label">Event Name: </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="inputPassword" placeholder="">
                        </div>
                    </div> 
                </div>               
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-6 control-label text-right">End Date: </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="inputPassword" placeholder="DD/MM/YY">
                        </div>
                    </div> 
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-6 control-label text-right">Start Time: </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="inputPassword" placeholder="00:00">
                        </div>
                    </div> 
                </div>                 
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-10">                  
                    <textarea class="form-control" rows="6" placeholder="Type Message"></textarea>                    
                </div>
                <div class="col-xs-12 col-sm-2 btn-listings">                    
                    <input type="submit" class="btn btn-warning" value="Save Draft">                   
                    <input type="submit" class="btn btn-danger" value="Add Photo">                   
                    <input type="submit" class="btn btn-default" value="Cancel">                   
                    <input type="submit" class="btn btn-success" value="Cancel">                   
                </div>
            </div>
            <div class="form-group">
                <hr />
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="6" placeholder="Details of past notice or event"></textarea>  
            </div>
        </form>
    </div>
</section>
<?php

include_once 'footer.php';
