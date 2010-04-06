<script type="text/javascript" src="js/mootools.1.2.4.js"></script>
<head>
<?php
/* These are our valid username and passwords */
$user = 'admin';
$pass = 'admin';
?>
<script type="text/javascript" charset="utf-8">
	var cookieUsername = Cookie.read("username");
	var cookiePassword = Cookie.read("password");
	document.write(Cookie.read("username"));
	document.write(Cookie.read("username"));
</script>

</head>
<?


if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
	if(!(checkUsername($_POST['username'])) || !(checkPassword($_POST['password']))){
		
      echo('<script>redirectHome("Invalid Password");</script>');

    } else {
        echo 'Welcome back ' . $_COOKIE['username'];
    }
    
} else {

  echo('<script>redirectHome("Invalid Password");</script>');
}
?>