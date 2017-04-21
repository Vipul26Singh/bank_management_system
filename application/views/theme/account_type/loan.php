
<div class="form-group">
    <label for="acc_name">Account Holder<span style="color:red">  *</span></label>
    <input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="loan_member_id" id="loan_member_id">
</div>


<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="loan_member_name" id="loan_member_name" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_age') ?></label>
    <input type="text" class="form-control" name="loan_member_age" id="loan_member_age" readonly="true">
</div>


<div id="loan_joint_account" hidden>
	<div class="form-group">
    		<label for="acc_name">Second Account Holder <span style="color:red">  *</span></label>
    		<input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="loan_member_id_2" id="loan_member_id_2">
	</div>

	<div class="form-group">
    		<label for="acc_name"><?php get_phrase('second_member_name') ?></label>
    		<input type="text" class="form-control" name="loan_member_name_2" id="loan_member_name_2"  readonly="true">
	</div>

	<div class="form-group">
                <label for="acc_name"><?php get_phrase('second_member_age') ?></label>
                <input type="text" class="form-control" name="loan_member_age_2" id="loan_member_age_2" readonly="true">
        </div>
</div>


<div class="form-group">
    <label for="acc_name">First Introducer Id<span style="color:red">  *</span></label>
    <input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="loan_introducer_id" id="loan_introducer_id">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('first_introducer_name') ?></label>
    <input type="text" class="form-control" name="loan_introducer_name" id="loan_introducer_name" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('first_introducer_share') ?></label>
    <input type="text" class="form-control" name="loan_introducer_share" id="loan_introducer_share" readonly="true">
</div>


<div class="form-group">
    <label for="acc_name">Second Introducer Id<span style="color:red">  *</span></label>
    <input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="loan_introducer_id_2" id="loan_introducer_id_2">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('second_introducer_name') ?></label>
    <input type="text" class="form-control" name="loan_introducer_name_2" id="loan_introducer_name_2" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('second_introducer_share') ?></label>
    <input type="text" class="form-control" name="loan_introducer_share_2" id="loan_introducer_share_2" readonly="true">
</div>


<div class="form-group">
        <label for="loan_category"><?php get_phrase('loan_type') ?><span style="color:red">  *</span></label>
                <select class="form-control" id='loan_category' name='loan_category'>
                    <option value=''>Select</option>
                        <?php
                                foreach($loan_category_detail as $category){


                        ?>

                        <option value="<?php echo $category['value'] ?>"><?php echo $category['name']?></option>
                                    <?php
                }

                        ?>
            </select>
</div>


<div class="form-group">
	<label for="loan_interest"><?php get_phrase('loan_interest') ?><span style="color:red">  *</span></label>
		<select class="form-control" id='loan_interest' name='loan_interest'>
                    <option value=''>Select</option>
			<?php
				foreach($interest_detail as $interest){


                        if($interest['status'] == 1 && $interest['html_id'] == 'loan'){
                        ?>

                        <option value='<?php echo json_encode(array("id"=>$interest["id"], "interest"=>$interest["interest"])) ?>'><?php echo $interest['name']?></option>
                                    <?php
                      }
                }

			?>
            </select>
</div>


<div class="form-group">
	<label for="balance"><?php get_phrase('loan_amount') ?><span style="color:red">  *</span></label>
	<input type="number" class="form-control" name="loan_amount" min="0" id="loan_amount" placeholder="Enter Amount">
</div>

<div class="form-group">
        <label for="balance"><?php get_phrase('tenure_in_month') ?><span style="color:red">  *</span></label>
        <input type="number" class="form-control" name="loan_tenure" min="0" id="loan_tenure" placeholder="Enter Duration in months">
</div>

<div class="form-group">
        <label for="balance"><?php get_phrase('remarks') ?></label>
        <input type="text" class="form-control" name="loan_remarks" id="loan_remarks" placeholder="Remarks if any">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('emi') ?></label>
    <input type="text" class="form-control" name="loan_emi" id="loan_emi" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('total_interest') ?></label>
    <input type="text" class="form-control" name="loan_total_interest" id="loan_total_interest" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('total_amount_payable') ?></label>
    <input type="text" class="form-control" name="loan_amount_payable" id="loan_amount_payable" readonly="true">
</div>


<div class="form-group">
        <label for="balance"><?php get_phrase('billing_date') ?><span style="color:red">  *</span></label>
        <input type="number" class="form-control" name="loan_billing_date" min="1" id="loan_billing_date" placeholder="billing date of each month">
</div>


<div class="form-group">
        <label for="balance"><?php get_phrase('pay_by_days') ?><span style="color:red">  *</span></label>
        <input type="number" class="form-control" name="loan_pay_by_days" min="0" id="loan_pay_by_days" placeholder="pay by days">
</div>

<div class="form-group">
	<label for="balance"><input type="checkbox" name="loan_auto_deduct" id="loan_auto_deduct" value="YES">&nbsp;<?php get_phrase('auto_deduct') ?></label>
</div>

<div id="loan_linked_div" hidden>
<div class="form-group" >
	<label for="loan_linked_account"><?php get_phrase('linked_account') ?><span style="color:red">  *</span></label>
	<input type="text" class="form-control" name="loan_linked_account" id="loan_linked_account">
</div>
</div>

