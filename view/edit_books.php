<?php
include '../control/edit_books_process.php';
?>
<html>
    <head>
        <title>Edit Book</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <h2>Edit Book</h2>
        <form name = "book_form" action = "" method = "post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            Title: <input type = "text" name ="title" value="<?php echo $title; ?>"><span style="color: red;"><?php echo $titleError; ?></span><br><br>
            Author: <input type = "text" name ="author" value="<?php echo $author; ?>"><span style="color: red;"><?php echo $authorError; ?></span><br><br>
            Description: <input type = "text" name ="description" value="<?php echo $description; ?>"><span style="color: red;"><?php echo $descriptionError; ?></span><br><br>
            Price: <input type = "text" name ="price" value="<?php echo $price; ?>"><span style="color: red;"><?php echo $priceError; ?></span><br><br>
            Category:<select name="category">
            <option value="">-- Select Category --</option>
            <?php foreach($categories as $cat){ ?>
            <option value="<?php echo $cat['ID']; ?>" 
            <?php if($categoryID == $cat['ID']) echo 'selected'; ?>>
            <?php echo $cat['Name']; ?>
            </option>
            <?php } ?>
            </select><span style="color: red;"><?php echo $categoryError; ?></span><br><br>
            Image: <input type = "file" name ="image"><span style="color: red;"><?php echo $imageError; ?></span><br><br>
            Stock: <input type = "text" name ="stock" value="<?php echo $stock; ?>"><span style="color: red;"><?php echo $stockError; ?></span><br><br>
            <input type = "submit" name = "Submit" value = "Edit Book">
        </form>
</html>