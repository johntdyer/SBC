<html>
<head>  
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>User Login</title>

	<script type="text/javascript" src="js/mootools.1.2.4.js"></script>
	
	<script type="text/javascript">
	function setCookie(user,pass){
		Cookie.write('password','<? echo sha1	(" . document.write(pass) .");?>');
		Cookie.write('username',user);
//		Cookie.write('password';
		}
	</script>
	</head>
	<body onload="setCookie('john', '1234abc')">
		</body>
	</html>