$(function() {
	$('.datepicker').datepicker({
			todayBtn: "linked",
			language: "de",
			autoclose: true,
			todayHighlight: true
		});
		
		$('#timepicker1').timepicker({
			showMeridian: false,
			minuteStep: 15	
		});
});