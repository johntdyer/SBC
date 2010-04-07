<?php
include 'functions.inc'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/view.css" media="all" />
		
		<script type="text/javascript" src="js/view.js"></script>
			<link rel="stylesheet" href="css/mediaboxAdvBlack.css" type="text/css" media="screen"/>

		<script type="text/javascript" src="js/myFunctions.js"></script>
		<script type="text/javascript" src="js/mootools.1.2.4.js"></script>
		<script type="text/javascript" src="js/mediaboxAdv-1.2.0.js"></script>

<style type="text/css">
 #form_container
 {
width:350px;
height:450px;
}
</style>

	</head>
	<body id="main_body">
<br/>
		<div id="form_container">
			<form id="editRecord" class="appnitro" method="post" action="formUtilityFunctions/updateRecord.php">
<!--
@@@@@@@@@@@@@@@@@@@@@
Match Phone Number
@@@@@@@@@@@@@@@@@@@@@
-->
					<li id="li_2">
						<label class="description" for="element_2">Phone</label>
						<span>
							<input id="ANI_1" name="ANI_1" class="element text" size="3" maxlength="3" value="" type="text" /> - <label for="element_2_1">(###)</label></span> <span>
							<input id="ANI_2" name="ANI_2" class="element text" size="3" maxlength="3" value="" type="text" /> - <label for="element_2_2">###</label></span> <span>
							<input id="ANI_3" name="ANI_3" class="element text" size="4" maxlength="4" value="" type="text" /> <label for="element_2_3">####</label></span>
						<p class="guidelines" id="guide_2">
							<small>ANI</small>
						</p>
					</li>
<!--
@@@@@@@@@@@@@@@@@@@@@
Name
@@@@@@@@@@@@@@@@@@@@@
-->
				<li id="name">
					<label class="description" for="element_3">Name</label> <span>
						<input id="firstName" name="firstName" class="element text" maxlength="255" size="8" value="" /> <label>First</label></span> <span>
						<input id="lastName" name="lastName" class="element text" maxlength="255" size="8" value="" /> <label>Last</label></span>
						<p class="guidelines" id="guide_3">
							<small>Used for record identification, optional</small>
						</p>
					</li>
<!--
 @@@@@@@@@@@@@@@@@@@@@
	Notes
 @@@@@@@@@@@@@@@@@@@@@
-->

				<li id="notes">
					<label class="description" for="element_3">Notes (Optional)</label> <span>
						<textarea rows="3" cols="20" name="recordNotes" class="element text" wrap="physical"></textarea><label></label></span><br />
						<p class="guidelines" id="guide_4">
							<small>Optional notes</small>
						</p>
					</li>

<!--
 @@@@@@@@@@@@@@@@@@@@@
	Submit
 @@@@@@@@@@@@@@@@@@@@@
-->
				<li class="buttons">
				 	<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit"/>
				</li>
			</ul>
		</form>
	</div>
	</body>
</html>
