<?php Lang::load('howler'); ?>
<table id="entries" class="tablesorter">
	<thead>
		<tr>
			<th class="track"><?php echo Lang::get('track'); ?></th>
			<th class="artist"><?php echo Lang::get('artist'); ?></th>
			<th class="album"><?php echo Lang::get('album'); ?></th>
			<th class="title"><?php echo Lang::get('title'); ?></th>
			<th class="title"><?php echo Lang::get('year'); ?></th>
			<th class="header">&nbsp;</th>
		</tr>
	</thead>
	<?php if ($entries) { ?>
	<tbody>
		<?php
		$rows = array('row1', 'row2');
		$cycle = 1;
		foreach ($entries as $entry) {
			$cycle = abs($cycle - 1);
		?>
			<tr id="<?php echo $entry['id']; ?>" class="entry <?php echo $rows[$cycle]; ?>">
				<td class="track"><?php echo $entry['track']; ?></td>

				<td class="artist"><a title="<?php echo Lang::get('find_by', array('type' => 'artist', 'artist' => $entry['artist'])); ?>"
					href="#artist=<?php echo urlencode($entry['artist']); ?>"><?php echo $entry['artist']; ?></a></td>

				<td class="album"><a title="<?php echo Lang::get('find_by', array('type' => 'album', 'album' => $entry['album'])); ?>"
					href="#album=<?php echo urlencode($entry['album']); ?>"><?php echo $entry['album']; ?></a></td>

				<td class="title"><a title="<?php echo Lang::get('play_by_title', array('title' => $entry['title'])); ?>"
					href="#play=<?php echo urlencode($entry['id']); ?>" class="play"><?php echo $entry['title']; ?></a></td>
				<td class="year"><?php echo $entry['year']; ?></td>
				<td class="actions"><?php echo Asset::img('add.png', array('alt' => Lang::get('add_playlist'))); ?></td>
			</tr>
		<?php
		}
		?>
	</tbody>
	<?php } ?>
</table>
