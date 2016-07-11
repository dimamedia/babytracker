<?php
print "<h2>Asetukset</h2>";

if($_POST['save']) {
	unset($_POST['save']);
	$_POST['hiddenCharts'] = implode(",",$_POST['hiddenCharts']);
	
	$settingsFile = fopen(".settings", "w");
	$result = fwrite($settingsFile, serialize($_POST));
	fclose($settingsFile);
	
	
	if($result > 0) {
		print "<div class='success callout'>Asetukset tallennettu</div>";
	}
	else print "<div class='alert callout'>Virhe asetusten tallennuksessa</div>";
}
else {
	$chartsArray = array(	'weight'=>'Paino',
							'height'=>'Pituus',
							'breast'=>'Imetys',
							'breastmilk'=>'Rintamaito',
							'bottleSubstitute'=>'Korvikemaito',
							'bottleBreast'=>'Pullo rinta',
							'bottleOther'=>'Pullo muu',
							'in'=>'In',
							'out'=>'Out'
						);

	$const = get_defined_constants();
	$hiddenCharts = explode(',', HIDDENCHARTS);

	$chartsForm = '<div class="row"><div class="small-12 medium-6 columns">';
	$i = 0;
	foreach($chartsArray as $chart => $cName) {
		$i++;
		$checked = in_array($chart, $hiddenCharts) ? "checked" : null;
		$chartsForm .= <<< html
		<input type="checkbox" name="hiddenCharts[]" value="$chart" $checked> $cName<br />
html;
		if($i % 5 == 0) $chartsForm .= '</div><div class="small-12 medium-6 columns">';
	}
	$chartsForm .= '</div></div>';

	print <<< html
	<form method="post">
	<div class="row">
		<div class="small-12 medium-4 columns">
			<label>Nimi
				<input type="text" name="name" value="{$const['NAME']}">
			</label>
		</div>
		<div class="small-12 medium-4 columns">
			<label>Päiväsaldon nollausajankohta
				<input type="text" name="daySumResetTime" value="{$const['DAYSUMRESETTIME']}" placeholder="14:00">
			</label>
		</div>
		<div class="small-12 medium-4 columns">
			<label>Annettavat lisät pilkulla erotettuna
				<input type="text" name="additions" value="{$const['ADDITIONS']}" placeholder="NaCl,D,K">
			</label>
		</div>
	</div>
	<div class="row">
		<div class="small-12 columns">
			Piilota käyrät oletukseksi:<br />
			$chartsForm
		</div>
	</div>
	<br />
	<div class="row">
		<div class="small-12 columns">
			<input class="expanded button" type="submit" name="save" value="Tallenna">
		</div>
	</div>
	</form>
html;
}

?>