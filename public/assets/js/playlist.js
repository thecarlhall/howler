/* global $ */
var howler = howler || {};

howler.playlist._extractId = function(str) {
	var id = false;
	if (str) {
		id = str.substring(str.lastIndexOf('-') + 1);
	}
	return id;
}

/**
 * Add an item to the current loaded playlist
 *
 * @param item The ID of the item to add to the playlist.
 */
howler.playlist.addItem = function(id) {
	var url = '/playlists/add/entry/' + id;
	$.get(url, function(data) {
		$('#playlist .items').append(data);
	});
}

/**
 * Add all items associated to a parent ID.
 * 
 * @param parentId The parent ID to load all children of.
 */
howler.playlist.addParent = function(parentId) {
	var url = '/playlists/add/parent/' + parentId;
	$.get(url, function(data) {
		$('#playlist .items').append(data);
	});
}

/**
 * Clear all items from the current playlist. Does not affect the state of
 * any saved playlists.
 */
howler.playlist.clear = function() {
	$('#playlist .items').empty();
}

/**
 * Delete a saved playlist.
 */
howler.playlist.deletePlaylist = function(id) {
	if (id && id != '_new') {
		if (confirm('Are you sure you want to delete this playlist?')) {
			var url = '/playlists/' + id;
			$.ajax({
				type: 'DELETE',
				url: url,
				success: function(data, textStatus) {
				Playlist.loadPlaylists();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					alert('Unable to delete playlist [' + textStatus + ']');
				}
			});
		}
	}
}

howler.playlist.generate = function() {
	var count = 0;
	while (count != null && count <= 0) {
		count = prompt('How many entries would you like in\nyour generated playlist? [limit 1000]');
		if (count != null && (count <= 0 || count > 1000 || isNaN(count))) {
			alert('Please enter a number between 1 and 1000');
			count = -1;
		}
	}

	if (!isNaN(count) && count > 0) {
		var url = '/playlists/generate/' + count;
		$('#playlist .items').load(url, function() {
			$(this).sortable({
				axis: 'y',
				opacity: .75
			});
		});
	}
}

/**
 * Highlight an item in the current playlist using the ID of the item.
 */
howler.playlist.highlight = function(id) {
	// clear current highlighted item
	$('.now-playing .controls .play').attr('src', 'images/control_play_blue.png');
	$('.now-playing').removeClass('now-playing');

	if (id) {
		// highlight current song
		nowPlaying = $('#playlist-item-' + id).addClass('now-playing');

		// calculate top position and scroll to it
		var playlistTop = $('#playlist').position()['top'];
		var nowPlayingTop = nowPlaying.position()['top'];
		var topDiff = nowPlayingTop - playlistTop;
		var scrollTop = $('#playlist').scrollTop();
		$('.controls .play', nowPlaying).attr('src', 'images/control_pause_blue.png');

		$('#playlist').scrollTop(scrollTop + topDiff);
	}
}

howler.playlist.highlightBlur function() {
	$('.now-playing .controls .play').attr('src', 'images/control_play_blue.png');
}

howler.playlist.highlightFocus = function() {
	$('.now-playing .controls .play').attr('src', 'images/control_pause_blue.png');
},

/**
 * Initialization of the playlist
 */
howler.playlist.init = function() {
	Playlist.loadPlaylists();
}

/**
 * Load a saved playlist.
 * 
 * @param id The ID of the playlist to load.
 */
howler.playlist.loadPlaylist = function(id) {
	if (id) {
		var url = '/playlists/' + id;
		$('#playlist .items').load(url, function() {
			$(this).sortable({
				axis: 'y',
				opacity: .75
			});
			Playlist.toggleSavedView();
		});
	} else {
		alert('No playlist to load.');
	}
}

/**
 * Load the list of all playlists available to the user.
 */
howler.playlist.loadPlaylists = function() {
	$('#saved-playlists .list').load('/playlists');
//			$('#saved-playlists .list').resizable();
}

/**
 * Get the ID of the next item in the playlist that should be played. Will
 * select a random ID, if the random checkbox is ticked.
 * 
 * @param ignoreRepeat(optional) Whether to ignore a repeat state of
 *        'SONG'.
 */
