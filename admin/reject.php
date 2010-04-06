<script type="text/javascript" src="../js/instantEdit.js"></script>
<script type="text/javascript">
function closeAndRefresh(){
	parent.Mediabox.closerefresh();
	return false;
}
function showRedirectURL() {
    document.getElementById("redirectURL").style.display = "block"
  //  document.getElementById("defaultMSG").style.display = "none"
}

function showDefault() {
//	document.getElementById("accpetCall").style.display = "none"
    document.getElementById("rejectMsg").style.display = "none"
}

function ShowHide() {
    if (document.getElementById('checkbox1').checked == true) {
        document.getElementById('divRB').style.visibility = "visible"
    } else if (document.getElementById('checkbox1').checked == false) {
        document.getElementById('divRB').style.visibility = "hidden";
    }
}
</script>

<font color="red"> How do you want to reject these calls?</font>
<br/><input type="button" onclick="closeAndRefresh();" value="busy"/>
<br/><input type="button" onClick="showRedirectURL();" value="redirect"/>
<div id="change">
	
	
<span id="a_1" class="editText">
	
	<input type="textbox" id="redirectURL" name="rejectMsg" style="display: none" class="element" value="reject"/>
</span>
</div>
