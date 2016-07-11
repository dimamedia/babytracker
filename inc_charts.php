<?php

print <<< html
<h2>Graafit</h2>
<small>
Rintamaito = Imetys + Pullo rinta<br />
In = Imetys + Pullo rinta + Korvikemaito + Pullo muu<br />
Out = Virtsa + Kakka
</small>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.min.js"></script>

<canvas id="myChart" style="width: 100%; height: 250px;"></canvas>
html;

$settings = "borderWidth: 2, pointRadius: 3, pointHoverRadius: 6";

$result = $babytracker->getChartList();

foreach($result as $date => $data) {
	$dates[] = "'$date'";
	$weights[] = $data['weight'];
	$heights[] = $data['height'];
	$breasts[] = $data['breast'];
	$bottleBreasts[] = $data['bottleBreast'];
	$bottleSubstitutes[] = $data['bottleSubstitute'];
	$bottleOthers[] = $data['bottleOther'];
	$breastMilks[] = $data['breastMilk'];
	$ins[] = $data['in'];
	$outs[] = $data['out'];
}

function rand_color () {
	$cmin = 50;
	$cmax = 250;
	return rand($cmin,$cmax).','.rand($cmin,$cmax).','.rand($cmin,$cmax);
}

$cWeight = rand_color();
$cHeight = rand_color();
$cBr = rand_color();
$cBBr = rand_color();
$cBSu = rand_color();
$cBOt = rand_color();
$cBMi = rand_color();
$cIn = rand_color();
$cOu = rand_color();

foreach(explode(",", HIDDENCHARTS) as $hChart) {
	$hChart .= 'Hidden';
	$$hChart = ', hidden: true';
}

$datasets['weght'] .= "{label: 'Paino', data: [".implode(",",$weights)."], $settings, pointBackgroundColor: \"rgba($cWeight,1)\", backgroundColor: \"rgba($cWeight,0.05)\", borderColor: \"rgba($cWeight,1)\" $weightHidden}";
$datasets['height'] .= "{label: 'Pituus', data: [".implode(",",$heights)."], $settings, pointBackgroundColor: \"rgba($cHeight,1)\", backgroundColor: \"rgba($cHeight,0.05)\", borderColor: \"rgba($cHeight,1)\" $heightHidden}";
$datasets['breast'] .= "{label: 'Imetys', data: [".implode(",",$breasts)."], $settings, pointBackgroundColor: \"rgba($cBr,1)\", backgroundColor: \"rgba($cBr,0.05)\", borderColor: \"rgba($cBr,1)\" $breastHidden}";
$datasets['breastMilk'] .= "{label: 'Rintamaito', data: [".implode(",",$breastMilks)."], $settings, pointBackgroundColor: \"rgba($cBMi,1)\", backgroundColor: \"rgba(0$cBMi,0.05)\", borderColor: \"rgba($cBMi,1)\" $breastMilkHidden}";
$datasets['bottleSubstitute'] .= "{label: 'Korvikemaito', data: [".implode(",",$bottleSubstitutes)."], $settings, pointBackgroundColor: \"rgba($cBSu,1)\", backgroundColor: \"rgba($cBSu,0.05)\", borderColor: \"rgba($cBSu,1)\" $bottleSubstituteHidden}";
$datasets['bottleBreast'] .= "{label: 'Pullo rinta', data: [".implode(",",$bottleBreasts)."], $settings, pointBackgroundColor: \"rgba($cBBr,1)\", backgroundColor: \"rgba($cBBr,0.05)\", borderColor: \"rgba($cBBr,1)\" $bottleBreastHidden}";
$datasets['bottleOther'] .= "{label: 'Pullo muu', data: [".implode(",",$bottleOthers)."], $settings, pointBackgroundColor: \"rgba($cBOt,1)\", backgroundColor: \"rgba(0$cBOt,0.05)\", borderColor: \"rgba($cBOt,1)\" $bottleOtherHidden}";
$datasets['in'] .= "{label: 'In', data: [".implode(",",$ins)."], $settings, pointBackgroundColor: \"rgba($cIn,1)\", backgroundColor: \"rgba($cIn,0.05)\", borderColor: \"rgba($cIn,1)\" $inHidden}";
$datasets['out'] .= "{label: 'Out', data: [".implode(",",$outs)."], $settings,  pointBackgroundColor: \"rgba($cOu,1)\", backgroundColor: \"rgba($cOu,0.05)\", borderColor: \"rgba($cOu,1)\" $outHidden}";

$dates = implode(",",$dates);
$datasets = implode(",",$datasets);

print <<< html
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
	xAxisID: 'aika',
	yAxisID: 'määrä',
    data: {
        labels: [$dates],
        datasets: [$datasets]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});
</script>
html;


?>
