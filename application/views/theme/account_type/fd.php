
<div class="form-group">
    <label for="acc_name">Account Holder<span style="color:red">  *</span></label>
    <input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="fd_member_id" id="fd_member_id">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control"  name="fd_member_name" id="fd_member_name" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_age') ?></label>
    <input type="text" class="form-control" name="fd_member_age" id="fd_member_age"  readonly="true">
</div>



<div id="fd_joint_account" hidden>
	<div class="form-group">
    		<label for="acc_name">Second Account Holder <span style="color:red">  *</span></label>
    		<input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="fd_member_id_2" id="fd_member_id_2">
	</div>

	<div class="form-group">
    		<label for="acc_name"><?php get_phrase('second_member_name') ?></label>
    		<input type="text" class="form-control" name="fd_member_name_2" id="fd_member_name_2"  readonly="true">
	</div>

	<div class="form-group">
                <label for="acc_name"><?php get_phrase('second_member_age') ?></label>
                <input type="text" class="form-control" name="fd_member_age_2" id="fd_member_age_2"  readonly="true">
        </div>
</div>

<div class="form-group">
                    <label for="fd_interest"><?php get_phrase('fd_interest') ?><span style="color:red">  *</span></label>
                    <select class="form-control" id='fd_interest' name='fd_interest'>
                    <option value=''>Select</option>
			<?php
				foreach($interest_detail as $interest){


                        if($interest['status'] == 1 && $interest['html_id'] == 'fd'){
                        ?>

                        <option value='<?php echo json_encode(array("id"=>$interest["id"], "interest"=>$interest["interest"])) ?>'><?php echo $interest['name']?></option>
                                    <?php
                      }
                }

			?>
            </select>
</div>


<div class="form-group">
	<label for="deposit"><?php get_phrase('deposit_amount') ?><span style="color:red">  *</span></label>
	<input type="string" class="form-control" name="fd_account_balance" min="0" id="fd_account_balance" placeholder="Enter Amount">
</div>


<div class="form-group">
                    <label for="fd_duration"><?php get_phrase('duration_in_month') ?><span style="color:red">  *</span></label>
                    <select class="form-control" id='fd_duration' name='fd_duration'>
                    <option value=''>Select</option>
                        <?php
                                foreach($fd_duration as $duration){
			?>
				<option value="<?php echo $duration['value']?>"><?php echo $duration['name']; ?></option>
			<?php		
				}
                        ?>
			
            </select>
</div>


<div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_date') ?></label>
    <input type="text" class="form-control" name="fd_maturity_date" id="fd_maturity_date" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_amount') ?></label>
    <input type="text" class="form-control" name="fd_maturity_amount" id="fd_maturity_amount" readonly="true">
</div>




