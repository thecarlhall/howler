<?php
Lang::load('howler');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo Lang::get('application_title') ?></title>
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
	<?php echo Form::input('dir', '/srv/music'); ?>
	<?php echo Form::submit(); ?>
	<?php echo Form::close(); ?>
</html>
