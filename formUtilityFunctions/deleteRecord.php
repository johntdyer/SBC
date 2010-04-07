<html>
	<head>
		<style type="text/css">
		body {
			background-color: black !important;
			color: white;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}
		.style1 {color: #CCFF00}
		</style>
<?
			include '../functions.inc';
			$recordNumber = $_REQUEST['recordNum'];
?>
<script>
function closeAndRefresh(){
	parent.Mediabox.closerefresh();
	return false;
}
</script>
		</head>
			<body>
<?		
if(isset($_REQUEST['recordID'])){
	$delResult = delOneRecord($_REQUEST['recordID']);
	if($delResult==1){
		echo "Record Deleted<br/>";
		echo ('<input type="button" value="Close" onclick="closeAndRefresh();"/>');
	}else{
		echo "Record Not Deleted";
		echo ('<input type="button" value="Close" onclick="closeAndRefresh();"/>');
	}
}else{
	if ($recordNumber==is_numeric || $recordNumber==""){
		echo "No record number submitted";
		echo ('<input type="button" value="Close" onclick="closeAndRefresh();"/>');
		exit;
	}else {
		if (isset($_REQUEST['recordID'])){
			$rowToDelete = $_REQUEST['recordID'];
			echo $rowToDelete;
				}
		$result = getOneRecord($recordNumber);

		foreach ($result as $key => $value) {
			$id = $value['ID'];
			$firstName = $value['firstName'];
			$lastName = $value['lastName'];
			$ANI = $value['ANI'];
			$recordNotes = $value['recordNotes'];
		?>
	<table>
	<tr>
		<td><font color="red">Record No: </font></td>
		<td><? echo $id; ?></td>
	</tr>
	<tr>
		<td><font color="red">Name: </font></td>
		<td><? echo $firstName . " " . $lastName;?></td>
	</tr>
	<tr>
		<td><font color="red">Phone: </font>	</td>
		<td><?echo$ANI;?></td>
	</tr>
	<tr>		
		<td><?if(!$rejectMessage==null)?><font color="red">Record Notes: </font></td>
		<td><?echo $recordNotes;?></td>	<?}	}	?>	
	</tr>
	</table>
		<center>
			You have chosen to delete record number <?echo $recordNumber; ?><br/>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			Correct?
			<input type="hidden" name="recordID" value="<?echo $recordNumber; ?>">
				<table>
					<tr>
						<td>
							<img src="../images/yes.png"/><input type="submit" value="Delete" alt="Yes"/>
						</td>
						<td>
							<img src="../images/no.png"/><input type="button" value="Show Records" onclick="closeAndRefresh();">
						</td>
					</tr>
				</table>
			</form>
			<?		}		?>
		</center>
		</body>
	</html>