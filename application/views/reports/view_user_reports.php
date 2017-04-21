<!--Statt Main Content-->
<section>
<div class="main-content">
<div class="row">
<div class="inner-contatier">    
<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4> Report Viewer</h4></div>
<div class="col-md-12 col-lg-12 col-sm-12">
<!--Start Panel-->
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Fixed Deposite Report</div>
    <div class="panel-body">



<div class="Report-Toolbox col-md-6 col-lg-6 col-sm-6 col-md-offset-6 col-lg-offset-6 col-sm-offset-6">
<button type="button" class="btn btn-primary print-btn"><i class="fa fa-print"></i> Print</button>
<button type="button" class="btn btn-info pdf-btn"><i class="fa fa-file-pdf-o"></i> PDF Export</button>
</div>
<div id="Report-Table" class="col-md-12 col-lg-12 col-sm-12" style="overflow-y:scroll">
<div class="preloader"><img src="<?php echo base_url() ?>theme/images/ring.gif"></div>
<div class="report-heading">
 <h4>User Last 10 Transactions</h4>
 <p></p>
</div>
<div id="Table-div">
<table class="table table-bordered">
<thead>
<th>MemberId</th><th>Transaction Date</th>
<th>Transaction Type</th><th>Drawn</th><th>Credit</th><th>Balance</th>
 <tbody>
<?php foreach ($reportData as $report) { 
        ?>
        
        <tr>
        <td><?php echo $report->member_id ?></td>
        <td><?php echo $report->trans_date ?></td>
        <td><?php echo $report->type ?></td>
        <td><?php echo $report->dr ?></td>
        <td><?php echo $report->cr ?></td>
        <td><?php echo $report->bal ?></td>
        
       
        </tr>
       
        <?php 
          } ?>
 </tbody>
</table>
</div>

</div> 
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
$("#from-date, #to-date").datepicker(); 


$('#transfer-report').on('submit',function(){
var link=$(this).attr("action");
if($("#from-date").val()!="" && $("#to-date").val()!=""){
//query data
$.ajax({
method : "POST",    
url : link,
data : $(this).serialize(),
beforeSend : function(){
$(".preloader").css("display","block");
},success : function(data){
$(".preloader").css("display","none"); 
if(data!="false"){
$("#Report-Table tbody").html(data);
$(".report-heading p").html("Date From "+$("#from-date").val()+" To "+$("#to-date").val());
}else{
$("#Report-Table tbody").html("");
$(".report-heading p").html("Date From "+$("#from-date").val()+" To "+$("#to-date").val());    
swal("Alert","Sorry, No Data Found !", "info");    
}
}

});
}else{
swal("Alert","Please Select Date Range.", "info");      
}

return false;
});


});

 function Print(data) 
    {
        var w = (screen.width);
        var h = (screen.height);
        var mywindow = window.open('', 'Print-Report', 'width='+w+',height='+h);
        mywindow.document.write('<html><head><title>Print-Report</title>');
        mywindow.document.write('<link href="<?php echo base_url() ?>/theme/css/bootstrap.css" rel="stylesheet">');
        mywindow.document.write('<link href="<?php echo base_url() ?>/theme/css/my-style.css" rel="stylesheet">');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }


</script>

