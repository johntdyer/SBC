<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="cache-control" content="no-cache"> <!-- tells browser not to cache -->
<meta http-equiv="expires" content="0"> <!-- says that the cache expires 'now' -->
<meta http-equiv="pragma" content="no-cache"> <!-- says not to use cached stuff, if there is any -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head>
		
		<link rel="stylesheet" href="css/sort.css" />
		<link rel="stylesheet" href="css/mediaboxAdvBlack.css" type="text/css" media="screen"/>
		
	<!--	<script type="text/javascript" src="js/jQuery.js"></script>-->
		<script type="text/javascript" src="js/jQueryCookie.js"></script>
		<script type="text/javascript" src="js/mootools.1.2.4.js"></script>
		<script type="text/javascript" src="js/mediaboxAdv-1.2.0.js"></script>
		<script type="text/javascript" src="js/instantEdit.js"></script>	
		
		<script type="text/javascript" charset="utf-8">
			function closeAndRefresh(){
				parent.Mediabox.closerefresh();
			//	window.location = '../index.php';
				return false;
			username = 	<?php echo ($_POST['username']); ?>
			password = <?php echo (sha1($_POST['password'])); ?>
			}
		</script>
		
		<?
		function redirectHome($msg){	?>
			<script>
				alert("<? echo $msg;?>");
				window.location="authUser.php";
			</script><?
		}
		
		include("functions.inc"); 
		$dbhandle = new SQLiteDatabase($dbPath);
		$query = $dbhandle->query('SELECT * FROM userRecords ORDER BY id DESC'); // buffered result set
		?>
		<title>Caller Records</title>
</head>
		<body>
			<table cellpadding="1" cellspacing="10" border="0" id="header">
				<tr>
				<td>	
					<img src="images/logo.png" height="35px"/>
					</td>
					<td>
					<font size="3">Application Firewall</font>
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" border="0" id="table" class="sortable">
			<thead>
			<tr>
			<!-- 
			IF YOU DONT WANT TO SORT BY ID
				<th class="nosort">
					<h3>ID</h3></th>
				<th><h3>ID</h3></th>-->
				<th><h3>Name</h3></th>
				<th><h3>Phone Number</h3></th>
				<th><h3>Record Notes</h3></th>
				<th class="nosort">
					<h3></h3></th>
			</tr>
		</thead>
		<tbody>
<?
	while ($rowx = $query->fetch(SQLITE_ASSOC)) {
		$id = $rowx['ID'];
		$firstName = $rowx['firstName'];
		$lastName = $rowx['lastName'];
		$ANI = $rowx['ANI'];
		$recordNotes = $rowx['recordNotes'];
?>
	<tr>
		<?/*<td><? echo $id; ?></td>*/?>
	<td>
		<div id="change">
			<span id="a_<? echo $id; ?>" class="editText"><?echo $rowx['firstName'] . " ";?></span>
			<span id="b_<? echo $id; ?>" class="editText"><?echo $rowx['lastName'];?></span>
		</div>
	</td>
	<td>
		<div id="change">
			<span id="c_<?echo $id;?>" class="editText"><?echo $rowx['ANI'];?></span>
		</div>
	</td>
		<td>
			<div id="change">
				<span id="d_<?echo $id;?>" class="editText">
				<?
					if($rowx['recordNotes']==NULL){	
						echo ('none');
					}	else {
						echo $rowx['recordNotes'];
					}	
				?>
				</span>
			</div>
		</td>
	<td>
		<input type="image" src="images/del.png" onClick="Mediabox.open('formUtilityFunctions/deleteRecord.php?recordNum=<? echo $id; ?>', 'Delete Record', '300 200');">Delete</a>
	</td>
   </tr>
<?	}	?>
	</tbody>
  </table>

	<div id="controls">	
			
		<div id="perpage">
			<select onchange="sorter.size(this.value)">
			<option value="5">5</option>
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
			<span>Entries Per Page</span>
		</div>
		<div id="navigation">
			<img src="images/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
			<img src="images/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
			<input type="image" src="images/add.gif"  width="16" height="16" onClick="Mediabox.open('addCaller.php', 'Add Caller', '450 500');"></a>
			<input type="image" src="images/config-icon.png"  width="16" height="16" onClick="Mediabox.open('admin/index.html', 'Add Caller', '450 500');"></a>

			<img src="images/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
			<img src="images/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
		</div>
		<div id="text">Displaying Page <span id="currentpage"></span> of <span id="pagelimit"></span>
			</div>
		
	</div>
	<script type="text/javascript" src="js/scriptSort.js"></script>
	<script type="text/javascript">
	  var sorter = new TINY.table.sorter("sorter");
		sorter.head = "head";
		sorter.asc = "asc";
		sorter.desc = "desc";
		sorter.even = "evenrow";
		sorter.odd = "oddrow";
		sorter.evensel = "evenselected";
		sorter.oddsel = "oddselected";
		sorter.paginate = true;
		sorter.currentid = "currentpage";
		sorter.limitid = "pagelimit";
		sorter.init("table",1);
  </script>
<script type="text/javascript">
setVarsForm("pageID=profileEdit&userID=<?echo $id;?>&sessionID=<?echo $rowx['id'];?>");
</script>
</body>
</html>