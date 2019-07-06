<?php
	include '../db.php';
	
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	// $itemid = isset($_POST['itemid']) ? mysql_real_escape_string($_POST['itemid']) : '';
	// $productid = isset($_POST['productid']) ? mysql_real_escape_string($_POST['productid']) : '';
	
	$offset = ($page-1)*$rows;
	
	$result = array();
	
	// $where = "itemid like '$itemid%' and productid like '$productid%'";
    $where= "1 or 1";
	$rs = mysqli_query($link,"select count(*) from pagus where " . $where);
	$row = mysqli_fetch_row($rs);
	$result["total"] = $row[0];
	
	$rs = mysqli_query($link,"select * from pagus where " . $where . " limit $offset,$rows");
	
	$items = array();
	while($row = mysqli_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	
	echo json_encode($result);
?>