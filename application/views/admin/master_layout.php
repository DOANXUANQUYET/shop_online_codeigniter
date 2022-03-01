<html>
<head>
	<?php $this->load->view('admin/head'); ?>
</head>
<body>
<!-- Left side content -->
<div id="left_content">
	<?php $this->load->view('admin/left'); ?>
</div>

<!-- Right side -->
<div id="rightSide">

	<!-- Account panel top -->

	<?php $this->load->view('admin/header'); ?>

	<!-- Main content -->
	<?php $this->load->view($temp,$this->data); ?>

	<!-- Footer -->
	<div id="footer">
		<div class="wrapper">
			<?php $this->load->view('admin/footer'); ?>
		</div>
	</div>
</div>
<div class="clear"></div>
</body>
</html>
