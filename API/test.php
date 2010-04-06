<?
include('../functions.inc');
//setRedirectURL("accept","sip:acceptApp@localhost");
/*
#1:			blocked listed Numbers	W/ URL
#2:			block listed numbers	W/ BUSY
#3:			accept Listed Numbers


*/
$testCond = $_REQUEST['testCond'];

switch ($testCond) {
	case '1':
//		echo "<br/>Before (onANIMatch): " . getOnANIMatchCondition();
	//	echo "<br/>Before: (rejectWithBusy): " . checkRejectWithBusy();
		setOnANIMatchCondition("rejectCall");
		setRejectWithBusy(false);
	//	echo "<br/>After (onANIMatch): " . getOnANIMatchCondition();
	//	echo "<br/>After (rejectWithBusy): " . checkRejectWithBusy();	
		echo "<br/>If caller calls and we find him we will reject call with a redirect route";
		
	break;
	
	case '2':
	//	echo "<br/>Before (onANIMatch): " . getOnANIMatchCondition();
	//	echo "<br/>Before: (rejectWithBusy): " . checkRejectWithBusy();
		setOnANIMatchCondition("rejectCall");
		setRejectWithBusy(true);
	//	echo "<br/>After (onANIMatch): " . getOnANIMatchCondition();
	//	echo "<br/>After (rejectWithBusy): " . checkRejectWithBusy();		
				echo "<br/>If caller calls and we find him we will reject call with a busy";
	break;
	
	case '3':
	//	echo "<br/>Before (onANIMatch): " . getOnANIMatchCondition();
	//	echo "<br/>Before: (rejectWithBusy): " . checkRejectWithBusy();
		setOnANIMatchCondition("acceptCall");
//	setRejectWithBusy(false);
//		echo "<br/>After (onANIMatch): " . getOnANIMatchCondition();
//		echo "<br/>After (rejectWithBusy): " . checkRejectWithBusy();		
		echo "<br/>If caller calls and we find him we will accept";
		
	break;
		
	
	default:
		echo "DEFAULT";
	break;
}

//echo "If caller calls and we see him we will reject call";

?>