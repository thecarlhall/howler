<?php Lang::load('howler') ?>
<?php if ($entries) { ?>
	<ul class="entries">
		<?php
		$rows = array('row1', 'row2');
		$cycle = 1;
		foreach ($entries as $entry) {
			$cycle = abs($cycle - 1);
			$name = $entry[$type];
			$img_alt = $img_title = Lang::get('add_playlist');
		?>
			<li class="entry <?php echo $rows[$cycle] ?>">
				<a title="<?php echo Lang::get('find_by', array('type' => $type, 'name' => $name)) ?>"
					href="#<?php echo $type ?>=<?php echo urlencode($name) ?>"
					><?php echo $name ?> (<?php echo $entry['count'] ?>)</a>
					<span class="right"><?php echo Asset::img('add.png', array('alt' => $img_alt, 'title' => $img_title)) ?></span>
			</li>
		<?php } ?>
	</ul>
<?php } ?>
