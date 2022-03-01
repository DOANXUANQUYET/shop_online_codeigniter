<!-- Title area -->
<?php $this->load->view('admin/admin/head'); ?>

<div class="wrapper">

	<!-- Form -->
	<form class="form" id="form" action="" method="post"">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?php echo public_url('admin/')?>images/icons/dark/add.png" class="titleIcon"/>
					<h6>Cập nhật admin</h6>
				</div>

				<div class="tab_container">
					<div id='tab1' class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft" for="username">User name:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo">
									<input name="username" value="<?php echo $info->username?>" id="username" _autocheck="true" type="text"/>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('username')?></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="name">Tên:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo">
									<input name="name" value="<?php echo $info->name?>" id="name" _autocheck="true" type="text"/>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('name')?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label class="formLeft" for="password">Password:</label>
							<div class="formRight">
								<span class="oneTwo">
									<input name="password" id="password" _autocheck="true" type="password"/>
									<p>Enter if you want to update the password</p>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('password')?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label class="formLeft" for="pass_conf">Confirm Password:</label>
							<div class="formRight">
								<span class="oneTwo">
									<input name="pass_conf" id="pass_conf" _autocheck="true" type="password"/>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('pass_conf')?></div>
							</div>
							<div class="clear"></div>
						</div>


				</div><!-- End tab_container-->

				<div class="formSubmit">
					<input type="submit" value="Cập nhật" class="redB"/>
					<input type="reset" value="Hủy bỏ" class="basic"/>
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</form>
</div>
<div class="clear mt30"></div>
