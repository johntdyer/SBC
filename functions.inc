<?
$dbname='database.SQlite.db';
$appDir = "SBC";

$root = getenv("DOCUMENT_ROOT");
$dbPath = $root."/".$appDir."/db". "/". $dbname;

	function addCallerRecord($firstName,$lastName,$ANI,$recordNotes){
		global $dbPath;
		$dbhandle = sqlite_open($dbPath);
		if ($firstName == ""){
			$firstName = "n/a";
		} 
		if($lastName == ""){
			$lastName = "n/a";
		}
		
		$sql = "INSERT INTO userRecords(ID,firstName,lastName,ANI,recordNotes) VALUES (NULL,'$firstName','$lastName','$ANI','$recordNotes')";
	//	if ($firstName == "" || $lastName == "" || $ANI == ""){
		if ( $ANI == ""){
			return 0;
		}else{
			$query = sqlite_query($dbhandle, $sql, $error);
				if (!$query){	
					echo "<b>Error:</b>  " . $error . "<br/><br/>";	
					return -1;
				}else{
					return 1;
				}		
			}
	}
	
	function checkFormData($firstName,$lastName,$ANI){
		$returnArray = array();
		$returnArray[0] = false;
		$formValidationErrorMessage ="";
		// First Name
			if(!preg_match("#^[-A-Za-z' ]*$#",$firstName)) {
				$returnArray[0] = true;
				$formValidationErrorMessage = $formValidationErrorMessage . '<li>First name contains special characters</li>';
			}
		// Last Name
			if(!preg_match("#^[-A-Za-z' ]*$#",$lastName)) {
				$returnArray[0] = true;
				$formValidationErrorMessage = $formValidationErrorMessage . '<li>Last name contains special characters</li>';
			}
		//Phone Number
			if(!ereg("^[0-9]{3}[0-9]{3}[0-9]{4}$", $ANI) || $ANI =="") {
				$returnArray[0] = true;
				$formValidationErrorMessage = $formValidationErrorMessage . '<li>Phone numbers empty or contains special characters</li>';
			}	
			$returnArray[1] = $formValidationErrorMessage;
		return $returnArray;
	}
	
	function getOneRecord($id){
		global $dbPath;
			$dbhandle = new SQLiteDatabase($dbPath);
			$sql = "SELECT * FROM userRecords where ID = '$id'";		
			$results = $dbhandle->arrayQuery($sql, SQLITE_ASSOC);
		return $results;
	}
	
	function delOneRecord($id){
		global $dbPath;
		$dbhandle = sqlite_open($dbPath);
		
		//$dbhandle = new SQLiteDatabase($dbPath);
		$sql = "delete from userRecords where id = '$id'";
		$results = sqlite_query($dbhandle, $sql, $error);
			//$results = $dbhandle->queryexec($sql, $error);
			if (!$results){	
				return 0;
			}else{
				return 1;
			}
	}

	function testConnectivity(){
		global $dbPath;
		
		$base=new SQLiteDatabase($dbPath, 0666, $err);
		if ($err)
		{ 
		  echo "SQLite NOT supported.\n";
		  exit($err);
		}
		else
		{
		echo "SQLite Supported.<br/>";
		}
	}
	
