<?php
include_once 'header.php';

$user_id = $_SESSION['UserId'];
$url = ROOT_PATH."v1/getCurrentLinksFavoured/".$user_id;
$response = curl_get_call_with_auth($url, $api_key);
$response = json_decode($response,true);
$currentLinks = $response['currentLinks'];
$numberOfFavoured = $response['numberOfFavoured'];
?>
<section id="main-content">
    <div class="container">
        <div class="jumbotron text-center">
            <h2>Welcome</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>            
        </div>
        <div class="entry-content">
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget arcu congue, molestie nisi facilisis, viverra augue. Pellentesque ac dui iaculis, aliquam lacus vitae, placerat lectus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam venenatis enim in efficitur vestibulum. Mauris porttitor enim sapien, sollicitudin placerat nisi posuere sit amet. Suspendisse sit amet ante eget libero hendrerit tempus. Sed porttitor accumsan leo, at auctor justo varius et. Praesent blandit non elit vel vestibulum. Nam cursus, odio eu malesuada commodo, dui est hendrerit tortor, ut vulputate diam ipsum at urna.</p>

            <p>Ut eu auctor tortor, non feugiat ligula. Mauris non massa imperdiet, porttitor purus sit amet, tincidunt est. Mauris varius rhoncus mauris, in porta nunc. Ut sagittis ipsum elit, tempor eleifend metus posuere nec. Nulla non lacinia metus, id imperdiet massa. Donec euismod erat vitae lacus feugiat, ut ultrices justo malesuada. In non ex nec nibh tristique cursus eu id metus. Curabitur convallis porttitor elit, a egestas magna ornare quis. Mauris nunc felis, interdum ac lorem ut, aliquam laoreet dolor. </p>
        </div>
        <div class="row link-count-buttons text-center">
            <div class="col-sm-offset-3 col-sm-3">

                <div class="btn-group" role="group">
                    <a href="#" class="btn btn-default btn-lg">
                        <span class="sr">Current Links</span>
                        <span class="link-count"><?php echo $currentLinks;?></span>
                    </a>
                </div>  

            </div>
            <div class="col-sm-3">
                <div class="btn-group" role="group">
                    <a href="#" class="btn btn-default btn-lg">
                        <span class="sr">Favoured</span>
                        <span class="link-count"><i class="glyphicon glyphicon-star"></i> <?php echo $numberOfFavoured;?></span>
                    </a>
                </div>  
            </div>
        </div>
    </div>
</section>
<?php

include_once 'footer.php';