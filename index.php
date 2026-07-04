<?php

$id = $_GET['id'];
$ics = file_get_contents("https://beta.trainasone.com/calendar/$id.ics");
$ics = str_replace("\r\n ",'',$ics);
$ics = str_replace('.\n','\n',$ics);
$ics = preg_replace('/ \* Perform the following steps (\d+) times/','\nPerform the following steps $1x',$ics);
$ics = str_replace('   *','- ',$ics);
$ics = str_replace(' *','\nStep\n- ',$ics);
$ics = str_replace('/km','/km Pace',$ics);
$ics = str_replace(' km','km',$ics);
$ics = preg_replace('/ \d+ bpm \((\d+) to (\d+)\)/',' $1-$2bpm',$ics);
$ics = str_replace(' bpm','bpm',$ics);
$ics = str_replace(' hours','h',$ics);
$ics = str_replace(' hour','h',$ics);
$ics = str_replace(' minutes','m',$ics);
$ics = str_replace(' minute','m',$ics);
$ics = str_replace(' seconds','s',$ics);
$ics = str_replace(' second','s',$ics);
$ics = str_replace('no faster than ','20:00-',$ics);
$ics = preg_replace('/\(([0-9.]+km)\)/s','$1',$ics);



if(false){ // debug

echo '<pre>';
echo str_replace('\,',',',str_replace('\n', "\r\n", $ics));
die();
}

$lines = explode("\r\n", $ics);
$ics = '';
foreach($lines as $line)
{
	$ics .= chunk_split($line, 75, "\r\n ") . "\r\n";
}
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="plan.ics"');
echo $ics;

?>
