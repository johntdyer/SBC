<?
include '../functions.inc';

/*
if (!isset($_POST['value'])) 
{
//If not isset -> set with dumy value 
$_POST['value'] = "undefine"; 
}
*/

$password = $_REQUEST['value'];



if(!confirmPassword($password)){
	$json["valid"] = false;
	$json["message"] = 'Invalid Password';
}
else {
	$json["valid"] = true;
}

function confirmPassword($password){
	// Database look-up should go here here...
	return checkPassword($password);
}

print json_encode($json);

?>