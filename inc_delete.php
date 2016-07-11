<?php
print "<h2>Poista tiedot</h2>";

if($_POST['delete']) {
	$result = $babytracker->delete($infoPath);

	if($result['status'] == "ok") print "<div class='success callout'>{$result['info']}</div>";
	elseif($result['status'] == "error") print "<div class='alert callout'>{$result['info']}</div>";
}
else {
	$data = $babytracker->get($infoPath);

	$datetime = date("Y-m-d H:i", strtotime($data['time']));

	print <<< html
	<form method="post">
	<div class="row">
		<div class="small-12 columns">
	Oletko varma, että haluat poistaa <b>$datetime</b> tiedot?
		</div>
	</div>
	<br />
	<div class="row">
		<div class="small-6 columns">
			<a href="{$basePath}" class="button success">En</a>
		</div>
		<div class="small-6 columns text-right">
			<input type="submit" class="button alert" name="delete" value="Kyllä, poista">
		</div>
	</div>
	</form>
html;
}

?>