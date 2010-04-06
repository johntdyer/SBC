<?
include '../functions.inc';


if (!isset($_POST['value'])) 
{
//If not isset -> set with dumy value 
$_POST['value'] = "undefined"; 
}



$sip = $_POST['value'];


if(!confirmSIP($sip)){
	$json["valid"] = false;
	$json["message"] = 'Invalid SIP URL';
}
else {
	$json["valid"] = true;
}

	function confirmSIP($sip){
		$SIP_REGEX = '^(sip|sips|tel):.*\@((\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3})|([a-zA-Z|0-9{2,11}\-\.{1}]+\.{1}[a-zA-Z]{2,5}))(:[\d]{1,5})?([\w\-?\@?\;?\,?\=\%\&]+)?^';
		if((!preg_match($SIP_REGEX,$sip))){
			return false;
		}else{
			return true;
		}
	}
print json_encode($json);

?>