/**
 * Makes our tables
 *
 * @return Test
 * @author John Dyer
 **/
	function createTables(){
		global $dbPath;
		$mytable = array("userRecords", "callHistory", "Data");
		   $base= new SQLiteDatabase($dbPath, 0666, $err);
		   if ($err){
		   	exit($err);
		   }

		$myArray = array();
		$myArray["userRecords"] = "CREATE TABLE userRecords(ID INTEGER PRIMARY KEY, firstName text NOT NULL,lastName text, ANI bigint(13),recordNotes VARCHAR(255))";
		$myArray["callHistory"] = "CREATE TABLE callHistory(sessionID VARCHAR(255),timeStamp datetime,ANI bigint(13),apiReturn text)";
		$myArray["Data"] = "CREATE TABLE data(ID text,value text)";
		$myInserts = array();
		$myInserts["user"] = "INSERT INTO DATA(ID,value) VALUES ('userName','admin')";
		$myInserts["pass"] = "INSERT INTO DATA(ID,value) VALUES ('pass','7505d64a54e061b7acd54ccd58b49dc43500b635')";
		$myInserts["matchAction"] = "INSERT INTO DATA(ID,value) VALUES ('onANIMatch','rejectCall')";
		$myInserts["acceptRedirectURL"] = "INSERT INTO DATA(ID,value) VALUES ('acceptRedirectURL','')";
		$myInserts["rejectRedirectURL"] = "INSERT INTO DATA(ID,value) VALUES ('rejectRedirectURL','')";
		$myInserts["rejectRedirectURL"] = "INSERT INTO DATA(ID,value) VALUES ('rejectWithBusy','1')";

		foreach ($myArray as $key => $value) {
			echo "<b>Action:</b> create table " . $dbname . "<b>." . $key . "</b><br/>";	
					$results = $base->queryexec($value, $error);
			if (!$results){
				echo "<b>Error:</b>  " . $error . "<br/><br/>";	
			}else{
				echo "Table <b> '$key' </b> created.<br>";
			}
		}
		foreach ($myInserts as $key => $value) {
				echo "<b>Action:</b> Insert data " . $dbname . "<b>." . $key . "</b><br/>";	
						$results = $base->queryexec($value, $error);
			if (!$results){
				echo "<b>Error:</b>  " . $error . "<br/><br/>";	
			}else{
				echo "Record <b> '$key' </b> inserted.<br>";
			}
		}	
	}
	
/**
 * Checks if we redirect with a busy or not, if not we then redirect to a custom URL
 *
 * @return BOOLEAN
 * @author John Dyer
 **/
	function checkRejectWithBusy(){
		global $dbPath;
		$dbhandle = sqlite_open($dbPath,0666);	
		$q = sqlite_query($dbhandle,"select value from data where id='rejectWithBusy'");
		return sqlite_fetch_single($q);
	}
	
/**
 * Set flag to determine if we reject with a busy or not
 *
 * @param  BOOLEAN	$i 
 * @return BOOLEAN || -1 (Error)
 * @author John Dyer
 **/
	function setRejectWithBusy($i){
		global $dbPath;
		$dbhandle = sqlite_open($dbPath,0666);	
			if(is_bool($i)){
				if($i){ 
					$sql = "UPDATE data SET value='true' WHERE (id='rejectWithBusy')";	
					}	else {	
						$sql = "UPDATE data SET value='false' WHERE (id='rejectWithBusy')";	
					}
				}	else {
					return -1;  // NOT BOOLEAN
			}
				$result = sqlite_query($dbhandle,$sql,$error);
					if (!$result){	
						return 0;
					}else{
						return 1;
				}
		}


function getRedirectURL($rejectOrAccept){
	global $dbname, $dbPath;
	$rejectOrAccept=strtolower($rejectOrAccept);
	if(!($rejectOrAccept=="accept"||$rejectOrAccept=="reject")){
		return -1;
	}else{
		if($rejectOrAccept=="accept"){
				$rejectOrAccept="acceptRedirectURL";
		}else if($rejectOrAccept=="reject"){
				$rejectOrAccept="rejectRedirectURL";	
		}	
	$sql = "SELECT value FROM data WHERE (id='$rejectOrAccept')";
	$dbhandle = sqlite_open($dbPath,0666);
	$query = sqlite_query($dbhandle, $sql);
		while (sqlite_has_more($query)) {
			return urldecode($row = sqlite_fetch_single($query));
		}
	}
}

function setRedirectURL($rejectOrAccept,$urlValue){
	global $dbPath;
	$rejectOrAccept=strtolower($rejectOrAccept);
//	$urlValue =	urlencode($urlValue);
	$urlValue = urlencode(trim(stripslashes(strip_tags($urlValue,""))));
	
	if(!($rejectOrAccept=="accept"||$rejectOrAccept=="reject")){
		return -1;
	}
	if($rejectOrAccept=="accept"){
		$rejectOrAccept="acceptRedirectURL";
	}else if($rejectOrAccept=="reject"){
		$rejectOrAccept="rejectRedirectURL";	
	}
		$sql = "UPDATE data SET value='". $urlValue . "' WHERE (id='$rejectOrAccept')";
		$dbhandle = sqlite_open($dbPath);
		$results = sqlite_query($dbhandle, $sql, $error);
	if (!$results){	
		//return $error;
		return 0;
	}else{
		return 1;
	}
}

