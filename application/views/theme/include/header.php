<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="user-scalable=no" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="icon" type="image/png" href="<?php echo base_url() ?>/theme/images/logo_1.jpg">
<title><?php get_phrase('People_Developement') ?></title>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Bootstrap -->
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url() ?>/theme/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url() ?>/theme/css/metisMenu.css" rel="stylesheet">
<link href="<?php echo base_url() ?>/theme/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url() ?>/theme/css/ionicons.css" rel="stylesheet">
<link href="<?php echo base_url() ?>/theme/css/c3.css" rel="stylesheet">
<link href="<?php echo base_url() ?>/theme/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url() ?>/theme/css/bootstrap-datepicker.css" rel="stylesheet"> 
<link href="<?php echo base_url() ?>/theme/css/fullcalendar.css" rel="stylesheet">  
<link href="<?php echo base_url() ?>/theme/css/jquery.dataTables.min.css" rel="stylesheet">  
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/theme/css/responsive.dataTables.css">
<link href="<?php echo base_url() ?>/theme/css/slicknav.css" rel="stylesheet">  
<link href="<?php echo base_url() ?>/theme/css/sweetalert.css" rel="stylesheet"> 
<script src="<?php echo base_url()?>theme/js/moment.min.js"></script>
<link href="<?php echo base_url() ?>/theme/css/material.css" rel="stylesheet"> 
<link href="<?php echo base_url() ?>/theme/css/ripples.css" rel="stylesheet"> 
<link href="<?php echo base_url() ?>/theme/css/roboto.css" rel="stylesheet"> 

<link href="<?php echo base_url() ?>/theme/css/my-style.css" rel="stylesheet">
   
<!--jquery-->   
<script src="<?php echo base_url() ?>/theme/js/jquery.js"></script>
<script src='<?php echo base_url() ?>/theme/js/modernizr.js'></script>
    
<script src="<?php echo base_url() ?>/theme/js/pace.min.js"></script>
<link href="<?php echo base_url() ?>/theme/css/pace-theme-minimal.css" rel="stylesheet" />


</head>
<body>
<div class="block-ui">
  <!--<div class="spinner">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div>
  </div>-->
  <div class="preloader4"></div>
</div>
<div id="wrapper">
<div class="row">
<header>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 headerbar">
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 left-headerbar">
<ul class="leftheader-menu">
<li><a href=""><?php get_phrase('People_Developement') ?></a></li>
<li class="hide-class"><a class="hide-nav" href=""><i class="fa fa-bars"></i></a></li>
</ul>
</div>
<!-- End left header-->

<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 right-headerbar">
<div class="rightheader-menu">

<div class="header-nav-profile">
    <a id="profile" href=""><img src="<?php echo base_url() ?>/theme/images/avatar.jpg" alt="" />
        <span class="profile-info"><?php echo $this->session->userdata('username'); ?>
<?php if ($this->session->userdata('user_type')=='Admin'){ ?>
<small><?php get_phrase('administrator') ?></small>
<?php }else{ ?>
<small><?php get_phrase('user') ?></small>
<?php } ?> 

</span><span class="caret"></span>
    </a>
    <ul class="dropdown-profile">
        <li><a href="" data-toggle="modal" data-target="#profileModal"><i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;<?php get_phrase('profile') ?></a></li>
        <li><a href="" data-toggle="modal" data-target="#passwordModal"><i class="fa fa-exchange"></i>&nbsp;&nbsp;&nbsp;<?php get_phrase('change_password') ?></a></li>
        <li><a href="<?php echo site_url('User/logout') ?>"><i class="fa fa-power-off"></i>&nbsp;&nbsp;&nbsp;<?php get_phrase('logout') ?></a></li>
    </ul>
</div>
<!--End Header-nav-provile -->
</div>
</div>
<!-- End Right header-->

<!-- End Header-->
<!--Start Sidebar-->
</div>
</header>


<!-- Profile Modal -->
<div id="profileModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"><?php get_phrase('profile') ?></h4>
</div>
<div class="modal-body">
  
 <!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_edit_profile') ?></div>
    <div class="panel-body add-client">
    <form id="edit-profile" method="post" action="<?php echo site_url('Admin/updateProfile') ?>">
  <div class="form-group">
    <label for="profle-username"><?php get_phrase('username') ?></label>
    <input type="text" value="<?php echo $this->session->userdata('username') ?>" class="form-control" name="username" id="profle-username">
  </div>
  <div class="form-group">
    <label for="profle-fullname"><?php get_phrase('fullname') ?></label>
    <input type="text" value="<?php echo $this->session->userdata('fullname') ?>"
    class="form-control" name="fullname" id="profle-fullname">
  </div>
   <div class="form-group">
    <label for="profle-email"><?php get_phrase('email') ?></label>
    <input type="text" value="<?php echo $this->session->userdata('email') ?>" class="form-control" name="email" id="profle-email">
  </div>    
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('update') ?></button>
</form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel--> 
</div>

