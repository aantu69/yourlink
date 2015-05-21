<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'header.php';
?>

<section id="main-content">
    <div class="container">
        <div class="page-header">
            <h1>Service Provider Link</h1>
        </div>
        <div class="entry-content">
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget arcu congue, molestie nisi facilisis, viverra augue. Pellentesque ac dui iaculis, aliquam lacus vitae, placerat lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam venenatis enim in efficitur vestibulum. Mauris porttitor enim sapien, sollicitudin placerat nisi posuere sit amet. Suspendisse sit amet ante eget libero hendrerit tempus. Sed porttitor accumsan leo, at auctor justo varius et. Praesent blandit non elit vel vestibulum. Nam cursus, odio eu malesuada commodo, dui est hendrerit tortor, ut vulputate diam ipsum at urna.</p>
            <form class="form-inline form-sarch-inline" action="" role="form">
                <div class="form-group col-sm-8">
                    <input type="text" placeholder="Search here" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" value="Search">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-danger" value="Clear Search">
                </div>
            </form>
        </div>    
        <div class="row">
            <div class="col-xs-12">
                <div class="content-round-container padd-30">   
                    <div id="service-lists-container">
                        <div class="list-group service-lists">
                            <div class="list-group-item cell-hearder">
                                <div class="row">
                                    <div class="col-sm-9 cell-left"><h4 class="service-cat-title">Category</h4></div>
                                    <div class="col-sm-3 cell-right">&nbsp;</div>
                                </div>
                            </div>
                            <?php for ($i = 1; $i < 20; $i++): ?>
                                <div class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-9 cell-left">
                                            <a class="cell-avater" href=""> <img class="avatar" src="images/avatar.png" alt="user name"></a>
                                            <p class="cell-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget arcu congue, molestie nisi facilisis, viverra augue. Pellentesque ac dui iaculis, aliquam lacus vitae, placerat lectus. </p>
                                        </div>
                                        <div class="col-sm-3 cell-right">
                                            <div class="checkbox">
                                                <label>View Only <input type="checkbox"></label>
                                            </div>
                                            <div class="checkbox">
                                                <label>Send & Receive <input type="checkbox"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#main-content--> 

<?php
include_once 'footer.php';
