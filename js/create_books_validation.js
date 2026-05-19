function validateForm() {
    var title = document.getElementById("title").value;
    var author = document.getElementById("author").value;
    var description = document.getElementById("description").value;
    var price = document.getElementById("price").value;
    var category = document.getElementById("category").value;
    var image = document.getElementById("image").files[0];
    var stock = document.getElementById("stock").value;

    if(title === "" || author === "" || description === "" || price === "" || category === "" || !image || stock === "") {
        document.getElementById("formError").innerHTML="All fields must be filled out";
        return false;
    }
    if(price <= 0) {
        document.getElementById("formError").innerHTML="Price must be a positive number";
        return false;
    }
    if(image){
         var imageTypes = ['image/jpeg', 'image/png'];
         if(!imageTypes.includes(image.type)) {
             document.getElementById("formError").innerHTML="Image must be a JPEG or PNG file";
             return false;
         }
         if(image.size > 2 * 1024 * 1024) {
             document.getElementById("formError").innerHTML="Image size must be less than 2MB";
             return false;
         }

    }
    return true;
    }
  