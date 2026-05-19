<html>
    <head>
        <title>Listed Books</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
    </head>
    <body>
        <table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Price</th>
            <th>Category</th>
            <th>Image</th>
            <th>Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php include '../control/listed_books_process.php'; ?>
    </tbody>
        </table>
    </body>
</html>