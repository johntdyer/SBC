<?
header("Content-type: text/xml");
include 'APIFunctions.php';
					$recordCounterVar=1;  // Counter
print('<xmlData>');

$queryResults=getRecordArray($_REQUEST['callerID']);
$record = sqlite_fetch_array($queryResults);
$recordsFound = sqlite_num_rows($queryResults);    // Count the number of records
/* 
Set result message depending on if callerID was not given or if 
callerID was given but not records were found
*/
	if(!isset($_REQUEST['callerID'])){
		echo("<queryResults recordsFound=\"".$recordsFound."\">");	
		echo "<rejectWithBusy>".checkRejectWithBusy()."</rejectWithBusy>";
		echo "<ifRecordFound>".getOnANIMatchCondition()."</ifRecordFound>";
		echo("<queryResults>CallerID not provided</queryResults>");
		if(getOnANIMatchCondition()=="acceptCall"){
			print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("acceptCall")	.	'</rejectCallWithBusy>');
			print('</xmlData>');
			exit;
		}else{
			print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("rejectCall")	.	'</rejectCallWithBusy>');
			print('</xmlData>');
			exit;
		}
	}
		
	if($recordsFound==0){
		echo("<queryResults recordsFound=\"0\"/>");
		echo "<ifRecordFound>".getOnANIMatchCondition()."</ifRecordFound>";
		if(getOnANIMatchCondition()=="acceptCall"){
			print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("rejectCall")	.	'</rejectCallWithBusy>');
			print('</xmlData>');
			exit;
		}else{
			print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("acceptCall")	.	'</rejectCallWithBusy>');
			print('</xmlData>');
			exit;
		}
	}
	
	/* If we find 1 record or multiple records */
	if($recordsFound==1){
				echo "<rejectWithBusy>".checkRejectWithBusy()."</rejectWithBusy>";
				echo "<ifRecordFound>".getOnANIMatchCondition()."</ifRecordFound>";
			if(getOnANIMatchCondition()=="acceptCall"){
				print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("acceptCall")	.	'</rejectCallWithBusy>');
				}else{
					if(checkRejectWithBusy()=='false'){
					print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("rejectCall")	.	'</rejectCallWithBusy>');	
					}else{
						print('<rejectCallWithBusy value="true"/>');
					}
				}
		echo("<queryResults recordsFound=\"".$recordsFound."\">");
		echo('<!--One Record Found-->');
		echo('<recordName>'. $record['firstName'] . " " . $record['lastName']. '</recordName>');
		echo "</queryResults>";
	
		}elseif($recordsFound>1){
			echo "<rejectWithBusy>".checkRejectWithBusy()."</rejectWithBusy>";
			echo "<ifRecordFound>".getOnANIMatchCondition()."</ifRecordFound>";
				if(getOnANIMatchCondition()=="acceptCall"){
					print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("acceptCall")	.	'</rejectCallWithBusy>');
				}else{
					if(checkRejectWithBusy()=='false'){
						print('<rejectCallWithBusy value="false">'	.	getRedirectRoute("rejectCall")	.	'</rejectCallWithBusy>');	
					}else{
						print('<rejectCallWithBusy value="true"/>');
					}
				}
	
				echo("<queryResults recordsFound=\"".$recordsFound."\">");
				echo('<!-- Multiple Records Found-->');
				// Print out records found if there are more then one

				$query = "SELECT * FROM userRecords WHERE (ANI='".$_REQUEST['callerID']."') ORDER BY 1 DESC";	
				$dbhandle = sqlite_open($dbPath,0666);
				$result = sqlite_array_query($dbhandle,$query, SQLITE_ASSOC);

				foreach ($result as $entry) {
					echo "<recordName number=\"" . $recordCounterVar . "\">". ($entry['firstName'])." ".($entry['lastName']). "</recordName>";
					$recordCounterVar++;
				}
				echo "</queryResults>";
			}

			print('</xmlData>');
			exit;
?>
