<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>/theme/images/favicon.png">
    <title>Login</title>
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
  <h3><?php echo get_current_setting('company_name'); ?></h3>
  </div>

  <!--Alert-->
	<?php
	$message = $this->session->userdata('success');
	if ($message) { ?>
	<!-- Alert Box -->
	<div class="col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
	<div class="alert my-alert alert-success">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php echo $message; ?>
	</div>
	</div>
	<?php } ?>
  
  <div class="system-alert-box col-md-4 col-lg-4 col-sm-6 col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
  <div class="alert alert-success ajax-notify"></div>
  </div>
  <!--End Alert-->
      
  <div class="col-md-4 col-lg-4 col-sm-6 login-panel col-md-offset-4 col-lg-offset-4 col-sm-offset-3">
  <h3>Tricky Money Management Pro</h3>
  <form class="login-form" method="post" action="<?php echo site_url('User/varifyUser') ?>">
   
  <div class="form-group"> 
  <div class="input-group">
  <span class="input-group-addon"><i class="fa fa-envelope my-control"></i></span>
  <input type="text" class="form-control my-control" name="email" placeholder="Email"/>
  </div></div>

  <div class="form-group"> 
  <div class="input-group">
  <span class="input-group-addon"><i class="fa fa-key my-control"></i></i></span>
  <input type="password" class="form-control my-control" name="password" placeholder="Password"/>
  </div></div>
  <button type="submit" class="btn btn-primary my-btn">Login</button>
  <?php if(get_current_setting('user_signup')=="yes"){ ?>
  <a href="<?php echo site_url('User/register') ?>" class="btn btn-info btn-block">Register</a>
  <?php } ?>
  </form>
  
  </div>
  </div>
  </div><!-- End Wrapper -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	
   <script src="<?php echo base_url() ?>/theme/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="<?php echo base_url() ?>/theme/js/bootstrap.js"></script>
   <!--<script src="js/jquery-ui.js"></script>-->

   <script type="text/JavaScript">
   $(document).ready(function(){
   $('.login-form').on('submit',function(){
    var link=$(this).attr("action");
   $.ajax({
    method : "POST",
    url : link,
    data : $(this).serialize(),
    beforeSend : function(){
    //$(".my-btn").html('');
    //$(".my-btn").addClass('loading');
    $(".block-ui").css("display","block");
    },success : function(data){ 
        var array = data.split(',');
        if(array[1]== 1){
              window.location.href ="<?php echo site_url('Admin/accountTypes') ?>";
        }
    else if(data=='true'){
    window.location.href ="<?php echo site_url('Admin/dashboard') ?>";
    $(".block-ui").css("display","none"); 
    if (!$(".ajax-notify").length){
    $(".system-alert-box").append("<div class='alert alert-success ajax-notify'></div>");
    }   
    $('.ajax-notify').css("display","block"); 
    $('.ajax-notify').addClass("alert-success"); 
    $('.ajax-notify').removeClass("alert-danger");     
    $('.ajax-notify').html('Login Sucessfully');  
    //$(".my-btn").removeClass('loading');
    $(".my-btn").html('Login');
    $(".block-ui").css("display","none");  

    }else{
    if (!$(".ajax-notify").length){
    $(".system-alert-box").append("<div class='alert alert-success ajax-notify'></div>");
    }   
    $('.ajax-notify').css("display","block"); 
    $('.ajax-notify').removeClass("alert-success"); 
    $('.ajax-notify').addClass("alert-danger");     
    $('.ajax-notify').html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <i class="fa fa-times-circle"></i> Username or Password Is Incorrect !');  
    $(".my-btn").removeClass('loading');
    $(".my-btn").html('Login');
    $(".block-ui").css("display","none");  
    }
    }
    });
   return false;
   });
   
   $(document).ajaxStart(function() { Pace.restart(); });

   });

   </script>

  </body>
</html>