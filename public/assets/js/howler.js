// Place your application-specific JavaScript functions and classes here
var howler = howler || {}

/**
 * Initialize anything needed for this script. howler.init is called by the swf
 * player when it loads.
 */
howler.init = function() {
    $(window).bind('hashchange', howler.hashchanges);
    // trigger an empty event to kick things off otherwise we can end up with dead clicks
    $(window).trigger('hashchange');

    howler.setMaxHeights();
    $(window).resize(howler.setMaxHeights);
}

howler.setMaxHeights = function() {
    var winHeight = $(window).height();

    var maxHeights = ['#playlists', '#collection'];
    for (maxer in maxHeights) {
    	var maxer$ = $(maxHeights[maxer])
    	if (maxer$.offset()) {
    		var top = maxer$.offset().top
    		maxer$.height(winHeight - top - 3);
    	}
    }
}

/**
 * Handle changes in the URL hash
 */
howler.hashchanges = function() {
	var type = $.bbq.getState('type');
	var play = $.bbq.getState('play');

	if (type) {
		howler.listBy(type);
    } else if (play) {
        howler.player.play(play);
	} else {
		var album = $.bbq.getState('album');
		var artist = $.bbq.getState('artist');

		var options = {};
		var type = null;
		if (artist) {
			type = 'artist';
			options['artist'] = artist;
		}
		if (album) {
			type = 'album';
			options['album'] = album;
		}
        howler.findBy(type, options);
	}
}

/**
 * Find entries by type.
 */
howler.findBy = function(type, options) {
	if (type) {
	    $.get('entries/find/' + type, options, function(data) {
	        $('#collection').html(data);
	        $("#entries").tablesorter();
	    })
	}
}

/**
 * List entries by type.
 */
howler.listBy = function(type) {
	if (type) {
		$.get('entries/list/' + type, function(data) {
			$('#' + type + '-list').html(data);
		})
	}
}
