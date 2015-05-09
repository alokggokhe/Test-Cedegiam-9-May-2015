$(document).ready(function(){
	$('span[title]').tooltip({placement:'top'});
});
function cancelSchedule(schdule_id) {
	$('.alert-message').html('You have already cancelled this session');
	$('#popupCommonAlert').modal('show');
	return false;
}
