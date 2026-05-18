<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once '../control/cart_helper.php';

$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$result = $mydb->getAllBooks($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bookstore - Home</title>
</head>
<body>

<div style="background:#333; color:white; padding:10px;">
    <a href="home.php" style="color:white;">Home</a> | 
    <a href="cart.php" style="color:white;">Cart (<span id="cart-count">0</span>)</a>
    | Welcome <?php echo $_SESSION['username']; ?>
</div>

<div style="padding:20px;">
    <h2>Search Books</h2>
    <input type="text" id="searchInput" placeholder="Search...">
    <select id="filterSelect">
        <option value="title">By Title</option>
        <option value="author">By Author</option>
        <option value="category">By Category</option>
    </select>
    <button onclick="searchBooks()">Search</button>
    <button onclick="location.reload()">Show All</button>

    <div id="results">
        <h3>All Books:</h3>
        <?php while($book = $result->fetch_assoc()): ?>
            <div style="border:1px solid #ccc; margin:10px; padding:10px;">
                <h3><?php echo $book['Title']; ?></h3>
                <p>Author: <?php echo $book['Author']; ?></p>
                <p>Price: $<?php echo $book['Price']; ?></p>
                <p>Stock: <?php echo $book['Stock']; ?></p>
                <a href="book_detail.php?id=<?php echo $book['ID']; ?>">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
function updateCartCount() {
    fetch('../control/cart_count_process.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-count').innerText = data.count;
        });
}

function searchBooks() {
    let q = document.getElementById('searchInput').value;
    let filter = document.getElementById('filterSelect').value;
    
    if(q == '') {
        alert('Please enter search keyword');
        return;
    }
    
    fetch(`../control/search_process.php?q=${q}&filter=${filter}`)
        .then(res => res.json())
        .then(data => {
            // Ei line ta add koro console log er jonno
            console.log(data);
            
            let html = '<h3>Search Results:</h3>';
            
            // Check if books array exists and has items
            if(data.books && data.books.length > 0) {
                for(let i = 0; i < data.books.length; i++) {
                    html += `<div style="border:1px solid #ccc; margin:10px; padding:10px;">
                        <h3>${data.books[i].Title}</h3>
                        <p>Author: ${data.books[i].Author}</p>
                        <p>Price: $${data.books[i].Price}</p>
                        <a href="book_detail.php?id=${data.books[i].ID}">View Details</a>
                    </div>`;
                }
            } else {
                html = '<h3>No books found</h3>';
            }
            
            document.getElementById('results').innerHTML = html;
        })
        .catch(error => {
            console.log('Error:', error);
            alert('Search failed');
        });
}


updateCartCount();
</script>

</body>
</html>