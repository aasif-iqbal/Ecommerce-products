<?php
	include('database_connection.php');
	$upload_directory = "image"; 

	ob_start();		//ob_start() turns on output buffering.

	if (!isset($_SESSION)) {
  		session_start();
	}
	//session_destroy();


	function query($sql){
		global $connection;
		return mysqli_query($connection, $sql) or die("Error: " . mysqli_error($connection));
	}

	function set_msg($msg){

		if(!empty($msg)) {
			$_SESSION['message'] = $msg;
		}else{
			$msg = "";
		}
	}

	function display_msg(){

		if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
			echo($_SESSION['message']);
			unset($_SESSION['message']);
		}
	}

	function redirect($location){
		header("Location:$location");
	}

	function confirmation($result){

		global $connection;
			if (!$result) {
			die("Query failed:".mysqli_error($connection));
		}
	}

	function escape_string($string){

		global $connection;

		return  mysqli_real_escape_string($connection, $string);

	}

	function fetch_array($result){

		return mysqli_fetch_array($result);
	}

	function display_image($picture){

	global $upload_directory;

	return $upload_directory . DS . $picture;
		
}

	//child categories
	function getSubCategories($id){
		global $connection;

		  	$parent_query = "SELECT * FROM `tbl_categories` WHERE parent_category_id=?";
	      	$stmt = $connection->prepare($parent_query);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result(); // get the mysqli result
			//$categories = $result->fetch_assoc(); // fetch data

	 	  return $result;  //mysqli_result Object
	}

if (isset($_GET['parent_category_id']) && $_GET['parent_category_id'] != '') {
	global $connection;

	$parent_category_id = $_GET['parent_category_id'];
	$subcat = getSubCategories($parent_category_id);
	$dropdownlist = '';
	if (!empty($subcat)) {
				foreach ($subcat as $row) {
					$dropdownlist .= '<option value="'.$row['category_id'].'">'.$row['category_name'].'</option>';
				}
			}
	echo $dropdownlist;
	exit();
}

function show_brands_add_product_page(){
global $connection;
  $query = "SELECT * FROM `tbl_brands`";
  confirmation($query);
  $result = mysqli_query($connection, $query) or die( mysqli_error($connection));

  foreach ($result as $row) {

$brand_options = <<<DELIMETER
<option value="{$row['brand_id']}">{$row['brand_name']}</option>
DELIMETER;

echo $brand_options;
	}

}

function show_size_add_product_page(){
	global $connection;
	$query = "SELECT * FROM `tbl_sizes`";
	confirmation($query);
	$result = mysqli_query($connection, $query) or die( mysqli_error($connection));

	foreach ($result as $row) {
		$size_options = <<<DELIMETER
		<div class="form-check">
		<input class="form-check-input" type="checkbox" name="product_size[]" value="{$row['size_name']}" id="product_size_id" onchange="Filevalidation()">
		<label class="form-check-label" for="defaultCheck1">{$row['size_name']}</label>
		</div>
DELIMETER;
	echo $size_options;
		}
}

function show_color_add_product_page(){
	global $connection;
	$query = "SELECT * FROM `tbl_colors`";
	confirmation($query);
	$result = mysqli_query($connection, $query) or die( mysqli_error($connection));

	foreach ($result as $row) {
		$color_options = <<<DELIMETER
		<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="product_color" id="inlineRadio1" value="{$row['color_name']}">
        <label class="form-check-label" for="inlineRadio1">{$row['color_name']}</label>
        </div>
DELIMETER;
	echo $color_options;
		}
}

function generate_model_no($chars)
{
	$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  return substr(str_shuffle($data), 0, $chars);
}

