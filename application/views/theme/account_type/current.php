
<div class="form-group">
    <label for="acc_name">Account Holder<span style="color:red">  *</span></label>
    <input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="current_member_id" id="current_member_id">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="current_member_name" id="current_member_name" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_age') ?></label>
    <input type="text" class="form-control" name="current_member_age" id="current_member_age" readonly="true">
</div>



<div id="current_joint_account" hidden>
	<div class="form-group">
    		<label for="acc_name">Second Account Holder <span style="color:red">  *</span></label>
    		<input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="current_member_id_2" id="current_member_id_2">
	</div>

	<div class="form-group">
    		<label for="acc_name"><?php get_phrase('second_member_name') ?></label>
    		<input type="text" class="form-control" name="current_member_name_2" id="current_member_name_2"  readonly="true">
	</div>

	<div class="form-group">
                <label for="acc_name"><?php get_phrase('second_member_age') ?></label>
                <input type="text" class="form-control" name="current_member_age_2" id="current_member_age_2"  readonly="true">
        </div>
</div>

                        <div class="form-group">
                    <label for="current_interest"><?php get_phrase('current_account_interest') ?><span style="color:red">  *</span></label>
                    <select class="form-control" id='current_interest' name='current_interest'>
                    <option value=''>Select</option>
			<?php
				foreach($interest_detail as $interest){


                        if($interest['status'] == 1 && $interest['html_id'] == 'current'){
                        ?>

                        <option value='<?php echo json_encode(array("id"=>$interest["id"], "interest"=>$interest["interest"])) ?>'><?php echo $interest['name']?></option>
                                    <?php
                      }
                }

			?>
            </select>
</div>


<div class="form-group">
	<label for="balance"><?php get_phrase('account_balance') ?><span style="color:red">  *</span></label>
	<input type="string" class="form-control" name="current_account_balance" min="0" id="current_account_balance" placeholder="Enter Amount">
</div>