howler.playlist.nextId = function(ignoreRepeat) {
	var nextId = false;
	var currentPlayingId = Player.currentPlayingId();
	if (currentPlayingId) {
		if (!ignoreRepeat && Playlist.repeat() == 'SONG') {
			nextId = currentPlayingId;
		} else if (Playlist.random()) {
			nextId = Playlist.randomId();
		} else {
			// get the ID of the item after the current playing one
			var nextItem = $('#playlist-item-' + currentPlayingId).next();
			var id = nextItem.attr('id');
			if (id) {
				// trim the item ID to just the data ID
				nextId = _extractId(id);
			} else if (Playlist.repeat() != 'NONE') {
				// if allowed to repeat the list, grab the first item
				id = $('#playlist .items li:first').attr('id');
				if (id) {
					nextId = _extractId(id);
				}
			}
		}
	} else {
		var id = $('#playlist .items li:first').attr('id');
		if (id) {
			nextId = _extractId(id);
		}
	}
	return nextId;
}

/**
 * Get the ID of the previous item in the playlist that should be played.
 * Will not select a random ID, if the random checkbox is ticked.
 * 
 * @param overrideRepeat(optional) Whether to override a repeat state of
 *        'SONG'.
 */
howler.playlist.prevId = function(ignoreRepeat) {
	var currentPlayingId = Player.currentPlayingId();
	var prevId = false;

	if (currentPlayingId) {
		if (!ignoreRepeat && Playlist.repeat() == 'SONG') {
			prevId = currentPlayingId;
		} else {
			var prevItem = $('#playlist-item-' + currentPlayingId).prev();
			var id = prevItem.attr('id');
			if (id) {
				prevId = _extractId(id);
			} else if (Playlist.repeat() != 'NONE') {
				var id = $('#playlist .items li:last').attr('id');
				if (id) {
					prevId = _extractId(id);
				}
			}
		}
	} else {
		// TODO if history is available, go back through it
		var id = $('#playlist .items li:last').attr('id');
		if (id) {
			prevId = _extractId(id);
		}
	}
	return prevId;
}

/**
 * Tells if the play order should be random, if state is not provided.
 * Sets whether the play order should be random, if state is provided.
 *
 * @returns true if play should be random
 *          false otherwise
 */
howler.playlist.random = function(state) {
	var rand = $('#random');
	if (state != null) {
		rand.attr('checked', state);
	} else {
		return rand.attr('checked');
	}
}

/**
 * Get the ID of a random item in the current playlist.
 * 
 * @return A randomly selected playlist item's ID.
 */
howler.playlist.randomId = function() {
	var playlist = $('#playlist .items li');
	var size = playlist.size();
	var pos = Math.floor(Math.random() * size);
	var id = $('#playlist .items li:eq(' + pos + ')').attr('id');
	var nextId = _extractId(id);
	return nextId;
}

/**
 * Remove an item from the current playlist. The item is selected by matching
 * to the provided ID.
 * 
 * @param id The ID of the item to remove from the playlist.
 */
howler.playlist.removeItem = function(id) {
	$('#playlist-item-' + id).remove();
}

/**
 * Gets the repeat state, if state is not provided.
 * 
 * Sets the repeat state, if state is provided.
 * Expected values: NONE, SONG, LIST
 */
howler.playlist.repeat = function(state) {
	var menu = $('#repeat-menu');
	if (state) {
		menu.val(state.toUpperCase());
	} else {
		return menu.val();
	}
}

/**
 * Saves the current playlist.
 */
howler.playlist.savePlaylist = function(name) {
	if (!name || name == '_new') {
		name = '';
		while (name == '') {
			name = prompt("Please provide a name for this playlist.");
		}
	}
	if (name) {
		ids = [];
		$('.playlist-item').each(function (idx) {
				var id = _extractId(this.id);
				ids.push(id);
			}
		);

		var url = '/playlists/save/' + name;
		var playlist = ids.join(',');

		$.ajax({
			type: 'POST',
			url: url,
			data: {'playlist': playlist},
			success: function() {
				Playlist.loadPlaylists();
			},
			error: function() {
				alert('An error occurred saving the playlist.  Please try again later.');
			}
		});
	}
}

/**
 * Show/hide the saved playlists area based on the current view state of the
 * area.
 */
howler.playlist.toggleSavedView = function() {
	var anchor = $('#saved-playlists-actions a');
	var img = $('img', anchor);
	var savedPlaylists = $('#saved-playlists');
	if (anchor.hasClass('hide-button')) {
		img.attr('src', 'images/bullet_arrow_down.png');
		savedPlaylists.slideUp('fast');
		anchor.removeClass('hide-button').addClass('show-button');
	} else if (anchor.hasClass('show-button')) {
		img.attr('src', 'images/bullet_arrow_up.png');
		savedPlaylists.slideDown('fast');
		anchor.removeClass('show-button').addClass('hide-button');
	}
}

$(document).ready(function() {
	Playlist.init();
});
