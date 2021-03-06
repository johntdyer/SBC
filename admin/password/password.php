<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?// include '../functions.inc'; ?>
	<head>		
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<link href="../css/global.css" type="text/css" rel="stylesheet" />
<!--
		<script src="../../js/jquery.valid8-1.2.js" type="text/javascript" charset="utf-8"></script>
		<script src="../../js/jquery.accordion-1.2.2.js" type="text/javascript" charset="utf-8"></script>
		<script src="../../js/jQuery.js" type="text/javascript"></script>
-->		
		
	</head>
	<body>
		<div id="pageWrap" class="pageWrap">
	    	<div class="pageContent">
			<form action="../formUtilityFunctions/updatePass.php" method="get" accept-charset="utf-8">
			
		<ul class="accordion">
				<li>
				<a href="#admin">Passwords (click here)</a>
				<ul>
					<li>
						<a href="#currentPassword">Current Password</a>
						<span class="w"><input tabindex="2" name="oldPassword" class="input" id="currentPassword" type="password" /></span></p>
					</li>
					<li>
						<a href="#newPassword">New Password</a>
						<span class="w"><input tabindex="3" name="newPassword" class="input" id="inputPassword" type="password" /></span></p>
					</li>
					<li>
						<a href="#newPassword">Confirm Password</a>
						<p><span class="w"><input tabindex="4" class="input" id="inputConfirmPassword" type="password" /></span></p>
					</li>
					<li>&nbsp;</li>
					<li>	
						<p><input type="submit" value="Updates Password &rarr;"/></p>
					</li>
				</ul>
			</li>
		</ul>
		</div>
		</div>
		</form>
	
		<script type="text/javascript">
			$(document).ready(function () {
				$('ul').accordion();
			});
		</script>
		
		<script type="text/javascript">
			// <![CDATA[	
			$(document).ready(function(){				
				// Set focus to first input
				$('#currentPassword').focus();
				// Custom validator (checks if password == confirm password)
				function confirmPassword(args){
					if(args.password == args.check)
						return {valid:true}
					else
						return {valid:false, message:'Passwords does not match'}
				}
				
				// Username is required
				$('#inputPassword, #currentPassword').valid8();
				
				// Confirm password must match Password
				$('#inputConfirmPassword').valid8({
					regularExpressions: [
						{expression: /^.+$/, errormessage: 'Required'}
					],
					jsFunctions:[
						{ 'function': confirmPassword, 'values': function(){
							return {password: $('#inputPassword').val(), check: $('#inputConfirmPassword').val()}
						}}
					]
				});
				$('#currentPassword').valid8({
					ajaxRequests: [
						{ url: '../formUtilityFunctions/checkPass.php', loadingmessage: 'Checking Password...'}
					]
				});
			});	
			// ]]>
		</script>		
	</body>
</html>