/* global $ */
/**
 * Dataload object for managing calls to the dataload script.
 */
var howler = howler || {};
howler.dataload = howler.dataload || {};
howler.dataload.lastOuput = null;

howler.dataload.pollUntilDone = function() {
	var input = { 'dir': $('#form_dir').val(), 'max': 25, 'update': $('#form_update').attr('checked') };
	$.post('dataload', input, function(data) {
		$('#output').html($('#output').html() + data);

		processedPos = data.lastIndexOf('Processed ');

		dataNoSummary = data.substring(0, processedPos);
		if (dataNoSummary != howler.dataload.lastOutput) {
			howler.dataload.lastOutput = dataNoSummary;

			start = processedPos + 'Processed '.length;
			end = data.lastIndexOf(" entries");
			count = data.substring(start, end);

			if (parseInt(count) > 0) {
				setTimeout('howler.dataload.pollUntilDone()', 10);
			}
		} else {
			alert('Data looks the same as last time. Are we looping on something?');
			howler.dataload.lastOutput = null;
		}
	});
};
