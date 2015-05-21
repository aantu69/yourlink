<?php include("header.php"); ?> 
<?php
$url = ROOT_PATH.'v1/levelOneClasses';
$response = curl_get_call_with_auth($url,$api_key);
$response = json_decode($response,true);
?>
<section id="main-content">
    <div class="container">		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">First Level Class</h3>
			</div>
			<div class="panel-body">
				<div class="col-lg-12" style="padding-left: 0; padding-right: 0;" >
					<div class="pull-left" >
						<a href="add-class.php"><button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New Class</button></a>
					</div>
				</div>

				<div class="clearfix"></div>
				<?php
				if($response['error'] != 1)
				{
					if(count($response['classes'])>0)
					{
					?>
					<div class="table-responsive">
						<table class="table table-striped table-hover table-bordered chapter">
							<thead>
								<tr>
									<th>Class</th>
									<th>Order</th>
									<th>Contain 2nd Level</th>
									<th>Updated By</th>
									<th>Updated On</th>
									<th>Action </th>
								</tr>
							</thead>
							<tbody>							
							<?php
							for($i=0; $i<count($response['classes']); $i++) {?>
								<tr level_one_class_id="<?php echo $response['classes'][$i]['level_one_class_id']; ?>">
									<td><?php echo $response['classes'][$i]['level_one_class_name']; ?></td>
									<td><?php echo $response['classes'][$i]['level_one_class_order']; ?></td>
									<td>
										<input type="checkbox" <?php if($response['classes'][$i]["level_one_class_contain_level_two"] == 'true'){echo 'checked';} ?> id="level_one_class_contain_level_two" class="custom-checkbox show-checkbox" name="level_one_class_contain_level_two" disabled="disabled">
									<?php //echo $response['classes'][$i]['level_one_class_contain_level_two']; ?>
										
									</td>
									<td><?php echo $response['classes'][$i]['updated_by']; ?></td>
									<td><?php echo $response['classes'][$i]['updated_on']; ?></td>
									<td>
										<a href="edit-class.php?level_one_class_id=<?php echo $response['classes'][$i]["level_one_class_id"]; ?>">
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
					<div class="well well-lg">No category found.</div>
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
				var level_one_class_id = $(this).parent().parent().attr('level_one_class_id');
				var parent = $(this).parent().parent();
				//alert(id);
				$.ajax(
				{
					type: "delete",
				    url: rootURL + '/' + level_one_class_id,
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