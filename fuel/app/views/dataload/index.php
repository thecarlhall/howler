<?php
Lang::load('howler');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo Asset::css(array('howler.css')) ?>
	<title><?php echo Lang::get('application_title') ?></title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
</head>
<body>
	<p><?php echo Lang::get('dataload_title'); ?></p>
	<?php
	$path = APPPATH.'classes/getid3/getid3.php';
	if (file_exists($path)) {
	?>
	<p><?php echo Lang::get('getid3_found', array('path' => $path)); ?></p>
	<?php } else { ?>
	<p><?php echo Lang::get('getid3_notfound', array('path' => $path)); ?></p>
	<?php } ?>
	<?php echo Form::open(); ?>
	<?php echo Lang::get('dataload_dir') ?>: <?php echo Form::input('dir', '/srv/music'); ?></br>
	<?php echo Form::checkbox('update', '1'); ?> <?php echo Lang::get('dataload_update'); ?><br/>
	<?php echo Form::button('submit', 'Process directory', array('onclick' => 'howler.dataload.pollUntilDone()')); ?>
	<?php echo Form::close(); ?>
</html>
