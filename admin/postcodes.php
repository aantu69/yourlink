<?php include("header.php"); ?> 
<?php
$url = ROOT_PATH.'v1/postcodes';
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
//echo $response['error'];
?>
<section id="main-content">
    <div class="container">		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Postcode</h3>
			</div>
			<div class="panel-body">
				<div class="col-lg-12" style="padding-left: 0; padding-right: 0;" >
					<div class="pull-left" >
						<a href="add-postcode.php"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New Postcode</button></a>
					</div>
				</div>

				<div class="clearfix"></div>
				<?php
				if($response['error'] != 1)
				{
					if(count($response['postcodes'])>0)
					{
					?>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-bordered chapter">
							<thead>
								<tr>
									<th>Postcode</th>
									<th>State</th>
									<th>Country</th>
									<th>Updated By</th>
									<th>Updated On</th>
									<th>Action </th>
								</tr>
							</thead>
							<tbody>							
							<?php
							for($i=0; $i<count($response['postcodes']); $i++) {?>
								<tr postcode_id="<?php echo $response['postcodes'][$i]["postcode_id"]; ?>">
									<td><?php echo $response['postcodes'][$i]["postcode_name"]; ?></td>
									<td><?php echo $response['postcodes'][$i]["state_name"]; ?></td>
									<td><?php echo $response['postcodes'][$i]["country_name"]; ?></td>
									<td><?php echo $response['postcodes'][$i]["updated_by"]; ?></td>
									<td><?php echo $response['postcodes'][$i]["updated_on"]; ?></td>
									<td>
										<a href="edit-postcode.php?postcode_id=<?php echo $response['postcodes'][$i]["postcode_id"]; ?>">
											<button class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-edit"></span> Edit</button>
										</a>&nbsp;
										<button class="btn btn-sm btn-danger delete"><span class="glyphicon glyphicon-remove-circle"></span> Delete</button>
									</td><?php
							}
							?>						
							</tbody>
						</table>
					</div>
					<?php
					}
					else
					{
					?>
					<div class="well well-lg">No postcode found.</div>
					<?php
					}
				}
				else
				{
				?>
					<div class="well well-lg"><?php echo $response['message']; ?></div>
				<?php
				}
				?>
				
			</div>
		</div>
	</div>
</section>
                        
<?php include("footer.php"); ?>  
<script type="text/javascript">
	$(document).ready(function()
	{	
		var rootURL = "http://localhost:8080/developyourchild/api/chapters";
		
		$('table.chapter td .delete').click(function()
		{
			if (confirm("Are you sure you want to delete this deal?"))
			{
				var postcode_id = $(this).parent().parent().attr('postcode_id');
				var parent = $(this).parent().parent();
				//alert(id);
				$.ajax(
				{
					type: "delete",
				    url: rootURL + '/' + postcode_id,
				    cache: false,
				    beforeSend: function() {					
						parent.animate({'backgroundColor':'yellow'},300);
				    },
				    error: function(){alert("Error");},
				    success: function(data,status)
				    {
						parent.fadeOut('slow', function() {$(this).remove();});
				    }
				});				
			}
		});
	});
</script>