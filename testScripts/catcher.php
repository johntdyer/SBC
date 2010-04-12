<?php
	date_default_timezone_set('UTC');
	$myFile = "loadTest__".date('m-d-Y'). ".csv";

	$timeStamp	=	date('H:i:s') . " UTC";
	$sessionID 	= 	$_REQUEST['sessionID'];
	$callDuration 	= 	($_REQUEST['callDuration']/1000);

//  PinCode 99997 was to simulate a error in the db.  We still want to throw these in our driver, but  we dont need to log them.
// 	@@@@@ NORMAL CALL DURATION IS 97 SECONDS, ANYTHING ELSE WILL BE LOGGED TO CSV FILE
//if($pinCode != '99997'){
	if(!file_exists($myFile)){
		touch ($myFile);
		$fh = fopen($myFile, 'a');
		fwrite($fh,"Load Test\nDate,");
		fwrite($fh,date('m-d-Y')."\nNormal Duration,? Seconds\n");
		fwrite($fh, "Call Duration,Session ID,Time Stamp\n");
		fwrite($fh,$callDuration.",". $sessionID . "," . $timeStamp . "\n");
		fclose($fh);
	}else{
		$fh = fopen($myFile, 'a');
		fwrite($fh,$callDuration.",". $sessionID . "," . $timeStamp . "\n");
		fclose($fh);
		}
//}
?>
