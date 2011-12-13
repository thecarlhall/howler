/* global $ */

/**
 * The player object that contains all controls, trackers and playlist functionality.
 */
var howler = howler || {};
howler.player = howler.player || {};
howler.player.currentId = null;
howler.player.state = null;

/**
 * Initialization function for the player
 */
howler.player.init = function() {
    // attach events to the player buttons
    $('.jp-play').click(function() {howler.player.play(); return false;});
    $('.jp-pause').click(function() {howler.player.play(); return false;});
    $('.jp-previous').click(function() {howler.player.previous(); return false;});
    $('.jp-next').click(function() {howler.player.next(); return false;});

    $('#jquery_jplayer_1')
        .bind($.jPlayer.event.play, function() {howler.player.state = 'playing';})
        .bind($.jPlayer.event.pause, function() {howler.player.state = 'paused';})
        .bind($.jPlayer.event.ended, howler.player.next);
}

/**
 * Add an entry to the playlist.
 */
howler.player.add = function(id, title) {
    var imgLink$ = $('.' + id + ' .play').clone();
    var li = $('<li>', {
        'class': id
    }).append(imgLink$).append(title);
    $('#jplayer_playlist ul').append(li);
}

/**
 * Play the next entry.
 */
howler.player.next = function() {
    var nextId = $('#' + howler.player.currentId).next().attr('id');

    if (!nextId) {
        nextId = $('#entries .entry:first-child').attr('id');
    }

    howler.player.play(nextId);
}

/**
 * Play a specific entry.
 */
howler.player.play = function(id) {
    var player$ = $('#jquery_jplayer_1');

    if (!id || id == howler.player.currentId) {
        // if selected entry is playing, just toggle play/pause
        if (howler.player.state === 'playing') {
            player$.jPlayer('pause');
        } else {
            player$.jPlayer('play');
        }
    } else {
        // unhighlight current playing entry
        $('.now-playing').removeClass('now-playing');

        // set the marquee title to the selected entry title
        $.get('entries/view/' + id, function(data) {
        	$('#marquee').html(data);
        });

        // highlight the selected entry
        var entry$ = $('#' + id);
        entry$.addClass('now-playing');

        // play the music!
        player$.jPlayer('setMedia', {mp3: 'entries/stream/' + id}).jPlayer('play');

        // track the current ID
        howler.player.currentId = id;
    }
}

/**
 * Play the previous entry.
 */
howler.player.previous = function() {
    var prevId = $('#' + howler.player.currentId).prev().attr('id');

    if (!prevId) {
        prevId = $('#entries .entry:last-child').attr('id');
    }

    howler.player.play(prevId);
}