</div>
</div>
</div>
<!--End Model-->


<!-- Modal -->
<div id="passwordModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"><?php get_phrase('change_password') ?></h4>
</div>
<div class="modal-body">
  
 <!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('change_password') ?></div>
    <div class="panel-body add-client">
    <form id="change-password" method="post" action="<?php echo site_url('Admin/changePassword') ?>">
  <div class="form-group">
    <label for="new-password"><?php get_phrase('new_password') ?></label>
    <input type="password" 
    class="form-control" name="new-password" id="new-password">
  </div>
  <div class="form-group">
    <label for="confrim-change"><?php get_phrase('confrim_password') ?></label>
    <input type="password" 
    class="form-control" name="confrim-password" id="confrim-password">
  </div>
  
        
  <button type="submit"  class="mybtn btn-submit"><i class="fa fa-check"></i> <?php get_phrase('update') ?></button>
</form>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel--> 
</div>

</div>
</div>
</div>
<!--End Model-->

<!-- Calculator Model -->
<!-- Modal -->
<div id="calculatorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"><?php get_phrase('calculator') ?></h4>
</div>
<div class="modal-body">
  
  <div class="calculator">
  <input type="text" readonly>
  <div class="row">
    <div class="key">1</div>
    <div class="key">2</div>
    <div class="key">3</div>
    <div class="key last">0</div>
  </div>
  <div class="row">
    <div class="key">4</div>
    <div class="key">5</div>
    <div class="key">6</div>
    <div class="key last action instant">cl</div>
  </div>
  <div class="row">
    <div class="key">7</div>
    <div class="key">8</div>
    <div class="key">9</div>
    <div class="key last action instant">=</div>
  </div>
  <div class="row">
    <div class="key action">+</div>
    <div class="key action">-</div>
    <div class="key action">x</div>
    <div class="key last action">/</div>
  </div>

</div>

</div>

</div>
</div>
</div>
<!--End Calculator Model-->

<!-- Calendar Model -->
<!-- Modal -->
<div id="calendarModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"><?php get_phrase('calendar') ?></h4>
</div>
<div class="modal-body">
<!-- Create Calendar-->
<div id="current-calendar"></div>

</div>

</div>
</div>
</div>
<!--End Calendar Model-->


<section>
<div class="content-area">
<aside>
<div class="sidebar">

<ul id="menu" class="menu-helper asyn-menu">
<li><a class="active-menu" href="<?php echo site_url('Admin/dashboard') ?>"><i  class="fa fa-tachometer"></i>
<span class="title"><?php get_phrase('dashboard') ?></span></a></li>

<li class="has-sub">
<a href="#"><i class="fa fa-suitcase"></i>
<span class="title"><?php get_phrase('widgets') ?></span></a>
<ul class="collapse">
    <li><a href="#" data-toggle="modal" data-target="#calculatorModal"><i class="fa fa-calculator"></i> <?php get_phrase('calculator') ?></a></li>
    <li><a href="#" data-toggle="modal" data-target="#calendarModal"><i class="fa fa-calendar"></i> <?php get_phrase('calendar') ?></a></li>
</ul>

<li class="has-sub">
<a href="#"><i class="fa fa-university"></i>
<span class="title"><?php get_phrase('accounts') ?></span></a>
<ul class="collapse">
	<li><a href="<?php echo site_url('Admin/addMember') ?>"><i class="fa fa-user-plus"></i> <?php get_phrase('add_member') ?></a></li>
	<li><a href="<?php echo site_url('BankData/show_all_member') ?>"><i class="fa fa-user-plus"></i> <?php get_phrase('manage_member') ?></a></li>
	<li><a href="<?php echo site_url('Admin/addAccount') ?>"><i class="fa fa-user-plus"></i> <?php get_phrase('add_accounts') ?></a></li>
	<li><a href="<?php echo site_url('Admin/manageAccount') ?>"><i class="fa fa-table"></i> <?php get_phrase('manage_accounts') ?></a></li>
	<li><a href="<?php echo site_url('Admin/add_fixed_deposit') ?>"><i class="fa fa-user-plus"></i> <?php get_phrase('add_fixed_deposit') ?></a></li>
    <li><a href="<?php echo site_url('Admin/add_bank_loan') ?>"><i class="fa fa-user-plus"></i> <?php get_phrase('manage_loan') ?></a></li>
