<?

header("Content-type: text/xml");

/**
 * getReasonMessage 
 *
 * @param string $acceptOrDeny 
 * @param string $wasRecordFound 
 * @return XML Data
 * @author John Dyer
 */
include 'APIFunctions.php';

/*
	function getReasonMessage($acceptOrDeny,$wasRecordFound){
		if($acceptOrDeny=="acceptCall"){
			if($wasRecordFound==1){
				print('<reasonMessage>Found Record [ACTION: acceptCall]</reasonMessage>');
			}elseif($wasRecordFound==2){
				print('<reasonMessage>Multiple Record Found [ACTION: acceptCall]</reasonMessage>');
			}else{
				print('<reasonMessage>No Record Found [ACTION: acceptCall]</reasonMessage>');
			}
		}
		elseif($acceptOrDeny="rejectCall"){
			if($wasRecordFound==1){
				print('<reasonMessage>Found Record [ACTION: rejectCall]</reasonMessage>');
			}elseif($wasRecordFound==2){
				print('<reasonMessage>Multiple Record Found [ACTION: rejectCall]</reasonMessage>');
			}	else{
					print('<reasonMessage>No Record Found [ACTION: rejectCall]</reasonMessage>');
				}
		}

	}
	*/
	print('<d>');
//	getReasonMessage("rejectCall",12);

//getReasonMessage("acceptCall",true);
//getReasonMessage("acceptCall",2);
//getReasonMessage("rejectCall",0);
//echo checkRejectWithBusy();
echo getRedirectRoute(getOnANIMatchCondition());
//printGeneralRules(true);
print('</d>');
?>