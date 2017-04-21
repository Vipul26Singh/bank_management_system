
<!--Statt Main Content-->
<section>
	<div class="main-content">
		<div class="row">
			<div class="inner-contatier">    
				<div class="col-md-12 col-lg-12 col-sm-12 content-title"><h4><?php get_phrase('share_management') ?></h4></div>
				<div class="col-md-12 col-lg-12 col-sm-12">
					<!--Start Panel-->
					<div class="panel panel-default">
						<!-- Default panel contents -->

						<div class="panel-heading"><?php get_phrase('manage_share') ?> <div class="add-button">
							</div><br><br>
						</div>

						<div class="panel-body manage-client">
							<table class="table table-striped table-bordered table-condensed">
								<th><?php get_phrase('member_id') ?></th>
								<th><?php get_phrase('member_name') ?></th>
								<th><?php get_phrase('mobile_number') ?></th>
								<th><?php get_phrase('birth_date') ?></th>
								<th><?php get_phrase('share') ?></th>
								<th class="action"><?php get_phrase('action') ?></th>

								<?php if(!empty($member_detail)){foreach ($member_detail as $member) { ?>
										
								<tr>
									<td><?php echo $member['member_id'] ?></td>
									<td><?php echo $member['member_name'] ?></td>
									<td><?php echo $member['mobile_no'] ?></td>
									<td><?php echo $member['birth_date'] ?></td>
									<td><?php echo $member['share'] ?></td>
									
									<td><a class="mybtn btn-info btn-xs account-edit-btn" href="<?php echo site_url('Admin/updateShare/view/'.$member['member_id']) ?>"><i class="fa fa-pencil-square-o"></i> <?php get_phrase('edit') ?></a>
</td>  

								</tr>
								<?php }} ?>    

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

