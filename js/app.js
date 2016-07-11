$(document).foundation();

$('.openInfo').click(function () {
	$('#ibTime').text($(this).find('.ibTime').text());
	$('#ibPee').text('Virtsa: '+$(this).find('.ibPee').text());
	$('#ibPoo').text('Kakka: '+$(this).find('.ibPoo').text());
	$('#ibBreast').text('Imetys: '+$(this).find('.ibBreast').text());
	$('#ibBottleBreast').text('Pullo rinta: '+$(this).find('.ibBottleBreast').text());
	$('#ibBottleSubstitute').text('Pullo korvike: '+$(this).find('.ibBottleSubstitute').text());
	$('#ibBottleOther').text('Pullo muu: '+$(this).find('.ibBottleOther').text());
	$('#ibSumIn').html('<b>In: '+$(this).find('.ibSumIn').text()+'</b>');
	$('#ibSumOut').html('<b>Out: '+$(this).find('.ibSumOut').text()+'</b>');
	$('#ibDaySum').html('<b>Päiväsumma: '+$(this).find('.ibDaySum').text()+'</b>');
	$('#ibAddInfo').text($(this).find('.ibAddInfo').text());
	$('#ibInfo').text($(this).find('.ibInfo').text());
	$('#ibAdditions').html($(this).find('.ibAdditions').html());
	$('#urlEdit').attr('href', $('#urlEdit').attr('href')+$(this).attr('id'));
	$('#urlDelete').attr('href', $('#urlDelete').attr('href')+$(this).attr('id'));
	$('#infoBox').foundation('open');
});