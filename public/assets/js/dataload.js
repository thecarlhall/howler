/* global $ */
/**
 * Dataload object for managing calls to the dataload script.
 */
var howler = howler || {};
howler.dataload = howler.dataload || {};

howler.dataload.pollTillDone = function() {
	var done = false;
	while (!done) {
		$.post('dataload', function(data) {
			start = "Processed ".length();
			end = data.indexOf(" entries");
			count = data.substring(start, end);
			alert(count);
			done = true;
		});
	}
};
