<?php
print "<h2>Päivitä tiedot</h2>";

if($_POST['save']) {
	$result = $babytracker->update($infoPath, $_POST);

	if($result['status'] == "ok") print "<div class='success callout'>{$result['info']}</div>";
	elseif($result['status'] == "error") print "<div class='alert callout'>{$result['info']}</div>";
}

$data = $babytracker->get($infoPath);

$additions = explode(",",ADDITIONS);
$currAdditions = explode(",", $data['additions']);

foreach($additions as $add) {
	$checked = in_array($add, $currAdditions) ? "checked" : null;
	$additionsForm .= <<< html
<span class="label secondary text-center" style="padding: 15px 15px 0 15px; margin-right: 10px;">$add <input type="checkbox" name="additions[]" value="$add" $checked></span>
html;
}

$datetime = date("Y-m-d H:i", strtotime($data['time']));

print <<< html
<form method="post">
<div class="row">
	<div class="small-12 columns">
		<label>Aika
			<input type="datetime" name="time" value="$datetime">
		</label>
	</div>
</div>
<div class="row">
	<div class="small-4 medium-2 columns">
		<label>Virtsa <b>g ml</b>
			<input type="text" name="pee" value="{$data['pee']}">
		</label>
	</div>
	<div class="small-4 medium-2 columns">
		<label>Kakka <b>g ml</b>
			<input type="text" name="poo" value="{$data['poo']}">
		</label>
	</div>
	<div class="small-4 medium-2 columns">
		<label>Imetys <b>ml</b>
			<input type="text" name="breast" value="{$data['breast']}">
		</label>
	</div>
	<div class="small-4 medium-2 columns">
		<label>Pullo rinta <b>ml</b>
			<input type="text" name="bottleBreast" value="{$data['bottleBreast']}">
		</label>
	</div>
	<div class="small-4 medium-2 columns">
		<label>Pullo korvike <b>ml</b>
			<input type="text" name="bottleSubstitute" value="{$data['bottleSubstitute']}">
		</label>
	</div>
	<div class="small-4 medium-2 columns">
		<label>Pullo muu <b>ml</b>
			<input type="text" name="bottleOther" value="{$data['bottleOther']}">
		</label>
	</div>
</div>
<div class="row">
	<div class="small-6 medium-3 columns">
		<label>Paino <b>g</b>
			<input type="text" name="weight" value="{$data['bottleOther']}">
		</label>
	</div>
	<div class="small-6 medium-3 columns">
		<label>Pituus <b>cm</b>
			<input type="text" name="height" value="{$data['height']}">
		</label>
	</div>
	<div class="small-6 medium-3 columns">
		<label>Pään ympärys <b>cm</b>
			<input type="text" name="headcirc" value="{$data['headcirc']}">
		</label>
	</div>
	<div class="small-6 medium-3 columns">
		<label>Lämpötila
			<input type="text" name="temperature" value="{$data['temperature']}">
		</label>
	</div>
</div>
<div class="row">
	<div class="small-12 columns">
		<label>Lisäinfo
			<input type="text" name="info" value="{$data['info']}">
		</label>
	</div>
</div>
<div class="row">
	<div class="small-12 columns">
		$additionsForm
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


?>