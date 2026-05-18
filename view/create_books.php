<?php
include '../control/create_books_process.php';
?>
<html>
    <title>Create Book</title>
    <body>
        <h2>Create Book</h2>
        <form name = "book_form" action = "" method = "post" enctype="multipart/form-data">
            Title: <input type = "text" name ="title"><span style="color: red;"><?php echo $titleError; ?></span><br><br>
            Author: <input type = "text" name ="author"><span style="color: red;"><?php echo $authorError; ?></span><br><br>
            Description: <input type = "text" name ="description"><span style="color: red;"><?php echo $descriptionError; ?></span><br><br>
            Price: <input type = "text" name ="price"><span style="color: red;"><?php echo $priceError; ?></span><br><br>
            Category:<select name = "category">
                <option value = "fiction">Fiction</option>
                <option value = "non-fiction">Non-Fiction</option>
                <option value = "science">Science</option>
                <option value = "history">History</option>
            </select><span style="color: red;"><?php echo $categoryError; ?></span><br><br>
            Image: <input type = "file" name ="image"><span style="color: red;"><?php echo $imageError; ?></span><br><br>
            Stock: <input type = "text" name ="stock"><span style="color: red;"><?php echo $stockError; ?></span><br><br>
            <input type = "submit" name = "Submit" value = "Create Book">
        </form>
</html>