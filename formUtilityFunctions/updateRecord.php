<html>
<head>
	<link rel="stylesheet" href="../css/style.css" />
	<link rel="stylesheet" href="../css/mediaboxAdvBlack.css" type="text/css" media="screen"/> 

<script type="text/javascript" src="../js/myFunctions.js"></script>
<script type="text/javascript" src="../js/mootools.1.2.4.js"></script>
<script type="text/javascript" src="../js/mediaboxAdv-1.2.0.js"></script>
<script type="text/javascript">

	function openBox(v,m){
		Mediabox.open(v, m, '300 300');
	}
</script>
<script>
function closeAndRefresh(){
	parent.Mediabox.closerefresh();
	return false;
}
</script>
</head>
<?
include '../functions.inc';
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('track_errors', true);

$validationFailed = false;
$ErrorMessage =('<center><b>Form Errors</b></center>');
//RECORD NAME DATA

$firstName=sqlite_escape_string($_REQUEST['firstName']);
$lastName=sqlite_escape_string($_REQUEST['lastName']);	
 
// PHONE NUMBER (ANI) DATA
$ANI = sqlite_escape_string($_REQUEST['ANI_1']);
$ANI = $ANI . sqlite_escape_string($_REQUEST['ANI_2']);
$ANI = $ANI . sqlite_escape_string($_REQUEST['ANI_3']);

// URL MATCH ACTIONS DATA
$recordNotes = sqlite_escape_string($_REQUEST['recordNotes']);
$validationFailed = checkFormData($firstName,$lastName,$ANI);
# Include message in error page and dump it to the browser
	
	if ($validationFailed[0] === true) {
		$ErrorMessage = $validationFailed[1];
		echo("<body onload=\"openBox('#mb_error','Error');\">");
	}
	if ( $validationFailed === false)$whichBoxToShowUser = "confirm";

	$addRecordsResult =  addCallerRecord($firstName,$lastName,$ANI,$recordNotes);
	if ($addRecordsResult == 1){
		$resultsTable = '<table><center><font color="red"><h1>Record Added</h1></font></center><br/><li><b>Name: </b>' . $firstName . " " . $lastName . '</li><li><b>ANI: </b>' . $ANI. '</li><li><b>Record Notes: </b>' . $recordNotes . '</li></table>';
		$resultsTable = $resultsTable . '<center><br/><input id="saveForm" class="button_text" type="submit" name="submit" onclick="closeAndRefresh();" value="Close"/></center>';
		echo("<body onload=\"openBox('#mb_success','Record Added');\">");
	}
	if ($addRecordsResult == -1 | $addRecordsResult = 0)echo("<body onload=\"openBox('#mb_SQLError','Error');\">");?>

<div id="mb_error" style="display: none;">
	<h3>Error Adding Record</h3>
	<span style="color: #999999;">There was an error adding this record <br/> 
	<? echo $ErrorMessage; ?> <br/>
		<?	echo $resultsTable;	?>
		<a href="" onclick="closeAndRefresh();">Close</a></span>
</div>

<div id="mb_SQLError" style="display: none;">
	<h3>Error Adding Record</h3>
	<span style="color: #999999; text-align: center;">There was an error adding this record <br/>
	<? echo $ErrorMessage; ?> <br/>
	<a href="" onclick="closeAndRefresh();">close</a></span>
</div>

<div id="mb_success" style="display: none;">
<!--	<h3>Record Added</h3>
	<span style="color: #999999; text-align: center;">Record has been added<br/>-->
	<? echo $resultsTable; ?> <br/>
</div>

	
</body>
</html>