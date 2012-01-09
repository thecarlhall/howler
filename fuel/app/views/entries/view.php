<?php
Lang::load('howler');
?>
<span class='title'><?php echo $entry->title ?></span> 
<?php echo Lang::get('by') ?> 
<a title="<?php echo Lang::get('find_by', array('type' => 'artist', 'name' => $entry->artist)) ?>"
	href="#artist=<?php echo $entry->artist ?>"
	><span class='artist'><?php echo $entry->artist ?></span></a> 
<?php echo Lang::get('from') ?> 
<span class='album'><?php echo $entry->album ?></span> 
<a title="<?php echo Lang::get('find_by', array('type' => 'album', 'name' => $entry->album)) ?>"
	href="#album=<?php echo $entry->album ?>"
	><span class='album'><?php echo $entry->album ?></span></a> 