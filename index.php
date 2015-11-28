
<?php
	include('connection.php');
	include('baseURL.php');
?>
<html>
	<head>
		<title>Project Management</title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/stylesheet.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="row header">
				<center>Project Management</center>
				<a href="<?php echo BASE_URL; ?>settings.php"><span class="settings glyphicon glyphicon-cog"><span style="text-decoration:underline">Settings</span></span></a>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div id="pmem" class="nameslist">Project Members</div>
					<?php
					
					$query=mysql_query("SELECT * FROM `members`"); 

					while($row=mysql_fetch_assoc($query)){
                     ?>

						<a href='<?php echo BASE_URL; ?>index.php?id=<?php echo $row['member_id'];?>'> 
							<div class="nameslist"><?php echo $row['name']; ?></div> 
						</a>

						<?php
					}

					?>
					
				</div>
				<div class="col-md-9">
					<div class="row">
						<?php   
						  if(!isset($_GET['id'])){

						  	$query=mysql_query("SELECT * FROM `members` LIMIT 1"); 

					while($row=mysql_fetch_assoc($query)){
						  
						  	$id=$row['member_id'];

						  }
						}
						  else
                           $id=$_GET['id'];

                         $query=mysql_query("SELECT * FROM `members` WHERE `member_id`=$id");
                         	while($row=mysql_fetch_assoc($query)){
                       
						?>

						<div><img src='<?php echo BASE_URL; echo $row['image']; ?>' alt="Image not uploaded" height="130" width="180" /></div>
						<div class="name"><?php echo $row['name']; ?></div>

						<?php
					
				}
						?>
					</div>
					<div class="button"><button type="button" class="btn btn-default" style="color:#ffffff; background-color:#666666;">Create Report</button></div>
					<div class="row clear">
							<table class="table table-striped">
								<thead>
 							     <tr>
 							       <th class="tablehead twidth" style="vertical-align:middle;">Task</th>
 							       <th class="tablehead" style="vertical-align:middle;">Start Date</th>
 							       <th class="tablehead" style="vertical-align:middle;">End Date</th>
 							       <th class="tablehead" style="vertical-align:middle;">Estimated Hours</th>
 							       <th class="tablehead" style="vertical-align:middle;">Hours Spent</th>
 							       <th class="tablehead" style="vertical-align:middle;">Schedule Variance</th>
 							     </tr>
 							   </thead>
 							   <tbody>

 							   	<?php
 							   	//Pagination
 							   	if(!isset($_GET["page"]))
 							   	{
 							   		$page=1;
 							   		$page1=0;
 							   	}
 							   	else{
 							   		$page=$_GET["page"];

 							   		if($page=="" || $page=="1")
 							   		{
 							   			$page1=0;
 							   		}
 							   		else
 							   		{
 							   			$page1=($page*5)-5;
 							   		}
 							   	}
 							   	?>

 							   	<?php
 							     		$query=mysql_query("SELECT * FROM `task` WHERE `member_id`=$id LIMIT $page1,5");
 							     		while($row=mysql_fetch_assoc($query)){
 							     			?>
 							     		<tr>
 							     			<td><?php echo $row["task_desc"]; ?></td>
 							       			<td><?php echo $row["start_date"]; ?></td>
 							       			<td><?php echo $row["end_date"]; ?></td>
 							       			<td><?php echo $row["estimated_hours"]; ?></td>
 							       			<td><?php echo $row["hours_spent"]; ?></td>

 							       			<?php
												$schedule_variance=(($row['estimated_hours']-$row['hours_spent'])/$row['estimated_hours'])*100;
												$formated_number=number_format($schedule_variance,1);
											?>
											<td><?php echo $formated_number; ?>%</td>
 							     		</tr>
 							     <?php
 							       	}
 							       ?>
 							   </tbody>
							</table>
					</div>

					<?php 
						$pag=mysql_query("SELECT * FROM `task` WHERE `member_id`=$id");
						$roww=mysql_fetch_assoc($pag);
						$count=mysql_num_rows($pag);

						$count=ceil($count/5);
				
					?>
					
		

					<div class="row centeralign">
						<ul class="pager">
					<?php

						if($page>1 && $page<$count)
						{
							$b=$page+1;
							$c=$page-1;
						?>
							<li><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $c; ?>"> < </a></li>
    						<li><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $b; ?>"> > </a></li>
						<?php
						
						}
						elseif($page==1 && $count>1)
						{
							$b=$page+1;
						?>
							<li style="display:none"><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $c; ?>"> < </a></li>
    						<li><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $b; ?>"> > </a></li>

						<?php
						
						}
						elseif($page==$count && $count>1)
						{
							$page=$count;
							$c=$page-1;
						?>

							<li><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $c; ?>"> < </a></li>
							<li style="display:none"><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $b; ?>"> > </a></li>
						<?php
						}
						elseif($count==1 && $page<=1){
							?>
							<li style="display:none"><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $c; ?>"> < </a></li>
							<li style="display:none"><a href="<?php echo BASE_URL; ?>index.php?id=<?php echo $roww['member_id']; ?>&page=<?php echo $b; ?>"> > </a></li>

						<?php
						}
					?>
							
    					

  						</ul>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>