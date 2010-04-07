<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0

$dbname='database.SQlite.db';
$appDir = "SBC";

$root = getenv("DOCUMENT_ROOT");
$dbPath = $root."/".$appDir."/db". "/". $dbname;

/* if we are updating the rejectWithBusy flag, otherwise we skip */
if(isset($_REQUEST['rejectWithBusy'])){
		$rejectWithBusy = $_REQUEST['rejectWithBusy'];
	$dbhandle = sqlite_open($dbPath);
	$query = "UPDATE data SET value = '$rejectWithBusy' WHERE id = 'rejectWithBusy'";
	$results = sqlite_query($dbhandle, $query,$error);
	exit;	
}

$fieldname = trim($_GET['fieldname']); 
$content = trim($_GET['content']);

if ( ( $fieldname[0] == 'a' ) && ( $fieldname[1] == '_' ) ) {
		$myFilename = substr($fieldname, 2);
		$myFilename = sqlite_escape_string($myFilename);
		$query = "UPDATE data SET value = '$content' WHERE id = '$myFilename'";
}
	
	$dbhandle = sqlite_open($dbPath);
	$results = sqlite_query($dbhandle, $query,$error);

		if (!$results){	
			echo "<b>Error:</b>  " . $error;	
		}
	$fieldname = $_GET['fieldname'];
	echo stripslashes(strip_tags($_GET['content'],""));
	?>