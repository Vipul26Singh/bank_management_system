
<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_expense') ?></h4></div>

<!--Alert-->
<div class="system-alert-box">
<table class="table table-striped table-bordered table-hover" cellspacing="0" rules="all" border="1" id="ContentPlaceHolder1_GridView1" style="background-color:White;width:100%;">
        <tbody><tr>
    <th scope="col">MemberID</th><th scope="col">AccountType</th>
    <th scope="col">BankAccount</th><th scope="col">Amount</th><th scope="col">OpenDate</th>
    </tr><?php foreach($data as $details){?><tr>
            <td><?php echo $details->member_id?></td>
             <td><?php echo $details->bank_account_number;?></td>
            <td><?php if($details->bank_account_type=='0'){echo 'Current';}else{echo 'Savings';}?></td>
            <td><?php echo $details->account_balance?></td>
            <td><?php echo $details->date;?></td>
        
        </tr><?php }?>
    </tbody></table>
</div>
</div></div></div>
<!--End Main-content DIV-->
</section><!--End Main-content Section-->




