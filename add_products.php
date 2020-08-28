  <?php 
  include("navigation_bar.php");
    $categoriesList = getSubCategories(0);
    $model_no = generate_model_no(7);
    add_products(); 
  ?>

    <style type="text/css">
        .image-preview{
          width: 300px;
          min-height: 200px;
          border: 2px solid #dddddd;
          margin-top: 10px;

          /*default text*/
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: bold;
          color: #cccccc;
        }
        .image-preview__image{
          display: none;
          width: 100%;
        }
  </style>
  
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid">
        <h2 class="mt-4">Add Products</h2>
        <ol class="breadcrumb mb-4">
          <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
          <li class="breadcrumb-item active">Add Products</li>
        </ol>

        <h3 class="bg-warning text-secondary text-center" id="message"><?php display_msg(); ?></h3>
       
        <div class="card">
          <div class="card-header">
            <!-- form -->
           
      <form action="add_products.php" method="post" enctype="multipart/form-data" name="validationForm" onSubmit="alert('Product Upload Successfully');">
            Product Information
            <button class="btn btn-danger btn-sm float-right">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
                <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
              </svg>&nbsp;&nbsp;Cancel</button>


  <!-- <input type="submit" name="add" value="save" id="add_products"> -->
              <button type="submit" name="add" id="add" onclick="return formValidation()" class="btn btn-primary btn-sm float-right mr-2">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-box-arrow-in-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M4.646 8.146a.5.5 0 0 1 .708 0L8 10.793l2.646-2.647a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0-.708z"/>
                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-1 0v-9A.5.5 0 0 1 8 1z"/>
                  <path fill-rule="evenodd" d="M1.5 13.5A1.5 1.5 0 0 0 3 15h10a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 13 4h-1.5a.5.5 0 0 0 0 1H13a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5v-8A.5.5 0 0 1 3 5h1.5a.5.5 0 0 0 0-1H3a1.5 1.5 0 0 0-1.5 1.5v8z"/>
                </svg>&nbsp;&nbsp;Save</button>

            </div>
            <div class="card-body">
          
                <div class="form-row">
                  <!-- data-toggle="tooltip" data-placement="top" title="Minimum 3 Character." -->
                  <div class="col-8 p-3">
                    <label data-toggle="tooltip" data-placement="right" title="Must be more then 5 Character">Product Name</label>
                    <input type="text" class="form-control" id="product_name" required="required" 
                    name="product_name" placeholder="Product Name">
                    <span id="error" style="font-size: 14px;" class="text-danger"></span>
                  </div>
                  
                    
                    <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Select Category</label>
                      <select class="custom-select mr-sm-2 selectCategory" name="product_parent_cat_id" data-name="child_category" id="parent_category">
                        <option value="0">Choose...</option>
                        <?php
                        if (!empty($categoriesList)) {
                          foreach ($categoriesList as $row) {
                  echo '<option value="'. $row["category_id"] .'">'. $row["category_name"] .'</option>';
                          }
                        }
                        ?>
                      </select>
                      <span id="error_cat" style="font-size: 14px;" class="text-danger"></span>
                    </div>

                    <div class="col-8 p-3">
                    <label for="product-title" data-toggle="tooltip" data-placement="right" title="Must be more then 20 Character">Product Short Description</label>
                    <input type="text" class="form-control" id="product_short_description" name="product_short_description" placeholder="Product Short Description">
                    <span id="error_1" style="font-size: 14px;" class="text-danger"></span>
                  </div>
                    
                    <div class="col my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Select Sub-Category</label>
                      <select class="custom-select mr-sm-2" name="product_child_cat_id" id="child_category">
                        <option value="">Choose...</option>
                      </select>
                    </div>

                    <div class="col-8 p-3">
                        <label for="product-title">Product Description</label>
                        <textarea class="form-control ckeditor" name="product_description" id="product_full_description" cols="" rows=""></textarea>
                        <span id="Invalid_product_description" style="font-size: 14px;" class="text-danger"></span>
                    </div>

                    
                     <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Select Brand</label>
                      <select class="custom-select mr-sm-2"  name="product_brand_id" id="product_brand_id">
                        <option value="">Choose...</option>
                        <?php show_brands_add_product_page(); ?>
                      </select>
                      <span id="Invalid_brand" style="font-size: 14px;" class="text-danger"></span>
                    </div>

                    <div id="records_contant"></div>
                    <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">MRP (&#8377;)</label>
                      <input type="number" name="product_mrp" id="mrp" class="form-control" placeholder="MRP">
                      <span id="Invalid_mrp" style="font-size: 14px;" class="text-danger"></span>
                    </div>

                    <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Discount (&#37;)</label>
                      <input type="number" name="product_discount" id="discount" class="form-control" placeholder="Discount">
                      <span id="Invalid_discount" style="font-size: 14px;" class="text-danger"></span>
                    </div>


                    <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Actual Price (&#8377;)</label>
                    <input readonly type="number" name="product_actual_price" value="<?= round($product_price,2) ?>" class="form-control" placeholder="Actual Price">                 
                  </div>

                  <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Product Quantity</label>
                    <input type="text" class="form-control" id="product_quantity" placeholder="Product Quantity" name="product_quantity">
                    <span id="invalid_quantity" style="font-size: 14px;" class="text-danger"></span>

                  </div>
                  
                    <div class="col-4 my-0 p-3">
                      <label class="mr-sm-0" for="inlineFormCustomSelect">Product Code</label>
                      <input readonly type="text" name="product_model_no" class="form-control" value="<?php echo($model_no); ?>" placeholder="M8738KU">
                    </div> 

                    <div class="row p-4">
                      
                   <div class="card" style="">
                    <div class="card-header">
                      Select Color <br>
                      <span id="invalid_color" style="font-size: 14px;" class="text-danger"></span>
                    </div>
                    <div class="card-body">
                      <div class="form-check form-check-inline">
                        <?php show_color_add_product_page();?>
                      </div>
                    </div>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <div class="card" style="width: 16rem;">
                      <div class="card-header">
                        Select Size<br>
                        <span id="Invalid_size" style="font-size: 14px;" class="text-danger"></span>
                      </div>
                      <div class="card-body">
                        <!-- <h5 class="card-title">size</h5> -->
                        <div class="form-check">
                          <?php show_size_add_product_page();?>
                        </div>
                      </div>
                    </div>

                    &nbsp;&nbsp;&nbsp;&nbsp;
                 

                    <!-- <legend>Image Section</legend> -->
    
                    <!-- Product Image -->
                      
                       <div class="card  bg-light">
                    <div class="card-header">
                      Product Image<br/>
                         <span id="error_color" style="font-size: 14px;" class="text-danger"></span>
                    </div>

                    <div class="card-body">
                      <input type="file" name="file" id="file" accept="image/*" onchange="return Upload()"/>
                        <hr>
                        <div class="image-preview" id="imagePreview">
                          <img height="270px;" src="" alt="Image Preview" class="image-preview__image">
                          <span class="image-preview__default-text" data-toggle="tooltip" data-placement="bottom" title="Dim:200x300 Type:jpeg/png/jpg">Image Preview</span>
                        </div>
                      </div>
                    </div>

              </div> <!--class="row p-4"-->
            </div>
        </form>    
  </div>

  </main>
  </div>

  <script type="text/javascript">

  //tooltip
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

      //hide message
      setTimeout(function() {
         document.getElementById("message").style.display = 'none';
      }, 4000);


    $(document).ready(function(){
      $('.selectCategory').on('change', function(){
        const child_id = $(this).data('name');
        const parent_category_id = $(this).val();
        //console.log("hello");

          $.ajax({
            type:'GET',
            url:'functions.php',
            data:{'parent_category_id':parent_category_id},
            success:function(result){
              if (result.length > 0) {

                $('#'+child_id).html(result);
               // alert(result);
              }else{
                $('#'+child_id).html('');
               // alert("else"+result);
              }
            },
            error:function(){
              console.log("error");
            }
          });
        
      })
    });

  </script>
  <!-- For discount and product price -->
    <script type="text/javascript">

      $(document).ready(function(){

        $('input[name="product_discount"]').keyup(function() 
        { 
         var discount  = $('[name=product_discount]').val();
         var mrp = $('[name=product_mrp]').val();  
         var temp_percent = (discount/100) * mrp;
                       //  console.log("Temp:",temp_percent);
                       var product_actual_price = (mrp-temp_percent); 
                       //console.log("1",product_price);  
                       $('[name=product_actual_price]').val(product_actual_price); 
                       
                      var new_price = product_actual_price; 

                      //console.log("new_price:", new_price);

                       $.ajax({
                        url: "../../resources/functions.php",
                        type: 'POST',
                        dataType:'html',
                     
                        data:{ 
                          "product_actual_price": new_price  //databaseValue:inputUser
                        },
                        success: function(data, status){ 
                       //   alert("Data:"+ data);
                          //alert("Status:"+status);
                          //alert(product_price);
                          $("#records_contant").html(data);
                        }, 
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                          //alert("Status: " + textStatus); 
                          //alert("Error: " + errorThrown); 
                        } 

                      });//Ajax-end

          });
      });        
    </script>


  <script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
  </script>

  <script type="text/javascript">

        const inpFile            = document.getElementById("file");
        const previewContainer   = document.getElementById("imagePreview");
        const previewImage       = previewContainer.querySelector(".image-preview__image");
        const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");

        inpFile.addEventListener("change", function(){
          const file = this.files[0];  //console.log(file);

          if (file) {
            const reader = new FileReader();

            previewDefaultText.style.display = "none";
            previewImage.style.display       = "block";

            reader.addEventListener("load", function(){
              //console.log(this);
              previewImage.setAttribute("src", this.result);  
            });

            reader.readAsDataURL(file);

          }else{
            previewDefaultText.style.display = null;
            previewImage.style.display       = null;
            previewImage.setAttribute("src", "");  
          }

        });
        </script>          