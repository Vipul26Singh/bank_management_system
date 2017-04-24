
<div class="form-group">
    <label for="acc_name">Account Holder<span style="color:red">  *</span></label>
    <input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="yojna_member_id" id="yojna_member_id">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control"  name="yojna_member_name" id="yojna_member_name" readonly="true">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_age') ?></label>
    <input type="text" class="form-control" name="yojna_member_age" id="yojna_member_age"  readonly="true">
</div>



<div id="yojna_joint_account" hidden>
	<div class="form-group">
    		<label for="acc_name">Second Account Holder <span style="color:red">  *</span></label>
    		<input type="number" class="form-control" min="0" placeholder="Enter Member Id" name="yojna_member_id_2" id="yojna_member_id_2">
	</div>

	<div class="form-group">
    		<label for="acc_name"><?php get_phrase('second_member_name') ?></label>
    		<input type="text" class="form-control" name="yojna_member_name_2" id="yojna_member_name_2"  readonly="true">
	</div>

	<div class="form-group">
                <label for="acc_name"><?php get_phrase('second_member_age') ?></label>
                <input type="text" class="form-control" name="yojna_member_age_2" id="yojna_member_age_2"  readonly="true">
        </div>
</div>

<div class="form-group">
                    <label for="yojna_interest"><?php get_phrase('yojna_interest') ?><span style="color:red">  *</span></label>
			 <input type="string" class="form-control" name="yojna_account_balance" min="0" id="yojna_account_balance" placeholder="Enter Amount">

            </select>
</div>


<div class="form-group">
	<label for="deposit"><?php get_phrase('deposit_amount') ?><span style="color:red">  *</span></label>
	<input type="string" class="form-control" name="yojna_account_balance" min="0" id="yojna_account_balance" placeholder="Enter Amount">
</div>


<div class="form-group">
                    <label for="yojna_duration"><?php get_phrase('duration_in_days') ?><span style="color:red">  *</span></label>
                    <select class="form-control" id='yojna_duration' name='yojna_duration'>
			<input type="string" class="form-control" name="yojna_account_balance" min="0" id="yojna_account_balance" placeholder="Enter Days">
			
            </select>
</div>


<div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_date') ?></label>
    <input type="text" class="form-control" name="yojna_maturity_date" id="yojna_maturity_date" >
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('maturity_amount') ?></label>
    <input type="text" class="form-control" name="yojna_maturity_amount" id="yojna_maturity_amount" >
</div>




