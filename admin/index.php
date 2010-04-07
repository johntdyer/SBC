<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<script type="text/javascript" src="../js/instantEdit_ADMIN.js"></script>
		
		<script src="../js/jquery2.js" type="text/javascript"></script>
		<script src="../js/ui.core.js" type="text/javascript"></script>
        
		<!-- optional for High Contrast Mode Support -->
		<script src="../js/jquery.usermode.js" type="text/javascript"></script>
		
		<script src="../js/jquery.bind.js" type="text/javascript"></script>
		<script src="../js/ui.checkbox.js" type="text/javascript"></script>
        
        <style type="text/css">
             {
							padding: 0;
							margin: 0;
						}
						html {
							font-family: Arial, Helvetica, sans-serif;
						}
						#wrapper {
						    width: 20em;
						    margin: 10px auto;
						    padding: 10px;
						    border: 1px solid #000;
						}
			.ui-radio-state-disabled,
			.ui-radio-state-checked-disabled,
			.ui-radio-state-disabled-hover,
			.ui-radio-state-checked-disabled-hover {
				color: #999;
			}
			span.ui-checkbox,
			span.ui-radio {
				display: block;
				float: left;
				width: 16px;
				height: 16px;
				background: url(../images/icon_checkbox.png) 0 -40px no-repeat;
			}
			span.ui-helper-hidden {
				display: none;
			}
			label {
				padding: 2px;
				
			}
			span.ui-radio-state-hover,
		
			span.ui-radio-state-checked-disabled-hover,
			span.ui-radio-state-checked-disabled,
			span.ui-radio-state-checked {
				background-position: 0 -161px;
			}
			span.ui-radio-state-checked-hover {
				background-position: 0 -200px;
			}
        </style>
				<script type="text/javascript">
					$(function(){
						$('input').checkBox();
							$('#check-2').click(function(){
								$('#example input[type=radio]:eq(1)').checkBox('changeCheckStatus', true);
								return false;
							});
				
							$('#native').click(function(){
								//native methods
								$('#example input[type=radio]:eq(0)').attr({checked: true, disabled: true})
								//reflect the current state
								.checkBox('reflectUI');
								return false;
				 			});
						});
			</script>
		<style>
			form {
				overflow: hidden;
				height: 1%;
				margin: 20px 0;
			}
			
			fieldset {
				padding: 10px;
				color: #fff;
				background: #0F1316;
			}
			
			.ui-helper-hidden-accessible {
				position: absolute;
				left: -999em;
			}
			table {
				margin: 10px 0;
				border-collapse: collapse;
				width: 100%;
			}
			caption {
				text-align: left;
			}
			th,
			td {
				border: 1px solid #000;
			}
		</style>
		<? 
		include ('../functions.inc'); 
		$id = uniqid();
			
		function redirectHome($msg){
		?>
			<script>
				alert("<? echo $msg;?>");
				window.location="http://127.0.0.1:9990/SBC/authUser.php";
			</script>
		<?
		}

		if (isset($_COOKIE['VoxeoSBCusername']) && isset($_COOKIE['VoxeoSBCpassword'])) {
			if((checkUsername($_COOKIE['VoxeoSBCusername'])) || (checkPasswordSha1($_COOKIE['VoxeoSBCpassword']))){
		
		?>
		


		<script type="text/javascript">
		function closeAndRefresh(){
			parent.Mediabox.closerefresh();
			return false;
		}
		function displayHidden(v) {

			if(v=='rejectURL'){
				document.getElementById("a_rejectRedirectURL").style.display = "block"
				document.getElementById("a_acceptRedirectURL").style.display = "none"				
	    	setBusyValue(false);			
				
			}else if(v=='acceptURL'){
    	document.getElementById("a_rejectRedirectURL").style.display = "none"	
			document.getElementById("a_acceptRedirectURL").style.display = "block"
			setBusyValue(false);			
			
			}else if(v=='busy'){
				document.getElementById("a_acceptRedirectURL").style.display = "none"	
	    	document.getElementById("a_rejectRedirectURL").style.display = "none"	
				setBusyValue(true);			
		//		alert("This will reject any matches with a fast busy");
			}
		}
		
		function setBusyValue(v){
			if(v==true){
				$.post("updateURL.php",{rejectWithBusy: "true"});
			}else if(v==false){
				$.post("updateURL.php",{rejectWithBusy: "false"});
			}
		}		
		</script>
		
	</head>
	<body>
		<div id="wrapper">
			<form action="#">
				<fieldset>
					<div><input name="radio" id="c4" type="radio" onclick="displayHidden('rejectURL');"/> <label for="c4">Reject Matches&nbsp;(RecectURL)</label></div>
					<div><input name="radio" id="c5" type="radio" onclick="displayHidden('busy');"/> <label for="c5">Reject Matches&nbsp;&nbsp;(Busy [SIP/603])</label></div>
					<div><input name="radio" id="c6" type="radio" onclick="displayHidden('acceptURL');"/> <label for="c6">Accept Matches&nbsp;(AcceptURL)</label></div>
					
					<div id="change">		
						<span id="a_rejectRedirectURL" style="display: none" class="editText">
							<? echo trim(getRedirectURL('reject'));	?>
						</span>
					</div>			
				
					<div id="change">			
						<span id="a_acceptRedirectURL" style="display: none" class="editText">
							<? echo trim(getRedirectURL('accept'));	?>					
						</span>
					</div>
						<br/>
						<input type="button" id="closeButton" name="closeButton" value="Close Window" style="display: block" onClick="closeAndRefresh();" class="element" />
					</fieldset>
		 			
			</form>
			<script type="text/javascript">
			setVarsForm("pageID=profileEdit&userID=<?echo $id;?>&sessionID=<? echo id; ?>");
			</script>
			<?
		} else {
					?>
					<script>
						alert("Invalid Password");
						parent.Mediabox.closerefresh();
					</script>
					<?
		}
	}
		?>
	</body>
</html>
</div>
