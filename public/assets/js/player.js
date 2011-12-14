/* global $ */

/**
 * The player object that contains all controls, trackers and playlist functionality.
 */
var howler = howler || {};
howler.player = howler.player || {};
howler.player.id = '#jquery_jplayer_1';
howler.player.currentId = null;

/**
 * Initialization function for the player
 */
howler.player.init = function() {
    // attach events to the player buttons
    $('.jp-play').click(function() {howler.player.play();});
    $('.jp-pause').click(function() {howler.player.pause();});
    $('.jp-previous').click(function() {howler.player.previous();});
    $('.jp-next').click(function() {howler.player.next();});

    $(howler.player.id).bind($.jPlayer.event.ended, howler.player.next);
};

/**
 * Add an entry to the playlist.
 */
howler.player.add = function(id, title) {
    var imgLink$ = $('.' + id + ' .play').clone();
    var li = $('<li>', {
        'class': id
    }).append(imgLink$).append(title);
    $('#jplayer_playlist ul').append(li);
};

/**
 * Play the next entry.
 */
howler.player.next = function() {
    var nextId = $('#' + howler.player.currentId).next().attr('id');

    if (!nextId) {
        nextId = $('#entries .entry:first-child').attr('id');
    }

    howler.player.play(nextId);
};

/**
 * Play a specific entry.
 */
howler.player.play = function(id) {
    if (!id || id == howler.player.currentId) {
        $(howler.player.id).jPlayer('play');
    } else {
        // unhighlight current playing entry
        $('.now-playing').removeClass('now-playing');

        // set the marquee title to the selected entry title
        $.get(howler.url('entries/view/' + id), function(data) {
        	$('#marquee').html(data);
        });

        // highlight the selected entry
        $('#' + id).addClass('now-playing');

        // play the music!
        $(howler.player.id).jPlayer('setMedia', {mp3: howler.url('entries/stream/' + id)}).jPlayer('play');

        // track the current ID
        howler.player.currentId = id;
    }
};

howler.player.pause = function(id) {
    $(howler.player.id).jPlayer('pause');
};

/**
 * Play the previous entry.
 */
howler.player.previous = function() {
    var prevId = $('#' + howler.player.currentId).prev().attr('id');

    if (!prevId) {
        prevId = $('#entries .entry:last-child').attr('id');
    }

    howler.player.play(prevId);
};
