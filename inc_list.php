<?php
	print "<h2>Listaus <small>näytetään viimeiset 10 päivää</small></h2>
	<small>Päiväsaldon nollaus klo ".DAYSUMRESETTIME.". Klikkaa riviä avataksesi lisätietoja.</small>";
$result = $babytracker->getList();
print <<< html
<div class="reveal" id="infoBox" data-reveal>
	<h2 id="ibTime"></h2>
	<div class="row">
		<div class="small-6 columns" id="ibPee"></div>
		<div class="small-6 columns" id="ibPoo"></div>
	</div>
	<div class="row">
		<div class="small-6 columns" id="ibBreast"></div>
		<div class="small-6 columns" id="ibBottleBreast"></div>
	</div>
	<div class="row">
		<div class="small-6 columns" id="ibBottleSubstitute"></div>
		<div class="small-6 columns" id="ibBottleOther"></div>
	</div>
	<div class="row">
		<div class="small-3 columns" id="ibSumIn"></div>
		<div class="small-3 columns" id="ibSumOut"></div>
		<div class="small-6 columns" id="ibDaySum"></div>
	</div>
	<div class="row">
		<div class="small-12 columns" id="ibAddInfo"></div>
		<div class="small-12 columns" id="ibInfo"></div>
		<div class="small-12 columns" id="ibAdditions"></div>
	</div>
	<br />
	<div class="row">
		<div class="small-8 columns"><a id="urlEdit" href="{$basePath}edit/" class="small button primary"><i class="fi-page-edit"></i> Muokkaa tietoja</a></div>
		<div class="small-4 columns text-right"><a id="urlDelete" href="{$basePath}delete/" class="small button alert"><i class="fi-trash"></i></a></div>
	</div>
  <button class="close-button" data-close aria-label="Close modal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
html;

	print <<< html
<div class="row listHeader">
	<div class="small-6 medium-2 columns">Aika</div>
	<div class="small-6 medium-1 columns show-for-large">Virtsa</div>
	<div class="small-6 medium-1 columns show-for-large">Kakka</div>
	<div class="small-6 medium-1 columns hide-for-small-only">Imetys</div>
	<div class="small-6 medium-1 columns hide-for-small-only">Pullo rinta</div>
	<div class="small-6 medium-1 columns hide-for-small-only">Pullo korvike</div>
	<div class="small-6 medium-1 columns hide-for-small-only">Pullo muu</div>
	<div class="small-1 columns show-for-small-only">In</div>
	<div class="small-1 columns hide-for-large">Out</div>
	<div class="small-1 medium-1 columns">Päiväsaldo</div>
</div>
html;


foreach($result as $row) {
	$addInfo = array();
	foreach($row as $key => $val) {
		if($key == 'additions' AND !empty($val)) {
			$addArr = explode(",",$row['additions']);
			$additions = null;
			foreach($addArr as $add) $additions .= "<span class=\"label\">$add</span>";
		}
		elseif($key == 'info' AND !empty($val)) $$key = $val;
		elseif($key == 'time') $$key = preg_replace('/\:00$/','',$val);
		elseif($key == 'weight' AND $val > 0) $addInfo[] = "Paino: {$val} g";
		elseif($key == 'height' AND $val > 0) $addInfo[] = "Pituus: {$val} cm";
		elseif($key == 'headCirc' AND $val > 0) $addInfo[] = "Pään ympäryys: {$val} cm";
		elseif($key == 'temperature' AND $val > 0) $addInfo[] = "Lämpötila: {$val} &deg;";
		else $$key = $val > 0 ? $val : null;
	}
	$addInfo = implode(", ", $addInfo);

	$currDay = date('d-m-Y', strtotime($time));
	$line = $currDay != $lastDay ? "border-top: solid 1px black;" : null;
	$lastDay = $currDay;

	$currentDST = date('Hi', strtotime($time));
	if(!empty($daySum) AND $currentDST <= str_replace(":","",DAYSUMRESETTIME) AND $lastDST > str_replace(":","",DAYSUMRESETTIME)) {
		$boldDsStart = '<b>';
		$boldDsEnd = '</b>';
		$lastDST = $currentDST;
	}
	elseif(!empty($daySum)) {
		$boldDsStart = null;
		$boldDsEnd = null;
		$lastDST = $currentDST;
	}

	$bg = $bg == '#eee' ? '#fff' : '#eee';
	print <<< html
<div class="row listData openInfo" id="$id" style="background-color: $bg; $line">
	<div class="small-6 medium-2 columns ibTime"><b><nobr>$time  <i class="fi-magnifying-glass"></i></nobr></b></div>
	<div class="medium-1 columns show-for-large ibPee">$pee</div>
	<div class="medium-1 columns show-for-large ibPoo">$poo</div>
	<div class="medium-1 columns hide-for-small-only ibBreast">$breast</div>
	<div class="medium-1 columns hide-for-small-only ibBottleBreast">$bottleBreast</div>
	<div class="medium-1 columns hide-for-small-only ibBottleSubstitute">$bottleSubstitute</div>
	<div class="medium-1 columns hide-for-small-only ibBottleOther">$bottleOther</div>
	<div class="small-1 columns show-for-small-only ibSumIn">$sumIn</div>
	<div class="small-1 columns hide-for-large ibSumOut">$sumOut</div>
	<div class="small-1 medium-1 columns ibDaySum">{$boldDsStart}$daySum{$boldDsEnd}</div>	
	<div class="small-3 medium-2 columns ibAdditions">$additions</div>
	<div class="medium-6 columns hide-for-small-only ibAddInfo">$addInfo</div>
	<div class="medium-6 columns hide-for-small-only ibInfo">$info</div>
</div>
html;
//	print_r($row);
}

?>
