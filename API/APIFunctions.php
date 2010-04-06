<?
/* API Functions */

include('../functions.inc');

	/**
	 * Just prints the general rules for getXML.php
	 *
	 * @return XML Body
	 * @author John Dyer
	 */
	function printGeneralRules($closeNode){
		print('<generalRules>');
		 print('<ifRecordFound>rejectCall</ifRecordFound>');
			if($closeNode){
				print('</generalRules>');
			}
	}

/**
 *  Get redirect route
 *
 * @param string $onMatchCondition (rejectCall | acceptCall)
 * @return string  returns the SIP URL
 * @author John Dyer
 */
 
	function getRedirectRoute($onMatchCondition){
		global $dbPath;
		$dbhandle = sqlite_open($dbPath,0666);
		if ($onMatchCondition == "rejectCall"){
			$sql = sqlite_query($dbhandle,"select value from data where id='rejectRedirectURL'");
			$url = sqlite_fetch_single($sql);
		}elseif ($onMatchCondition == "acceptCall"){
			$sql = sqlite_query($dbhandle,"select value from data where id='acceptRedirectURL'");
			$url = sqlite_fetch_single($sql);
		}
	//	print ('<redirectRoute>' . urldecode($url) . '</redirectRoute>');
		return urldecode($url);
 }


	/**
	 * getReasonMessage 
	 *
	 * @param string $acceptOrDeny 
	 * @param string $wasRecordFound 
	 * @return XML Data
	 * @author John Dyer
	 */
		function getReasonMessage($acceptOrDeny,$wasRecordFound){

			
			if($acceptOrDeny=="acceptCall"){
				if($wasRecordFound==0){
					print('<reasonMessage>No Record Found [ACTION: acceptCall]</reasonMessage>');
				}elseif($wasRecordFound==1){
					print('<reasonMessage>Found Record [ACTION: acceptCall]</reasonMessage>');
				}else{
					print('<reasonMessage>Multiple Matches [ numberOfRecords ('. ($wasRecordFound+1).') | ACTION: rejectCall]</reasonMessage>');
				}
			}	elseif($acceptOrDeny="rejectCall"){
				if($wasRecordFound==0){
					print('<reasonMessage>No Record Found [ACTION: rejectCall]</reasonMessage>');
				}elseif($wasRecordFound==1){
					print('<reasonMessage>Found Record [ACTION: rejectCall]</reasonMessage>');
				}	else {	
					print('<reasonMessage>Multiple Matches [ numberOfRecords ('. ($wasRecordFound+1).') | ACTION: rejectCall]</reasonMessage>');	
				}
			}
		}

?>