function getOnANIMatchCondition(){
	global $dbPath;
	$dbhandle = sqlite_open($dbPath,0666);	
	$q = sqlite_query($dbhandle,"select value from data where id='onANIMatch'");
	return sqlite_fetch_single($q);
}


function getUserName(){
	global $dbPath;
	$dbhandle = sqlite_open($dbPath,0666);	
	$q = sqlite_query($dbhandle,"select value from data where id='username'");
	return sqlite_fetch_single($q);
}

/**
 * Set the default match condition
 *
 * @param string $i 
 * @return boolean
 * @author John Dyer
 */
function setOnANIMatchCondition($i){
		global $dbPath;
		$dbhandle = sqlite_open($dbPath,0666);	
			if($i=="rejectCall"||$i=="acceptCall"){
				if($i=="rejectCall"){ 
					$sql = "UPDATE data SET value='rejectCall' WHERE (id='onANIMatch')";
					}	else if($i=="acceptCall") {	
						$sql = "UPDATE data SET value='acceptCall' WHERE (id='onANIMatch')";	
						setRejectWithBusy(false); 
					}
				}	else {
					return -1;  // NOT EXPECTED INPUT
			}
		$result = sqlite_query($dbhandle,$sql,$error);
		if (!$result){	
			return 0;
			}else{
			return 1;
		}
	}

	function setPassword($input){
		global $dbname, $dbPath;
		$dbhandle = sqlite_open($dbPath);
		$sql = "UPDATE data SET value='". $input . "' WHERE id='pass'";
		$results = sqlite_query($dbhandle, $sql, $error);
				if (!$results){	
						return 0;
					}else{
						return 1;
				}
	}	
		
		
		function checkUsername($comparator){
				global $dbname, $dbPath;
				$dbhandle = sqlite_open($dbPath);
				$sql = "SELECT value FROM data WHERE id='userName'";
				$query = sqlite_query($dbhandle, $sql);
				while (sqlite_has_more($query)) {
							$old = sqlite_fetch_single($query);
						}
				if ($old==$comparator){
					return 1;
				} else{
					return 0;
				}
		}
	function checkPassword($comparator){
			global $dbname, $dbPath;
			$dbhandle = sqlite_open($dbPath);
			$sql = "SELECT value FROM data WHERE id='pass'";
			$query = sqlite_query($dbhandle, $sql);
			while (sqlite_has_more($query)) {
						$old = sqlite_fetch_single($query);
					}
			if ($old==sha1($comparator)){
				return 1;
			} else{
				return 0;
			}
	}	
	
	function checkPasswordSha1($comparator){
			global $dbname, $dbPath;
			$dbhandle = sqlite_open($dbPath);
			$sql = "SELECT value FROM data WHERE id='pass'";
			$query = sqlite_query($dbhandle, $sql);
			while (sqlite_has_more($query)) {
						$old = sqlite_fetch_single($query);
					}
			if ($old==$comparator){
			
				return 1;
			} else{
		
				return 0;
			}
	}
	
			
	/**
	 * REDIRECT FUNCTION
	 * Redirects to new URL
	 * 
	 * @param   String	$url	URL you want to redirect to
	 */
	function redirectTo($url,$permanent = false){
		if($permanent)
		{
			header('HTTP/1.1 301 Moved Permanently');
		}
		header('Location: '.$url);
		exit();
	}
	
	function getRecordArray($phoneNum){
		global $dbname, $dbPath;
		$query = "SELECT * FROM userRecords WHERE (ANI=$phoneNum)";	
		$dbhandle = sqlite_open($dbPath,0666);
		$query = sqlite_query($dbhandle, $query);
		return $query;
	}

	function connectDB(){
		global $dbname;
		$base= new SQLiteDatabase($dbname, 0666, $err);
			if ($err){
				exit($err);
			}
			return $base;
	}

?>