function add_products(){
	global $connection;
    global $mysqli;

	if (isset($_POST["add"])) {

	$product_parent_cat_id     = escape_string($_POST['product_parent_cat_id']);
	$product_child_cat_id	   = escape_string($_POST['product_child_cat_id']);
	$product_brand_id		   = escape_string($_POST['product_brand_id']);
	$product_name              = escape_string($_POST['product_name']);
	$product_short_description = str_replace("\n\r", "", $_POST['product_short_description']);
	$product_description  	   = str_replace("\n\r", "", $_POST['product_description']);
	$product_mrp               = escape_string($_POST['product_mrp']);
	$product_discount		   = escape_string($_POST['product_discount']);
	$product_actual_price	   = escape_string($_POST['product_actual_price']);
	$product_quantity		   = escape_string($_POST['product_quantity']);
	$product_model_no		   = escape_string($_POST['product_model_no']);
	$product_color			   = escape_string($_POST['product_color']);
	$product_size			   = $_POST['product_size'];

	$size = "";
	foreach ($product_size as $temp_size) {
		$size .=$temp_size.",";
	}
	$size = rtrim($size,','); 		//remove last comma

	//image upload
	$fileinfo = @getimagesize($_FILES["file"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];

    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );

    // Get image file extension
    $file_extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file"]["tmp_name"])) {

        set_msg("Choose image file to upload.");
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {

         set_msg("Upload valiid images. Only PNG and JPEG are allowed.");

    }    // Validate image file size
    else if (($_FILES["file"]["size"] > 4000000)) {

        set_msg("Image size exceeds 4MB");
    }    // Validate image file dimension
    else if ($width > "200" || $height > "300") {
        set_msg("Image dimension should be within 200X300.");
    } else {
        $target = "image/" . basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target)) {
            set_msg("Image uploaded successfully.");
        } else {
            set_msg("Problem in uploading image files.");
        }         
    }
	if(file_exists($target)){
    	$product_image = escape_string($target);
    	//var_dump($product_image);
	}
	else{
    $product_image = "image/default.png";
   }

    $stmt = mysqli_prepare($connection,
			"INSERT INTO `tbl_products`
				(product_parent_cat_id,product_child_cat_id,product_brand_id,product_name,product_short_description,product_description,product_mrp,product_discount,product_actual_price,product_quantity,product_model_no,product_color,product_size,product_image) VALUES (?,?, ?,?,?,?,?,?,?,?,?,?,?,?)");


		if ( false===$stmt ) {
		  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
		}

			$rc = $stmt->bind_param( "iiisssdidissss", $product_parent_cat_id,$product_child_cat_id,$product_brand_id,$product_name,$product_short_description,$product_description,$product_mrp,$product_discount,$product_actual_price,$product_quantity,$product_model_no,$product_color,$size,$product_image);

		if ( false === $rc ) {
  		die('bind_param() failed: ' . htmlspecialchars($stmt->error));
		}

		$rc = $stmt->execute();

		if ( false === $rc ) {
		  die('execute() failed: ' . htmlspecialchars($stmt->error));
		}

		$stmt->close();

		set_msg("New Product Added");
		header('Location: add_products.php');
	}
}


// display table

function show_product_cat_title($product_category_id){
 global $connection;
	//	echo($product_category_id);die();

	$query = "SELECT * FROM `tbl_categories` WHERE category_id = '$product_category_id'";
	confirmation($query);

	$result = mysqli_query($connection, $query) or die( mysqli_error($connection));

	foreach ($result as $row) {
	 
	 return $row['category_name'];	
	 }
	
}

function show_product_brand_name($product_brand_id){
global $connection;
	//echo($product_category_id);die();

	$query = "SELECT * FROM `tbl_brands` WHERE brand_id = '$product_brand_id' ";
	confirmation($query);
	$result = mysqli_query($connection, $query) or die( mysqli_error($connection));

	foreach ($result as $row) {
	
		return $row['brand_name'];
	}
}

// table
function get_product_info(){
	global $connection;

	$query = "SELECT * FROM `tbl_products`";
	$result = mysqli_query($connection, $query) or die( mysqli_error($connection));

	foreach ($result as $row) {

		$brand = show_product_brand_name($row['product_brand_id']);
		$category = show_product_cat_title($row['product_parent_cat_id']);

		$product_in_admin = <<<DELIMETER
		<tr>
	        <td>{$row['product_id']}</td>
	        <td>{$row['product_name']}</td>
	        <td>$brand</td>
	        <td>$category</td>
	        <td>{$row['product_quantity']}</td>
	        <td>Rs.{$row['product_mrp']}</td>
	        <td>{$row['product_discount']}%</td>
	        <td>Rs.{$row['product_actual_price']}</td>
	        <td>{$row['product_size']}</td>
	        <td>{$row['product_color']}</td>	        
        <td>           
          <a href="delete.php?delete={$row['product_id']}">
          <button type="submit" class="btn btn-danger" id="remove" data-toggle="modal" data-target="#parent_model">
            
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg>
          </button>
        </a>
        </td>
	</tr>                                        
DELIMETER;
	echo($product_in_admin);
		
	}
}

//display_product in product page
function display_product(){
	global $connection;

	$query = "SELECT * FROM `tbl_products`";
	$result = mysqli_query($connection, $query) or die( mysqli_error($connection));
	
	foreach ($result as $row) {
	$product_image = display_image($row['product_image']);
	$brand_name = show_product_brand_name($row['product_brand_id']);

		$product = <<<DELIMETER
		  <div class="card mx-4 my-4" style="width: 18rem;">
 			 <div class="card-img-overlay d-flex justify-content-end">
	          <a href="#" class="card-link text-danger like">
	            <i class="fas fa-heart"></i>
	          </a>
  		  </div>
  <img class='mx-auto'  src="{$row['product_image']}" width="auto" height="auto" />		  
  <div class="card-body">
  <h5 class="card-title text-muted">{$brand_name}</h5>    
    <h6 class="card-subtitle">{$row['product_name']}</h6>    
    <div class="price">
      <span class="mt-2 text-success">Rs.{$row['product_actual_price']}</span> &nbsp;
      <span class="mt-2 text-secondary"><s>Rs.{$row['product_mrp']}</s></span> &nbsp;
      <span class="mt-2 text-warning">({$row['product_discount']}%OFF)</span> 
    </div>
   <div class="mt-1">Size:&nbsp;<span>{$row['product_size']}</span></div>
  </div>
</div>
DELIMETER;
	echo($product);		
	}		
}

?>