</ul>
</li>
<li class="has-sub">
<a href="#"><i class="fa fa-money"></i>
<span class="title"><?php get_phrase('transaction') ?></span></a>
<ul class="collapse">
    <li><a class="asyn-income" href="<?php echo site_url('Admin/addIncome') ?>"><i class="fa fa-plus-square"></i> <?php get_phrase('deposit') ?></a></li>
    <li><a class="asyn-expense" href="<?php echo site_url('Admin/addExpense') ?>"><i class="fa fa-minus-square"></i> <?php get_phrase('withdraw') ?></a></li>
    <li><a href="<?php echo site_url('Admin/transfer') ?>"><i class="fa fa-retweet"></i> <?php get_phrase('transfer') ?></a></li>
    <li><a href="<?php echo site_url('Admin/depositShare') ?>"><i class="fa fa-calculator"></i> <?php get_phrase('depositShare') ?></a></li>
     <li><a href="<?php echo site_url('Admin/payLoan') ?>"><i class="fa fa-retweet"></i> <?php get_phrase('pay_loan') ?></a></li>
      <li><a href="<?php echo site_url('Admin/take_fixed_deposit') ?>"><i class="fa fa-retweet"></i> <?php get_phrase('take_fixed_deposit') ?></a></li>
    <!-- <li><a href="<?php echo site_url('Admin/manageIncome') ?>"><i class="fa fa-calculator"></i> <?php get_phrase('manage_Deposit') ?></a></li>
    <li><a href="<?php echo site_url('Admin/manageExpense') ?>"><i class="fa fa-calculator"></i> <?php get_phrase('manage_withdraw') ?></a></li> -->
</ul>
</li>

<!-- <li class="has-sub">
<a href="#"><i class="fa fa-repeat"></i>
<span class="title"><?php get_phrase('recurring_transaction') ?></span></a>
<ul class="collapse">
    <li><a class="asyn-repeat-income" href="<?php echo site_url('Admin/repeatIncome') ?>"><i class="fa fa-plus-circle"></i> <?php get_phrase('repeating_income') ?></a></li>
    <li><a class="asyn-repeat-expense" href="<?php echo site_url('Admin/repeatExpense') ?>"><i class="fa fa-minus-circle"></i> <?php get_phrase('repeating_expense') ?></a></li>
	<li><a href="<?php echo site_url('Admin/processIncome') ?>"><i class="fa fa-calendar-plus-o"></i> <?php get_phrase('manage_repeating_income') ?></a></li>
	<li><a href="<?php echo site_url('Admin/processExpense') ?>"><i class="fa fa-calendar-minus-o"></i> <?php get_phrase('manage_repeating_expense') ?></a></li>
    <li><a href="<?php echo site_url('Admin/incomeCalender') ?>"><i class="fa fa-calendar"></i> <?php get_phrase('income_calendar') ?></a></li>
    <li><a href="<?php echo site_url('Admin/expenseCalender') ?>"><i class="fa fa-calendar"></i> <?php get_phrase('expense_calendar') ?></a></li>
</ul>
</li> -->


<li class="has-sub">
<a href="#"><i class="fa fa-area-chart"></i>
<span class="title"><?php get_phrase('reporting') ?></span></a>
<ul class="collapse">
    <li><a href="<?php echo site_url('Reports/accountStatement') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('account_statement') ?></a></li>
    <li><a href="<?php echo site_url('Reports/datewiseIncomeReport') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('income_report_by_date') ?></a></li>
    <!-- <li><a href="<?php echo site_url('Reports/daywiseIncomeReport') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('day_wise_income_report') ?></a></li> -->
    <li><a href="<?php echo site_url('Reports/datewiseExpenseReport') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('expense_report_by_date') ?></a></li>
   <!--  <li><a href="<?php echo site_url('Reports/daywiseExpenseReport') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('day_wise_expense_report') ?></a></li> -->
    <li><a href="<?php echo site_url('Reports/transferReport') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('transfer_report') ?></a></li>
    <li><a href="<?php echo site_url('Reports/incomeVsExpense') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('income_vs_expense_report') ?></a></li>
   <!--  <li><a href="<?php echo site_url('Reports/incomeCategoryReport') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('report_by_chart_of_account') ?></a></li> -->
   <!--  <li><a href="<?php echo site_url('Reports/reportByPayer') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('report_by_payer') ?></a></li>
    <li><a href="<?php echo site_url('Reports/reportByPayee') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('report_by_payee') ?></a></li> -->
    <li><a href="<?php echo site_url('Reports/loan_report') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('loan_report') ?></a></li>
    <li><a href="<?php echo site_url('Reports/fixed_deposit_report') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('fixed_deposit_report') ?></a></li>
    <li><a href="<?php echo site_url('Reports/share_accounts') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('share_accounts_report') ?></a></li>
     <li><a href="<?php echo site_url('Reports/loan_emi_report') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('loan_emi_report') ?></a></li>
      <li><a href="<?php echo site_url('Reports/user_transaction_report') ?>"><i class="fa fa-angle-double-right"></i> <?php get_phrase('user_transaction_report') ?></a></li>
