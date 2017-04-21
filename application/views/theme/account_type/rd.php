
<div class="form-group">
    <label for="acc_name">Account Holder<span style="color:red">  *</span></label>
    <input type="number" class="form-control text-readonly" min="0" placeholder="Enter Member Id" name="member_id" id="member_id">
</div>

<div class="form-group">
    <label for="acc_name"><?php get_phrase('member_name') ?></label>
    <input type="text" class="form-control" name="member_name" id="member_name" readonly="true">
</div>


<div id="joint_account" hidden>
	<div class="form-group">
    		<label for="acc_name">Second Account Holder <span style="color:red">  *</span></label>
    		<input type="number" class="form-control text-readonly" min="0" placeholder="Enter Member Id" name="member_id_2" id="member_id_2">
	</div>

	<div class="form-group">
    		<label for="acc_name"><?php get_phrase('second_member_name') ?></label>
    		<input type="text" class="form-control" name="second_member_name" id="second_member_name" readonly="true">
	</div>
</div>

<div class="form-group">
	<label for="balance"><?php get_phrase('account_balance') ?><span style="color:red">  *</span></label>
	<input type="string" class="form-control" name="account_balance" min="0" id="account_balance" placeholder="Enter Amount">
</div>


