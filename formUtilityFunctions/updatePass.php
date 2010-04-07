<?
include '../functions.inc';

$inputConfirmPassword = $_REQUEST['inputConfirmPassword'];

setPassword(trim(sha1($inputConfirmPassword)));

redirectTo("../adminPage.php");

?>