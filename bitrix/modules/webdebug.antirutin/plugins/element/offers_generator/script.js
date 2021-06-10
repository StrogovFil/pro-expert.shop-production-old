/* See additional vars in sources: \WD\Antirutin\Plugin::printJs() */

// Check fields on start
wdaOnStartHandler(id, function(id, div, title){
	let count = parseInt($('input[data-role="count"]', div).val());
	if(isNaN(count) || count <= 0){
		return $('input[data-role="error_no_count"]', div).val();
	}
	return true;
});
