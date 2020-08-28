<?php
include("database_connection.php");
include("functions.php");

if ( isset($_GET['delete']) && !empty($_GET['delete']) ) {
	
	$delete_id = (int)$_GET['delete'];
	//$query = query("DELETE FROM `tbl_products` WHERE product_id = $delete_id");
	$query = query("DELETE FROM tbl_products WHERE product_id = " . escape_string($_GET['delete']) . " ");
 	confirmation($query);
	
 	set_msg("Product Deleted");
 	header("Location:index.php");
}

?>