<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>		
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<?
include '../functions.inc';

$oldPassword = $_REQUEST['oldPassword'];
$newPassword = $_REQUEST['newPassword'];
?>
</head>
<?
$result = setPassword(trim($oldPassword),trim(sha1($newPassword)));
//redirectTo("../adminPage.php");
switch ($result) {
	case '1':
		echo "changed";
		break;
	case '0':
		echo "not changed";
		break;
	case 'error':
		echo "error";
		break;
	default:
		echo "default";
		break;
	}
?>	
<script type="text/javascript" charset="utf-8">
	parent.Mediabox.closerefresh();
</script>
</html>