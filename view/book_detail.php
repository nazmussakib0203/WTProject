<?php
require_once '../config/db.php';
require_once '../model/mydb.php';
require_once '../control/cart_helper.php';

$id = $_GET['id'];
$mydb = new MyDBFunctions();
$conn = $mydb->createConn();
$result = $mydb->getBookById($id, $conn);
$book = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $book['Title']; ?></title>
</head>
<body>

<div style="background:#333; color:white; padding:10px;">
    <a href="home.php" style="color:white;">Home</a> | 
    <a href="cart.php" style="color:white;">Cart (<span id="cart-count">0</span>)</a>
</div>

<div style="padding:20px;">
    <h2><?php echo $book['Title']; ?></h2>
    <p><strong>Author:</strong> <?php echo $book['Author']; ?></p>
    <p><strong>Description:</strong> <?php echo $book['Description']; ?></p>
    <p><strong>Price:</strong> $<?php echo $book['Price']; ?></p>
    <p><strong>Stock:</strong> <?php echo $book['Stock']; ?> available</p>
    
    <?php if($book['Stock'] > 0): ?>
        <div>
            <label>Quantity:</label>
            <input type="number" id="quantity" value="1" min="1" max="<?php echo $book['Stock']; ?>">
            <button onclick="addToCart(<?php echo $book['ID']; ?>)">Add to Cart</button>
        </div>
    <?php else: ?>
        <p style="color:red;">Out of Stock!</p>
    <?php endif; ?>
    
    <div id="message"></div>
</div>

<script>
function updateCartCount() {
    fetch('../control/cart_count_process.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('cart-count').innerText = data.count;
        });
}

function addToCart(bookId) {
    let quantity = document.getElementById('quantity').value;
    
    fetch('../control/add_to_cart_process.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'book_id=' + bookId + '&quantity=' + quantity
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('message').innerHTML = '<span style="color:green;">✓ Added to cart!</span>';
            updateCartCount();
            setTimeout(() => {
                document.getElementById('message').innerHTML = '';
            }, 2000);
        } else {
            document.getElementById('message').innerHTML = '<span style="color:red;">✗ ' + data.message + '</span>';
        }
    });
}

updateCartCount();
</script>

</body>
</html>