</ul>
</li>

<li class="has-sub">
<a href="#"><i class="fa fa-credit-card"></i>
<span class="title"><?php get_phrase('transaction_settings') ?></span></a>
<ul class="collapse">
    <li><a href="<?php echo site_url('Admin/chartOfAccounts') ?>"><i class="fa fa-book"></i> <?php get_phrase('chart_of_accounts') ?></a></li>
    <li><a href="<?php echo site_url('Admin/payeeAndPayers') ?>"><i class="fa fa-exchange"></i> <?php get_phrase('payees_and_payers') ?></a></li>
    <li><a href="<?php echo site_url('Admin/accountTypes') ?>"><i class="fa fa-users"></i> <?php get_phrase('accountTypes') ?></a></li>
    <li><a href="<?php echo site_url('Admin/paymentMethod') ?>"><i class="fa fa-credit-card"></i> <?php get_phrase('payment_method') ?></a></li>
    <li><a href="<?php echo site_url('Admin/late_fees_charges') ?>"><i class="fa fa-credit-card"></i> <?php get_phrase('late_fees_charges') ?></a></li>
     <!-- <li><a href="<?php echo site_url('Admin/process_data') ?>"><i class="fa fa-credit-card"></i> <?php get_phrase('process_data') ?></a></li> -->
</ul>
</li>
<li class="has-sub">
<a href="#"><i class="fa fa-credit-card"></i>
<span class="title"><?php get_phrase('Service_and_item_management') ?></span></a>
<ul class="collapse">
     <li><a href="<?php echo site_url('Admin/service_management') ?>"><i class="fa fa-users"></i> <?php get_phrase('service_management') ?></a></li>
     <li><a href="<?php echo site_url('Admin/item_management') ?>"><i class="fa fa-users"></i> <?php get_phrase('item_management') ?></a></li>
       <li><a href="<?php echo site_url('Admin/customerServices') ?>"><i class="fa fa-database"></i> <?php get_phrase('customer_Services') ?></a></li>
       <li><a href="<?php echo site_url('Admin/add_item') ?>"><i class="fa fa-database"></i> <?php get_phrase('add_item') ?></a></li>
        <li><a href="<?php echo site_url('Admin/withdrawAll') ?>"><i class="fa fa-calculator"></i> <?php get_phrase('withdraw_service_charges') ?></a></li>
</ul>
</li>
<!-- 
<li class="has-sub">
<a href="#"><i class="fa fa-credit-card"></i>
<span class="title"><?php get_phrase('bank_data') ?></span></a>
<ul class="collapse">
    <li><a href="<?php echo site_url('BankData/show_all_member') ?>"><i class="fa fa-book"></i> <?php get_phrase('show_all_member') ?></a></li>
    <li><a href="<?php echo site_url('BankData/show_all_current_saving') ?>"><i class="fa fa-book"></i> <?php get_phrase('show_all_accounts') ?></a></li>
</ul>
</li> -->
<?php if($this->session->userdata('user_type')!='User') {?>
<li class="has-sub">
<a href="#"><i class="fa fa-cog"></i>
<span class="title"><?php get_phrase('administration') ?></span></a>
<ul class="collapse">
    <li><a href="<?php echo site_url('Admin/userManagement') ?>"><i class="fa fa-users"></i> <?php get_phrase('user_management') ?></a></li>
     <li><a href="<?php echo site_url('Admin/fdManagement') ?>"><i class="fa fa-users"></i> <?php get_phrase('fd_management') ?></a></li>
      <li><a href="<?php echo site_url('Admin/loanSetup') ?>"><i class="fa fa-users"></i> <?php get_phrase('loan_setup') ?></a></li>
      <li><a href="<?php echo site_url('Admin/addPhotoIdentity') ?>"><i class="fa fa-users"></i> <?php get_phrase('add_photo_identity') ?></a></li>
    <li><a href="<?php echo site_url('Admin/addLanguage') ?>"><i class="fa fa-language"></i> <?php get_phrase('add_language') ?></a></li>
    <li><a href="<?php echo site_url('Admin/generalSettings') ?>"><i class="fa fa-cogs"></i> <?php get_phrase('general_settings') ?></a></li>
    <li><a href="<?php echo site_url('Admin/backupDatabase') ?>"><i class="fa fa-database"></i> <?php get_phrase('backup_database') ?></a></li>
   
</ul>
</li>
<?php } ?>
</ul>
</div>
</aside>
<!--Javascript Code -->
<script type="text/Javascript">

</script>



<!--End Sidebar-->
<div class="asyn-div">
