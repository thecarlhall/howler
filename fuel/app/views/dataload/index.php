<?php Lang::load('howler'); ?>
<p><?php echo Lang::get('dataload_title'); ?></p>
<?php echo Form::open(); ?>
<?php echo Form::input('dir', '/home/chall/Music'); ?>
<?php echo Form::submit(); ?>
<?php echo Form::close(); ?>
