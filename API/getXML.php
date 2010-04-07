<?
header("Content-type: text/xml");
include 'APIFunctions.php';
// NO PHONE NUMBER PROVIDED
// API REJECTS CALL
print('<xmlReturn>');

/*IF NO DATA IS SENT WE ASSUME USER IS ALLOWED OR DENIED
BASED ON GERNAL ROUTING RULES DEFINED IN APPLICATION*/

	if(!isset($_REQUEST['callerID'])){
		printGeneralRules(false); 
			/*
			 Print general rules w/ or w/o closing tag (boolean)
			*/
		if (checkRejectWithBusy()=="false"){
			getRedirectRoute("acceptCall");
		}elseif(checkRejectWithBusy()=="true"){
			getRedirectRoute("rejectCall");	
		}
		print('</generalRules>');
		print('<recordData>');
			print('<recordName/>');
			print('<reasonMessage>No ANI provided</reasonMessage>');
			print('</recordData>');
		print('</xmlReturn>');
		exit;
	}else{
	/*IF WE GET PARAMETERS WE THEN GET THE ARRAY FROM DATABASE*/
		$queryResults=getRecordArray($_REQUEST['callerID']);
		$record = sqlite_fetch_array($queryResults);
	}
	
	/* IF THERE ARE MORE THEN ONE RESULT WE ASSUME THEY 
	ARE ON THE LIST FOR A RESON SO WE CHECK THE DEFAULT 
	CONDITION AND PASS THEM ALONG	*/
	
	printGeneralRules(false);
	
	if((sqlite_num_rows($queryResults))>1){
			if (checkRejectWithBusy()=="false"){
				getRedirectRoute("rejectCall");
			}
				print('</generalRules>');
				print('<recordData>');
			if(getOnANIMatchCondition()=="acceptCall"){
			//		getRedirectRoute("acceptCall");
					getReasonMessage("acceptCall",sqlite_num_rows($queryResults));
			}else{
//				print('</generalRules>');
				getReasonMessage("rejectCall",sqlite_num_rows($queryResults));
			}
		print('</recordData>');
		print('</xmlReturn>');	
		exit;
	}
	/*
	WE HAVE ONE RECORD, LETS LOOK IT UP AND 
	FIGURE OUT WHAT TO DO
	*/
	// if we get a match we need output name, and determin action
	
//echo sqlite_num_rows($queryResults);
//	exit;
	
/* ONE RECORD FOUND */
	if(sqlite_num_rows($queryResults)==1){
		if(getOnANIMatchCondition()=="acceptCall"){
				getRedirectRoute("rejectCall");
		}else{
			if (checkRejectWithBusy()=="false"){
					getRedirectRoute("rejectCall");
				}
				//getRedirectRoute("acceptCall");
				//print('</generalRules>');
		}
		print('</generalRules>');
		print('<recordData>');
	//	getReasonMessage("rejectCall",true);
		print('<recordName>'. $record['firstName'] . " " . $record['lastName']. '</recordName>');
		// We have one record, print out user data
		if(getOnANIMatchCondition()=='rejectCall'){
			getReasonMessage("rejectCall",true);
		}
		if(getOnANIMatchCondition()=="acceptCall"){
			getReasonMessage("rejectCall",true);
		}
		print('</recordData>');
		print('</xmlReturn>');
		exit;
		/* NO USER RECORD FOUND */
	}	else 
		{  
			if(getOnANIMatchCondition()=="acceptCall"){
				if (checkRejectWithBusy()=="false"){
					getRedirectRoute("acceptCall");
				}
			}else{
				if (checkRejectWithBusy()=="true"){
					getRedirectRoute("acceptCall");
				}
		}
		print('</generalRules>');
		print('<recordData>');
		if(getOnANIMatchCondition()=='rejectCall'){
			getReasonMessage("acceptCall",false);
		}	else {	
			if (checkRejectWithBusy()=="false"){
				getReasonMessage("acceptCall",false);
			}
		}
		print('</recordData>');
	}
	print('</xmlReturn>');	
?>