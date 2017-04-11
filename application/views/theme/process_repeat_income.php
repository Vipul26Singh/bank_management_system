<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('heading_income') ?></h4></div>
<div class="col-md-12 col-lg-12 col-sm-12">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php get_phrase('panel_manage_income') ?> <div class="add-button">
    <a class="mybtn btn-default asyn-link" href="<?php echo site_url('Admin/repeatIncome') ?>"><?php get_phrase('add_repeat_income') ?></a>
    </div></div>
    <div class="panel-body">
        <table id="repeat-income-table" class="display responsive nowrap" cellspacing="0" width="100%">
        <thead>    
        <th><?php get_phrase('date') ?></th>
		<th><?php get_phrase('account') ?></th>
		<th><?php get_phrase('category') ?></th>
        <th><?php get_phrase('payer') ?></th>
		<th><?php get_phrase('method') ?></th>
		<th><?php get_phrase('reference') ?></th> 
        <th><?php get_phrase('note') ?></th>
		<th><?php get_phrase('amount') ?></th>    
        <th class="single-action"><?php get_phrase('status') ?></th>
        <th class="single-action"><?php get_phrase('manage') ?></th>
        </thead>

        <tbody>
        <?php foreach($repeat_income as $income) { ?>    
        <tr>
        <td class="date"><?php echo $income->date ?></td>
        <td><?php echo $income->account ?></td>
        <td><?php echo $income->category ?></td>
        <td><?php echo $income->payer ?></td>
        <td><?php echo $income->p_method ?></td>
        <td><?php echo $income->ref ?></td>
        <td class="title"><?php echo $income->description ?></td> 
        <td><?php echo $income->amount ?></td>    
        <td><span class="mybtn btn-danger btn-xs process-trans"><?php get_phrase('pending') ?></span></td> 
        <td><a class="mybtn btn-info btn-xs manage-btn" data-toggle="tooltip" 
        title="Click For Edit" href="<?php echo site_url('Admin/editRepeatTransaction/'.$income->trans_id) ?>"><?php get_phrase('manage') ?></a></td> 
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
</div> <!-- End Row-->
</div><!--End Main-content DIV-->
</section><!--End Main-content Section-->


<script type="text/javascript">
$(document).ready(function() {
$("body").tooltip({ selector: '[data-toggle=tooltip]' });   
$(".manage-client").niceScroll({
cursorwidth: "8px",cursorcolor:"#7f8c8d"
});

$("#repeat-income-table").DataTable();
$(".dataTables_length select").addClass("show_entries");


$(document).on('click','.manage-btn',function(){

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

