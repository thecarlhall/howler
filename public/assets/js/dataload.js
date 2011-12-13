/* global $ */
/**
 * Dataload object for managing calls to the dataload script.
 */
var howler = howler || {};
howler.dataload = howler.dataload || {};

howler.dataload.pollUntilDone = function() {
	var done = false;
	var input = { 'dir': $('#form_dir').val(), 'update': $('#form_update').attr('checked') };
	while (!done) {
		$.ajax({
			'url': 'dataload',
			'type': 'post',
			'data': input,
			'async': false,
			'success': function(data) {
				$('#output').html(data);
				start = "Processed ".length();
				end = data.indexOf(" entries");
				count = data.substring(start, end);
				alert(count);
				done = true;
			},
			'error': function(jqXHR, textStatus, errorThrown) {
				alert(data);
				done = true;
			}
		});
	}
};
