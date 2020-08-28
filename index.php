<?php   
  include("navigation_bar.php");
?>
<div id="layoutSidenav_content">
      <main>
       
              <!-- table -->
                    <div class="container-fluid">
                        <h2 class="mt-4">Tables</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                          
                        </div>
                        <h3 class="bg-warning text-secondary text-center" id="message"><?php display_msg(); ?></h3>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Product Details
                                <a href="add_products.php"><button type="button" class="btn btn-primary float-right"><svg width="1.3em" height="1.3em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                                <path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                              </svg>Add Product</button></a>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>MRP</th>
                                                <th>Discount</th>
                                                <th>Price</th>
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       <!--  <tfoot>
                                            <tr>
                                                 <th>Id</th>
                                                <th>Product Name</th>
                                                <th>Brand</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>MRP</th>
                                                <th>Discount</th>
                                                <th>Price</th>
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot> -->
                                        <tbody>
                                            
                                            <?php get_product_info();?>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
          $('#dataTable').DataTable();
        });          
    
	    //Delete Product 
	    $(document).ready(function(){
	      $("#remove").click(function(){
	      var alert_message;

	      location.reload();
	      return alert_message = confirm("Are you sure! You Want To Delete This Product.");
	        });
	    });

		//hide message after 3sec
	    setTimeout(function() {
	       document.getElementById("message").style.display = 'none';
	    }, 3000);

        </script>

            </div>
          </div>
        

              <!-- row -->
           
        </main>
      </div>
