<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript" src="../js/mootools.1.2.4.js"></script>
	<?include('../functions.inc');?>
</head>
	<body>
	<?	function redirectHome($msg){?>
				<script>
					alert("<? echo $msg;?>");
				//	window.location="http://127.0.0.1:9990/SBC/authUser.php";
					window.location="../authUser.php";
				</script><?
			}
			
if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
	if((checkUsername($_POST['username'])) && (checkPassword($_POST['password']))){

		if(isset($_POST['rememberMe'])){	?>
				<script type="text/javascript" charset="utf-8">
					Cookie.write('VoxeoSBCpassword','<?php echo (sha1($_POST['password'])); ?>',{duration: 1, path: '/'});
					Cookie.write('VoxeoSBCusername','<?php echo ($_POST['username']); ?>',{duration: 1,path: '/'});
					//window.location="http://127.0.0.1:9990/SBC/main.php";
					parent.window.location.href='../main.php';
				</script>
			<?
		}else{	

			?>
			<script type="text/javascript" charset="utf-8">
				Cookie.write('VoxeoSBCpassword','<?php echo (sha1($_POST['password'])); ?>',{path: '/'});
				Cookie.write('VoxeoSBCusername','<?php echo ($_POST['username']); ?>',{path: '/'});
				//window.location="http://127.0.0.1:9990/SBC/main.php";
				parent.window.location.href='../main.php';
			</script><?	
		}
	}
	else{
		redirectHome("invalid username and/or password");
	}
}else{
	redirectHome("You must supply username and password");
}	?>
</html>