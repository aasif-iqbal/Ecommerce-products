function formValidation(){

 var product_name              = document.getElementById('product_name').value;
 var product_short_description = document.getElementById('product_short_description').value;
 var product_description       = document.getElementById('product_full_description').value;
 var product_mrp               = document.getElementById('mrp').value;
 var product_discount          = document.getElementById('discount').value;
 var product_quantity          = document.getElementById('product_quantity').value;

 var regex_product_name              = /^[A-Za-z- ]{3,50}$/;
 var regex_product_short_description = /^[A-Za-z-& ]{5,70}$/;
 var regex_product_mrp               = /^[0-9.]{1,10}$/;
 var regex_product_discount          = /^[0-9.]{1,2}$/;
 var regex_product_quantity          = /^[0-9]{1,5}$/;

 if (regex_product_name.test(product_name)) {
  document.getElementById('error').innerHTML = " ";
}else{
  document.getElementById('error').innerHTML = "**Invalid Product Name.";
  return false;
}  

if (regex_product_short_description.test(product_short_description)) {
 document.getElementById('error_1').innerHTML = "";
} else {
 document.getElementById('error_1').innerHTML = "**Invalid Product Short description.";
 return false;
}   

if (regex_product_mrp.test(product_mrp)) {
  document.getElementById('Invalid_mrp').innerHTML = "";
}else{
  document.getElementById('Invalid_mrp').innerHTML = '**Invalid MRP';
  return false;
}

if (regex_product_discount.test(product_discount)) {
  document.getElementById('Invalid_discount').innerHTML = "";
}else{
  document.getElementById('Invalid_discount').innerHTML = '**Invalid Discount %';
  return false;
}

if (regex_product_quantity.test(product_quantity)) {
  document.getElementById('invalid_quantity').innerHTML = "";
}else{
  document.getElementById('invalid_quantity').innerHTML = '**Invalid Quantity';
  return false;
}

  // if (product_description.value == '') {
  //    document.getElementById('Invalid_product_description').innerHTML = "";
  //  }else{
  //    document.getElementById('Invalid_product_description').innerHTML = "**Invalid Product description.";
  //    return false;
  //  }

     //dropdown category
     var e = document.getElementById("parent_category");

     var optionSelIndex = e.options[e.selectedIndex].value;
     var optionSelectedText = e.options[e.selectedIndex].text;
     if (optionSelIndex == 0) {

      document.getElementById('error_cat').innerHTML = "**Please select a Category.";
      return false;
    }
    document.getElementById('error_cat').innerHTML = "";
        // else {
        //     alert("Success !! You have selected Category : " + optionSelectedText); ;
        // }

      //dropdown brand
      var e = document.getElementById("product_brand_id");

      var optionSelIndex = e.options[e.selectedIndex].value;
      var optionSelectedText = e.options[e.selectedIndex].text;
      if (optionSelIndex == 0) {

        document.getElementById('Invalid_brand').innerHTML = "**Please select a Brand.";
        return false;
      }
      document.getElementById('Invalid_brand').innerHTML = "";
        // else {
        //     alert("Success !! You have selected brand : " + optionSelectedText); ;
        // }

      //radio button for color
      var radios = document.getElementsByName("product_color");
      var formValid = false;

      var i = 0;
      while (!formValid && i < radios.length) {
        if (radios[i].checked) formValid = true;
        i++;        
      }
      if (!formValid){
        alert("Select Product Color");
        return false;
      }
//return formValid;


  //checkbox of size
  var chkBox = document.getElementsByName("product_size[]");
  var lenChkBox = chkBox.length;
   // alert(lenChkBox);
   var valid=0;
   for(var i=0;i<lenChkBox;i++) {
    if(chkBox[i].checked==true) {
      valid=1;
      break;
    }
  }
  if(valid==0) {
    document.getElementById('Invalid_size').innerHTML = "** Please Select Product Size";
    return false;
  }
  document.getElementById('Invalid_size').innerHTML = "";
    //return true;

}//end-of-validation

function Upload() {

  alert("Image Dimension Must Be 200x300.Otherwise It will set Default Image");
    //Get reference of FileUpload.
    var fileUpload = document.getElementById("file");
    
    //Move image-file to folder
    imgData = getBase64Image(fileUpload);
    localStorage.setItem("image", imgData);
    
    //Check whether the file is valid Image.
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
    
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();

                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;

                //Validate the File Height and Width.
                image.onload = function () {
                  var height = this.height;
                  var width = this.width;
                  if (height > 200 || width > 300) {
                    alert("Height and Width must not exceed 200X300.");
                    return false;
                  }
                  alert("Uploaded image has valid Height and Width.");
                  return true;
                };
              }
            } else {
              alert("This browser does not support HTML5.");
              return false;
            }
          } else {       
            alert("Please select a valid Image file.");
            return false;
          }
    }

  //Display_Child Category
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

