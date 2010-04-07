<html>
<head>
	<title>User Login</title>
	<link rel="stylesheet" href="css/sort.css" />
	<link rel="stylesheet" href="css/mediaboxAdvBlack.css" type="text/css" media="screen"/> 
	<script type="text/javascript" src="js/mootools.1.2.4.js"></script>
	<script type="text/javascript" src="js/mediaboxAdv-1.2.0.js"></script>
</head>
<body>
	<?	include("functions.inc"); 	?>
	<h2>Application Firewall</h2>	
	
	<form name="login" method="post" action="formUtilityFunctions/login_Script.php">
	<table cellpadding="1" cellspacing="10" border="0" id="header">
		<tr>
			<td><img src="images/logo.png" height="35px"/></td>
		</tr>
		<tr>
			<td>Username: <input type="text" name="username"><br></td>
		</tr>
		<tr>
			<td>Password: <input type="password" name="password"><br></td>
		</tr>
		<tr>
			<td>Remember Me: <input type="checkbox" name="rememberMe" value="1"><br></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Login!"></td>
		</tr>
	</table>
		</form>	
	</body>
</html>
