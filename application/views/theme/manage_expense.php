
<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_expense') ?></h4></div>
<div class="col-md-12 col-lg-12 col-sm-12">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_manage_expense') ?> <div class="add-button">
    <a class="mybtn btn-default asyn-link" href="<?php echo site_url('Admin/addExpense') ?>"><?php get_phrase('add_expense') ?></a>
    </div></div>
    <div class="panel-body manage-client">
        <table id="manage-expense" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>    
        <th><?php get_phrase('date') ?></th>
		<th><?php get_phrase('account') ?></th>
		<th><?php get_phrase('method') ?></th>
		<th><?php get_phrase('reference') ?></th> 
        <th><?php get_phrase('note') ?></th>
		<th><?php get_phrase('amount') ?></th>    
        <th class="single-action"><?php get_phrase('manage') ?></th>
        </thead>   
        
        <tbody>
        <?php foreach($expense_list as $expense){ ?>
        <tr>
        <td><?php echo $expense->trans_date ?></td> 
        <td><?php echo $expense->member_name ?></td>
        <td><?php echo $expense->p_method ?></td>
        <td><?php echo $expense->ref ?></td>
        <td><?php echo $expense->note ?></td>
        <td><?php echo $expense->amount ?></td>    
        <td><a class="mybtn btn-info btn-xs expense-manage-btn" 
		href="<?php echo site_url('Admin/editTransaction/'.$expense->trans_id) ?>" data-toggle="tooltip" 
        title="Click For Edit"><?php get_phrase('manage') ?></a></td> 
        </tr>
        <?php } ?> 
               
         </tbody>
        </table>
    </div>
    <!--End Panel Body-->
</div>
<!--End Panel-->    
    
</div>


</div><!--End Inner container-->
</div><!--End Row-->
</div><!--End Main-content DIV-->
</section><!--End Main-content Section-->


<script type="text/javascript">
$(document).ready(function() {
$(".manage-client").niceScroll({
cursorwidth: "8px",cursorcolor:"#7f8c8d"
});

$("body").tooltip({ selector: '[data-toggle=tooltip]' });

//data table
$("#manage-expense").DataTable({aaSorting : [[0, 'desc']]});
$("#repeat-income-table").DataTable();
$(".dataTables_length select").addClass("show_entries");

$(document).on('click','.expense-manage-btn',function(){

var link=$(this).attr("href"); 
$.ajax({
method : "POST",
url : link,
beforeSend : function(){
$(".block-ui").css('display','block'); 
},success : function(data){ 
//var link = location.pathname.replace(/^.*[\\\/]/, ''); //get filename only  
history.pushState(null, null,link);  
$('.asyn-div').load(link+'/asyn',function() {
$(".block-ui").css('display','none');     
});     
   
}
});

return false;
});

});

</script>

