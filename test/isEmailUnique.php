<?
$email = $_POST['value'];

if(!isEmailUnique($email)){
	$json["valid"] = false;
	$json["message"] = 'Email is already in use';
}
else {
	$json["valid"] = true;
}

function isEmailUnique($email){
	// Database look-up should go here here...
	// But for the sake of this demo a random return will do
	return rand(0, 1);
}

print json_encode($json);

?>