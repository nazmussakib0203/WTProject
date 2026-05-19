<?php
include '../control/create_books_process.php';
?>
<html>
    <title>Create Book</title>
    <body>
        <h2>Create Book</h2>
        <form name = "book_form" action = "" method = "post" enctype="multipart/form-data" onsubmit="return validateForm()">
            Title: <input type = "text" id="title" name ="title"><span style="color: red;"><?php echo $titleError; ?></span><br></br>
            Author: <input type = "text" id="author" name ="author"><span style="color: red;"><?php echo $authorError; ?></span><br><br>
            Description: <input type = "text" id="description" name ="description"><span style="color: red;"><?php echo $descriptionError; ?></span><br><br>
            Price: <input type = "text" id="price" name ="price"><span style="color: red;"><?php echo $priceError; ?></span><br><br>
            Category:
<select id="category" name="category">
    <option value="">-- Select Category --</option>
    <?php foreach($categories as $cat){ ?>
        <option value="<?php echo $cat['ID']; ?>">
            <?php echo $cat['Name']; ?>
        </option>
    <?php } ?>
</select><span style="color: red;"><?php echo $categoryError; ?></span><br><br>
            Image: <input type = "file" id="image" name ="image"><span style="color: red;"><?php echo $imageError; ?></span><br><br>
            Stock: <input type = "text" id="stock" name ="stock"><span style="color: red;"><?php echo $stockError; ?></span><br><br>
            <input type = "submit" name = "Submit" value = "Create Book">
        </form>
        <span style="color: Red;" id = "formError"></span>
        <script src = "../js/create_books_validation.js"></script>
        </body>
</html>