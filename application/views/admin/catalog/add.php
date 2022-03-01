<!-- Title area -->
<?php $this->load->view('admin/catalog/head'); ?>

<div class="wrapper">

	<!-- Form -->
	<form class="form" id="form" action="" method="post"">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?php echo public_url('admin/')?>images/icons/dark/add.png" class="titleIcon"/>
					<h6>Thêm mới danh mục</h6>
				</div>

				<div class="tab_container">
					<div id='tab1' class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft" for="sort_order">TT hiển thị:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo">
									<input name="sort_order" value="<?php echo set_value('sort_order')?>" id="sort_order" _autocheck="true" type="text"/>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('sort_order')?></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="name">Tên:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo">
									<input name="name" value="<?php echo set_value('name')?>" id="name" _autocheck="true" type="text"/>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('name')?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow">
							<label class="formLeft" for="password">Group:<span class="req">*</span></label>
							<div class="formRight">
								<span class="oneTwo">
									<select name="parent_id" id="parent_id" _autocheck="true">
										<option value="0">Danh mục cha</option>
										<?php foreach ($list as $row):?>
										<option value="<?php echo $row->id?>"><?php echo $row->name?></option>
										<?php endforeach;?>
									</select>
								</span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"><?php echo form_error('parent_id')?></div>
							</div>
							<div class="clear"></div>
						</div>

				</div><!-- End tab_container-->

				<div class="formSubmit">
					<input type="submit" value="Thêm mới" class="redB"/>
					<input type="reset" value="Hủy bỏ" class="basic"/>
				</div>
				<div class="clear"></div>
			</div>
		</fieldset>
	</form>
</div>
<div class="clear mt30"></div>
