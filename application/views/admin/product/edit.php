<!-- Title area -->
<?php $this->load->view('admin/product/head'); ?>

<!-- Main content js-->
<script type="text/javascript">
	(function ($) {
		$(document).ready(function () {
			var main = $('#form');

			// Tabs
			main.contentTabs();
		});
	})(jQuery);
</script>

<!-- Main content wrapper -->
<div class="wrapper">

	<!-- Form -->
	<form class="form" id="form" action="" method="post" enctype="multipart/form-data">
		<fieldset>
			<div class="widget">
				<div class="title">
					<img src="<?= public_url('admin/') ?>images/icons/dark/add.png" class="titleIcon"/>
					<h6>Thêm mới Sản phẩm</h6>
				</div>

				<ul class="tabs">
					<li><a href="#tab1">Thông tin chung</a></li>
					<li><a href="#tab2">SEO Onpage</a></li>
					<li><a href="#tab3">Bài viết</a></li>
				</ul>

				<div class="tab_container">
					<div id='tab1' class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
							<div class="formRight">
									<span class="oneTwo"><input value="<?=$info->name?>" name="name" id="param_name" _autocheck="true"
																type="text"/></span>
								<span name="name_autocheck" class="autocheck"></span>
								<div name="name_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Hình ảnh:<span class="req">*</span></label>
							<div class="formRight">
								<div class="left"><input type="file" id="image" name="image"></div>
								<div class="clear">
									<img src="<?=base_url('/upload/product/').$info->image_link?>" width="100" height="80">
								</div>
								<div name="image_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft">Ảnh kèm theo:</label>
							<div class="formRight">
								<div class="left"><input type="file" id="image_list" name="image_list[]" multiple>
								</div>
								<div class="clear">
									<?php
									if($image_list = json_decode($info->image_list)):
									foreach ($image_list as $row):
									?>
									<img src="<?=base_url('/upload/product/').$row?>" width="100" height="80" style="margin-left: 10px;">
									<?php endforeach;
									endif;?>
								</div>
								<div name="image_list_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<!-- Price -->
						<div class="formRow">
							<label class="formLeft" for="param_price">
								Giá :
								<span class="req">*</span>
							</label>
							<div class="formRight">
								<span class="oneTwo">
									<input value="<?=number_format($info->price)?>" name="price" style='width:100px' id="param_price" class="format_number" _autocheck="true"
										   type="text"/>
									<img class='tipS' title='Giá bán sử dụng để giao dịch' style='margin-bottom:-8px'
										 src='<?= public_url('admin/') ?>crown/images/icons/notifications/information.png'/>
								</span>
								<span name="price_autocheck" class="autocheck"></span>
								<div name="price_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<!-- Price -->
						<div class="formRow">
							<label class="formLeft" for="param_discount">
								Giảm giá (VNĐ)
								<span></span>:
							</label>
							<div class="formRight">
								<span>
									<input value="<?=number_format($info->discount)?>" name="discount" style='width:100px' id="param_discount" class="format_number" type="text"/>
									<img class='tipS' title='Số tiền giảm giá' style='margin-bottom:-8px'
										 src='<?= public_url('admin/') ?>crown/images/icons/notifications/information.png'/>
								</span>
								<span name="discount_autocheck" class="autocheck"></span>
								<div name="discount_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="param_cat">Thể loại:<span class="req">*</span></label>
							<div class="formRight">
								<select name="catalog_id" _autocheck="true" id='param_cat' class="left">
									<option value=""></option>
									<?php foreach ($catalogs as $row):?>
										<?php if(count($row->subs) > 1):?>
											<!-- kiem tra danh muc co danh muc con hay khong -->
											<optgroup label="<?=$row->name?>">
												<?php foreach ($row->subs as $sub_row):?>
													<option value="<?=$sub_row->id?>"
															<?php echo $sub_row->id ==  $info->catalog_id ? 'selected' : ''?>>
														<?=$sub_row->name?>
													</option>
												<?php endforeach;?>
											</optgroup>
										<?php else:?>
											<option value="<?=$row->id?>"
													<?php echo $row->id ==  $info->catalog_id ? 'selected' : ''?>>
												<?=$row->name?>
											</option>
										<?php endif;?>
									<?php endforeach;?>
								</select>
								<span name="cat_autocheck" class="autocheck"></span>
								<div name="cat_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<!-- warranty -->
						<div class="formRow">
							<label class="formLeft" for="param_warranty">
								Bảo hành :
							</label>
							<div class="formRight">
									<span class="oneFour"><input value="<?=$info->warranty?>" name="warranty" id="param_warranty"
																 type="text"/></span>
								<span name="warranty_autocheck" class="autocheck"></span>
								<div name="warranty_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="gifts">Tặng quà:</label>
							<div class="formRight">
									<span class="oneTwo"><textarea name="gifts" id="gifts" rows="4"
																   cols=""><?=$info->gifts?></textarea></span>
								<span name="sale_autocheck" class="autocheck"></span>
								<div name="sale_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>

					<div id='tab2' class="tab_content pd0">

						<div class="formRow">
							<label class="formLeft" for="param_site_title">Title:</label>
							<div class="formRight">
									<span class="oneTwo"><textarea name="site_title" id="param_site_title"
																   _autocheck="true" rows="4" cols=""><?=$info->site_title?></textarea></span>
								<span name="site_title_autocheck" class="autocheck"></span>
								<div name="site_title_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="param_meta_desc">Meta description:</label>
							<div class="formRight">
									<span class="oneTwo"><textarea name="meta_desc" id="param_meta_desc"
																   _autocheck="true" rows="4" cols=""><?=$info->meta_desc?></textarea></span>
								<span name="meta_desc_autocheck" class="autocheck"></span>
								<div name="meta_desc_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="formRow">
							<label class="formLeft" for="param_meta_key">Meta keywords:</label>
							<div class="formRight">
									<span class="oneTwo"><textarea name="meta_key" id="param_meta_key" _autocheck="true"
																   rows="4" cols=""><?=$info->meta_key?></textarea></span>
								<span name="meta_key_autocheck" class="autocheck"></span>
								<div name="meta_key_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
					</div>

					<div id='tab3' class="tab_content pd0">
						<div class="formRow">
							<label class="formLeft">Nội dung:</label>
							<div class="formRight">
								<textarea name="content" id="param_content" class="editor"><?=$info->content?></textarea>
								<div name="content_error" class="clear error"></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="formRow hide"></div>
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
