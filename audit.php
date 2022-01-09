<div class="container-fluid">
    <div class="col-lg-15">
        <div class="row">
            <div class="col-md-12">
				<div class="card">
                <div class="card-header">
                <div style="font-size:20px; padding-bottom:5px;">
							<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
						</div>
						<div class="col">
							<div>
								<h4><b>Logs</b></h4>
							<br>
							</div>				
						<!-- <div>
						<button class="btn btn-primary float-left btn-sm" type="button" onclick="location.reload()">
                                <i class="fa fa-retweet"></i> Refresh List</button>		
						</div> -->
						</div>

						<div class="row float-right btn-sm-4" style="padding-right: 20px;">
							<a href="./print/print_logs.php">
								<p id="print-btn">Print</p>
							</a>
						</div>
					</div>
				
                    <div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<table class="table table-bordered">
								
                            <thead>
                                <th class="py-1 px-2">#</th>
                                <th class="py-1 px-2">DateTime</th>
                                <th class="py-1 px-2">Username</th>
                                <th class="py-1 px-2">Action Made</th>
                        
                             </thead>
                        <tbody>
                            <?php 
                            include 'db_connect.php';
                            $qry = $conn->query("SELECT
                                                    log.id,
                                                    log.date_created,
                                                    user.username,
                                                    log.action_made
                                                FROM logs log 
                                                
                                                LEFT JOIN(
                                                    SELECT
                                                    username,
                                                        id
                                                    FROM users
                                                )user ON user.id = log.user_id
                                                order by log.date_created desc");
                            $i = 1;
                            while($row=$qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="py-1 px-2"><?php echo $i++ ?></td>
                                <td class="py-1 px-2"><?php echo $row['date_created'] ?></td>
                                <td class="py-1 px-2"><?php echo $row['username'] ?></td>
                                <td class="py-1 px-2"><?php echo $row['action_made'] ?></td>
                            </tr>
                                <?php endwhile; ?>
                                
                            </tbody>
                
                        </table>
        </div>
</div>
</div>
</div>
</div>
    </div>
    </div>
</div>              
<script>
    $('table').dataTable()
</script>