<?php
$filename = "prestationDonnees_temp.txt";

if (file_exists($filename)) {
	$message = json_decode(file_get_contents($filename), true);
} else {
	$message = [
		'time_start' => 0,
		'time_accumulated' => 0
	];
}

if (isset($_POST['fonction'])) {
	$fonction = $_POST['fonction'];
	if ($fonction == "start") {
		startTimer();
	} else if ($fonction == "pause") {
		pauseTimer();
	} else if ($fonction == "stop") {
		stopTimer();
	}
}

function startTimer()
{
	global $filename;
	$time_start = microtime(true);
	$contenuFichier = json_decode(file_get_contents($filename), true);
	if ($contenuFichier == null) {
		$message = [
			'time_start' => $time_start,
			'time_accumulated' => 0
		];
	} else {
		$time_accumulated = $contenuFichier['time_accumulated'];
		$message = [
			'time_start' => $time_start,
			'time_accumulated' => $time_accumulated
		];
	}

	file_put_contents($filename, json_encode($message));
}

function pauseTimer()
{
	global $filename;
	$message = json_decode(file_get_contents($filename), true);
	$time_end = microtime(true);
	$execution_time = ($time_end - $message['time_start']);
	$message['time_accumulated'] += $execution_time;
	$message['time_start'] = 0;
	file_put_contents($filename, json_encode($message));
}

function stopTimer()
{
	global $filename;
	$time_end = microtime(true);
	$message = json_decode(file_get_contents($filename), true);
	$execution_time = $message['time_accumulated'];

	if (($message['time_start'] != 0) && ($message['time_accumulated'] == 0)) {
		$execution_time += ($time_end - $message['time_start']);

	} else if (($message['time_start'] == 0) && ($message['time_accumulated'] != 0)) {
		$execution_time = $message['time_accumulated'];

	} else if (($message['time_start'] != 0) && ($message['time_accumulated'] != 0)) {
		$execution_time = ($time_end - $message['time_start']) + $message['time_accumulated'];
	}
	//echo "durée finale " . round($execution_time, 2) . " secondes";
	echo round($execution_time, 2);
	file_put_contents($filename, '');
}
?>