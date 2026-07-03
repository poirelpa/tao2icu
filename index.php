<?php

$ics = file_get_contents('https://beta.trainasone.com/calendar/b6553640d8a7dde3cf340f9f1780c94da8d76f50.ics');
$ics = str_replace("\r\n ",'',$ics);
$ics = str_replace('*','-',$ics);
$ics = str_replace('/km','/km Pace',$ics);
$ics = str_replace(' bpm','bpm',$ics);
while(preg_match('/(\d+) hours?\\\\, (\d+) minutes?/',$ics, $matches))
{
	$ics = str_replace($matches[0], ($matches[1] * 60 + $matches[2]) . "m", $ics);
}
$ics = str_replace(' minutes','m',$ics);

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="plan.ics"');

$lines = explode("\r\n", $ics);
$ics = '';
foreach($lines as $line)
{
	$ics .= chunk_split($line, 75, "\r\n ") . "\r\n";
}



echo $ics;

?>