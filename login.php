<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login | Hi-Tech Sales and Inventory System</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=dashboard");

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		width:60%;
		height: calc(100%);
		background-image:url('./assets/img/store.png');
		background-repeat:no-repeat;
		background-size: cover;
		align-items: center;
		padding-top: 250px;
	}
	#login-right .card{
		margin: auto
	}

h1{
	color:ghostwhite;
   	text-align:center;

	font-size: 50px;
	
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 25%;
}
</style>

<body>


  <main id="main" class=" bg-dark">
  		<div id="login-left">
			  <div style="width: 70%; height:65%; background-color:rgba(0, 0, 0, 0.5); margin:0 auto; padding-top:80px;padding-left:20px; border-radius:10px; box-shadow:10px 10px 5px rgb(128,128,128);">
  			<h1>Hi-Tech Sales <br>and Inventory System</h1>
			  </div>
  		</div>
  		<div id="login-right">
  			<div class="card col-md-8" style="background-color:#005178;box-shadow: 3px 4px grey;">
			  <div class="card-header">
			  <img src="./assets/img/login.png" alt="login" class="center">
			  <h6 style="color:white"><center>Login</center></h6>
			  </div>
  				<div class="card-body" >
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label" style="color:white;" >Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label" style="color:white;">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  					</form>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'./admin_class.php?a=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1 || resp==2){
					location.href ='index.php?page=dashboard';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>