<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/theme/images/favicon.png">
    <title>Register</title>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- Bootstrap -->
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url() ?>/theme/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>/theme/css/material.css" rel="stylesheet"> 
	<link href="<?php echo base_url() ?>/theme/css/login.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>/theme/css/font-awesome.css" rel="stylesheet">
	<!--<link href="css/jquery-ui.css" rel="stylesheet">-->
    <script src="<?php echo base_url() ?>/theme/js/pace.min.js"></script>
    <link href="<?php echo base_url() ?>/theme/css/pace-theme-minimal.css" rel="stylesheet" />

      
  </head>
  <body class="login-body">
  <div class="block-ui">
  <!--<div class="spinner">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div>
  </div>-->
  </div>  

  <div id="wrapper">
  <div class="login-div">
  <div class="system-name col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
  <div class="login-logo"><img src="<?php echo base_url() ?>/uploads/<?php  echo get_current_setting('logo_path'); ?>" alt=""/></div>
  <h3><?php  echo get_current_setting('company_name'); ?></h3>
  </div>

  <!--Alert-->
  <div class="system-alert-box col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
  <?php
	$message = $this->session->userdata('success');
	if ($message) {
		?>
		<!-- Alert Box -->
		<div class="alert my-alert alert-success">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Success! </strong><?php echo $message; ?>
		</div>
		<?php
	} else {
		$message = $this->session->userdata('error');
		if ($message) {
			?>
			<!-- Alert Box -->
			<div class="alert my-alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Alert! </strong><?php echo $message; ?>
			</div>
			<?php
		}
	}
	if (validation_errors()) {
		?>
		<!-- Alert Box //validation error -->
		<div class="alert my-alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<?php echo validation_errors('<i class="fa fa-times"> ', '</i></br>'); ?>
		</div>
	<?php } ?>
  </div>
  <!--End Alert-->
      
  <div class="col-md-4 col-lg-4 col-sm-6 register-panel col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
  <h3>Register</h3>
  <form autocomplete="off" class="register-form" method="post" action="<?php echo site_url('User/register/create') ?>">
  
   <div class="form-group"> 
	  <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-user my-control"></i></span>
	  <input type="text" class="form-control my-control" name="username" placeholder="Username" required/>
	  </div>
  </div>  
  
  <div class="form-group"> 
	  <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-info-circle my-control"></i></span>
	  <input type="text" class="form-control my-control" name="fullname" placeholder="FullName" required/>
	  </div>
  </div> 
   
  <div class="form-group"> 
	  <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-envelope my-control"></i></span>
	  <input type="email" class="form-control my-control" id="email" name="email" placeholder="Email" required/>
	  </div>
  </div>

  <div class="form-group"> 
	  <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-key my-control"></i></i></span>
	  <input type="password" class="form-control my-control" name="password" placeholder="Password" required/>
	  </div>
  </div>
  
  <button type="submit" class="btn btn-primary my-btn">Register</button>
  </form>
  
  </div>
  </div>
  </div><!-- End Wrapper -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
   <script src="<?php echo base_url() ?>/theme/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="<?php echo base_url() ?>/theme/js/bootstrap.js"></script>
   <!--<script src="js/jquery-ui.js"></script>-->
   <script>
   $(document).ready(function(){

   $("#email").val("Email");
   $("#email").css("color","rgba(204, 204, 204,0.8)");
   
   $("#email").focus(function(){
    if($("#email").val()=="Email"){
	  $(this).val("");
	}
   });
   
   });
   </script>

  </body>
</html>