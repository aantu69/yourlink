<?php include("header.php"); ?> 
<?php
$url = ROOT_PATH.'v1/users/1';
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
//echo $response['error'];
?>
<section id="main-content">
    <div class="container">		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Users-Indivisual</h3>
			</div>
			<div class="panel-body">
				<div class="col-lg-12" style="padding-left: 0; padding-right: 0;" >
					<div class="pull-left" >
						<a href="add-user-individual.php"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New User</button></a>
					</div>
				</div>

				<div class="clearfix"></div>
				<?php
				if(count($response['users'])>0)
				{
				?>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-bordered user">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Status</th>
								<th>Country</th>
								<th>State</th>
								<th>Postcode</th>
								<th>Suburb</th>
								<th>Contact</th>
								<th>Action </th>
							</tr>
						</thead>
						<tbody>							
						<?php
						for($i=0; $i<count($response['users']); $i++) {?>
							<tr user_id="<?php echo $response['users'][$i]['user_id']; ?>">
								<td><?php echo $response['users'][$i]['last_name'].' '.$response['users'][$i]['first_name']; ?></td>
								<td><?php echo $response['users'][$i]['email']; ?></td>
								<td><?php echo $response['users'][$i]['user_status']; ?></td>
								<td><?php echo $response['users'][$i]['country']; ?></td>
								<td><?php echo $response['users'][$i]['state']; ?></td>
								<td><?php echo $response['users'][$i]['postcode']; ?></td>
								<td><?php echo $response['users'][$i]['suburb']; ?></td>
								<td><?php echo $response['users'][$i]['phone']; ?></td>
								<td>
									<a href="edit-user-individual.php?user_id=<?php echo $response['users'][$i]["user_id"]; ?>">
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
				<div class="well well-lg">No user found.</div>
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
		
		$('table.user td .delete').click(function()
		{
			if (confirm("Are you sure you want to delete this deal?"))
			{
				var user_id = $(this).parent().parent().attr('user_id');
				var parent = $(this).parent().parent();
				//alert(id);
				$.ajax(
				{
					type: "delete",
				    url: rootURL + '/' + user_id,
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