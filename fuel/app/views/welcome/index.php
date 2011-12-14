<?php
Lang::load('howler');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo Asset::css(array('howler.css', 'jplayer.blue.monday.css')) ?>
	<title><?php echo Lang::get('application_title') ?></title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<?php echo Asset::js(array('jquery.ba-bbq.min.js', 'jquery.tablesorter.min.js', 'jquery.jplayer.min.js', 'player.js', 'howler.js')) ?>
</head>
<body>

<div id='marquee'><?php echo Lang::get('application_title') ?></div>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div class="jp-audio">
	<div class="jp-type-playlist">
		<div id="jp_interface_1" class="jp-interface">
			<ul class="jp-controls">
				<li><a href="#" class="jp-play" tabindex="1">play</a></li>
				<li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
				<li><a href="#" class="jp-stop" tabindex="1">stop</a></li>
				<li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
				<li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
				<li><a href="#" class="jp-previous" tabindex="1">previous</a></li>
				<li><a href="#" class="jp-next" tabindex="1">next</a></li>
			</ul>
			<div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			</div>
			<div class="jp-volume-bar">
				<div class="jp-volume-bar-value"></div>
			</div>
			<div class="jp-current-time"></div>
			<div class="jp-duration"></div>
		</div>
	</div>
</div>

<div id='search'></div>

<div id='playlists'>
	<div class='header'><?php echo Lang::get('play_queue') ?></div>
	<div id='playlist-list'></div>
</div>

<div id='selectors'>
	<div id='artist-selector'>
		<div class='header'><?php echo Lang::get('artists') ?> <a title="<?php echo Lang::get('refresh_artists'); ?>" onclick="howler.listBy('artist', '#artists-list')" class='refresh'
			><?php echo Asset::img('arrow_refresh_small.png', array('alt' => Lang::get('refresh_artists'))); ?></a></div>
		<div id='artist-list'><?php echo Asset::img('wait30trans.gif'); ?></div>
		</div>
	<div id='album-selector'>
		<div class='header'><?php echo Lang::get('albums') ?> <a title="<?php echo Lang::get('refresh_albums'); ?>" onclick="howler.listBy('album', '#albums-list')" class='refresh'
			><?php echo Asset::img('arrow_refresh_small.png', array('alt' => Lang::get('refresh_albums'))); ?></a></div>
		<div id='album-list'><?php echo Asset::img('wait30trans.gif'); ?></div>
	</div>
	<div class='clear'></div>
</div>

<div id='collection'></div>

<script type="text/javascript">
$(document).ready(function() {
	$("#jquery_jplayer_1").jPlayer({
		"swfPath": "assets/js",
		"ready": function() {howler.player.init(); howler.init()},
		errorAlerts: false,
		warningAlerts: false
	})
	howler.list('artist');
	howler.list('album');
})
</script>
</body>
</html>
