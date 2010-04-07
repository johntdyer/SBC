<?
include '../functions.inc';


function a($r){
	return sqlite_fetch_array($r,SQLITE_ASSOC);
}
function fa($r){
	return sqlite_fetch_all($r,SQLITE_ASSOC);
}
function n($r){
	return sqlite_num_rows($r);
}
function lr(){
	return sqlite_last_insert_rowid($this->con);
}


function getRecordArray2($phoneNum){
	global $dbname, $dbPath;
	$query = "SELECT * FROM userRecords WHERE (ANI=$phoneNum)";	
	$dbhandle = sqlite_open($dbPath,0666);
	$query = sqlite_query($dbhandle, $query);
	return $query;
}

function onDefaultMatch(){
	global $dbPath;
	$dbhandle = sqlite_open($dbPath,0666);	
	$q = sqlite_query($dbhandle,"select value from data where id='onANIMatch'");
	return sqlite_fetch_single($q);
}

function returnRoute($onMatchCondition){
	global $dbPath;
	$dbhandle = sqlite_open($dbPath,0666);
		if ($onMatchCondition == "rejectCall"){
			$sql = sqlite_query($dbhandle,"select value from data where id='rejectRedirectURL'");
			$url = sqlite_fetch_single($sql);
			return $url;
		}elseif ($onMatchCondition == "acceptCall"){
			$sql = sqlite_query($dbhandle,"select value from data where id='acceptRedirectURL'");
			$url = sqlite_fetch_single($sql);
			return $url;
		}
	}
	
	echo returnRoute(onDefaultMatch());


/*
$queryResults=getRecordArray2($_REQUEST['phoneNum']);

echo sqlite_num_rows($queryResults);

// if rows exist 
if (sqlite_num_rows($queryResults) > 0) { 
// get each row as an array 
// print values 
echo "<table cellpadding=10 border=1>"; 
while($row = sqlite_fetch_array($queryResults)) { 
echo "<tr>"; 
echo "<td>".$row[0]."</td>"; 
echo "<td>".$row[1]."</td>"; 
echo "<td>".$row[2]."</td>"; 
echo "</tr>"; 
} 
echo "</table>"; 
}
*/

/*

$queryResults=getRecordArray2($_REQUEST['phoneNum']);

$t = a($queryResults);
echo $t . "<br/>";
foreach($t as $key){
	echo $key . " ";
}
echo "<br/>";

echo "Count of " . $_REQUEST['phoneNum'] . ": " . count($queryResults) . "<br/><br/>";


$value = sqlite_fetch_array($queryResults, SQLITE_ASSOC);

echo count($value)	 . "<br/>";
foreach($value as $key){
	echo $key . " ";
}
*/
?>