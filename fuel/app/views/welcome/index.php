<?php
Lang::load('howler');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo Asset::css(array('howler.css', 'jplayer.blue.monday.css')) ?>
	<title><?php echo Lang::get('application_title') ?></title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<?php echo Asset::js(array('jquery.ba-bbq.min.js', 'jquery.tablesorter.min.js', 'jquery.jplayer.min.js', 'player.js', 'playlist.js', 'howler.js')) ?>
</head>
<body>

<div id='marquee'><?php echo Lang::get('application_title') ?></div>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id='jp_container_1' class="jp-audio">
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

<div id='playlists-container'>
	<div class='header'><?php echo Lang::get('play_queue') ?></div>
	<div id='playlist'></div>
</div>

<div id='selectors'>
	<div id='artist-selector'>
	<!-- howler.list('artist', '#artists-list') -->
		<div class='header'><?php echo Lang::get('artists') ?> <a title="<?php echo Lang::get('refresh_artists'); ?>" href='#type=artist' class='refresh'
			><?php echo Asset::img('arrow_refresh_small.png', array('alt' => Lang::get('refresh_artists'))); ?></a></div>
		<div id='artist-list'><?php echo Asset::img('wait30trans.gif'); ?></div>
		</div>
	<div id='album-selector'>
	<!-- onclick="howler.list('album', '#albums-list') -->
		<div class='header'><?php echo Lang::get('albums') ?> <a title="<?php echo Lang::get('refresh_albums'); ?>" href='#type=album' class='refresh'
			><?php echo Asset::img('arrow_refresh_small.png', array('alt' => Lang::get('refresh_albums'))); ?></a></div>
		<div id='album-list'><?php echo Asset::img('wait30trans.gif'); ?></div>
	</div>
	<div class='clear'></div>
</div>

<div id='collection'></div>

<script type="text/javascript">
$(document).ready(function() {
	$(howler.player.id).jPlayer({
		'swfPath': 'assets/js',
		'ready': function() {howler.player.init();howler.init();},
		'errorAlerts': false,
		'warningAlerts': false
	});
});
</script>
</body>
</html>
